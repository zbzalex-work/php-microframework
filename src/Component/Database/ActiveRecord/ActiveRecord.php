<?php

namespace Xand\Component\Database\ActiveRecord;
use Xand\Component\Database\ConnectionInterface;
use Xand\Component\Database\ConnectionResolver;
use Xand\Component\Database\Exception\ActiveRecordException;
use Xand\Component\Database\Query\Condition;
use Xand\Component\Database\Query\Limit;

/**
 * Class ActiveRecord
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ActiveRecord
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var Assoc[]
     */
    protected $associations = [];

    /**
     * @var bool
     */
    protected $isNew = true;

    /**
     * @var bool
     */
    protected $frozen = false;

    /**
     * @var bool
     */
    protected $isModified = false;

    /**
     * @var ConnectionResolver
     */
    private static $databaseConnectionResolver;

    /**
     * ActiveRecord constructor.
     *
     * @param null $attributes
     * @param bool $isNew
     * @param bool $isModified
     *
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function __construct($attributes = null, $isNew = true, $isModified = false)
    {
        foreach([
            "belongs_to",
                    "has_one",
                    "has_many"] as $type) {

            if (!isset($this->{ $type }))
                continue;

            $assocTypeClass = "\\Xand\\Component\\Database\\ActiveRecord\\"
                . ActiveRecordInflector::classify($type);

            foreach($this->{ $type } as $assoc) {
                $key = \key($assoc);
                $this->__set($key, new $assocTypeClass($this, $key, \current($assoc)));
            }
        }

        if (\is_array($attributes)) {

            foreach($attributes as $key => $value) {
                $this->__set($key, $value);
            }

            $this->isModified = $isModified;
            $this->isNew = $isNew;
        }
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function __get($key)
    {
        if (false !== \array_key_exists($key, $this->attributes))
            return $this->attributes[$key];
        else if (false !== \array_key_exists($key, $this->associations))
            return $this->associations[$key]->get($this);
        else if (\in_array($key, static::getColumns()))
            return null;
        else if (\preg_match("/^(.+?)_ids$/i", $key, $matches)) {
            $assoc = $matches[1];
            if ($this->associations[$assoc] instanceOf HasMany)
                return $this->associations[$assoc]->getIds($this);
        }
    }

    /**
     * @param $key
     * @param $value
     *
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function __set($key, $value)
    {
        if ($this->frozen)
            throw new ActiveRecordException("Object frozen");

        if (\preg_match("/^(.+?)_ids$/", $key, $matches)) {
            $name = $matches[1];
        }

        if (\in_array($key, static::getColumns())) {
            $this->attributes[$key] = $value;
            $this->isModified = true;
        } else if ($value instanceof Assoc) {
            $this->associations[$key] = $value;
        } else if (false !== \array_key_exists($key, $this->associations)) {
            $this->associations[$key]->set($value, $this);
        } else if (isset($name) && false !== \array_key_exists($name, $this->associations)
            && $this->associations[$name] instanceof HasMany) {
            $this->associations[$name]->setIds($value, $this);
        }
    }

    /**
     * @param       $name
     * @param array $arguments
     *
     * @return mixed
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function __call($name, array $arguments = [])
    {
        $longestAssoc = "";
        foreach(\array_keys($this->associations) as $assoc) {
            if (0 === \strpos($name, $assoc)
            && \strlen($assoc) > \strlen($longestAssoc)) {
                $longestAssoc = $assoc;
            }
        }

        if (0 != \strlen($longestAssoc)) {
            $method = \current(\explode($longestAssoc . "_", $name));
            $assoc = $this->associations[$longestAssoc];
            try
            {
                $reflector = new \ReflectionMethod(\get_class($assoc), $method);
                $reflector->invoke($assoc, $arguments, $this);
            } catch (\ReflectionException $e) {

            }
        }

        throw new ActiveRecordException(sprintf("Unexpected method or association: %s", $name));
    }

    /**
     * @param \Xand\Component\Database\ConnectionResolver $resolver
     */
    public static function setConnectionResolver(ConnectionResolver $resolver)
    {
        static::$databaseConnectionResolver = $resolver;
    }

    /**
     * @return \Xand\Component\Database\ConnectionResolver
     */
    public static function getConnectionResolver()
    {
        return static::$databaseConnectionResolver;
    }

    /**
     * @return \Xand\Component\Database\ConnectionInterface
     */
    public static function getConnection()
    {
        return ActiveRecord::getConnectionResolver()->getConnection();
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "";
    }

    /**
     * @return string
     */
    public static function getPrimaryKey()
    {
        return "id";
    }

    /**
     * @return string[]
     */
    public static function getColumns()
    {
        return [

        ];
    }

    /**
     * @return bool
     */
    public function isFrozen()
    {
        return $this->frozen;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->isNew;
    }

    /**
     * @return bool
     */
    public function isModified()
    {
        return $this->isModified;
    }

    /**
     * @param bool $isModified
     *
     * @return static
     */
    public function setModified($isModified = true)
    {
        $this->isModified = $isModified;

        return $this;
    }

    /**
     * @return static
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function save()
    {
        foreach($this->associations as $name => $assoc) {
            if (!$assoc instanceof BelongsTo || !$assoc->needsSaving())
                continue;

            $this->__get($name)->save();
        }

        if ($this->isNew) {
            if (\method_exists($this, "beforeSave")) {
                $this->beforeSave();
            }

            $colStack = $valStack = [];
            foreach(static::getColumns() as $column) {
                if ($column == static::getPrimaryKey())
                    continue;
                if (null === $this->__get($column))
                    continue;
                $colStack[] = Condition::quoteParam($column);
//                $valStack[] = \is_null($this->__get($column)) ? "NULL" : "'" . $this->__get($column) . "'";
                $valStack[] = "'" . $this->__get($column) . "'";
            }

            static::getConnection()->executeNativeQuery(sprintf("INSERT INTO %s (%s) VALUES (%s);",
                    Condition::quoteParam(static::getTableName()), \implode(", ", $colStack),
                    \implode(",", $valStack)));

            $this->__set(static::getPrimaryKey(), static::getConnection()->getPdo()->lastInsertId());


            $this->isNew = false;
            $this->isModified = false;

            if (\method_exists($this, "afterSave")) {
                $this->afterSave();
            }

        } else if ($this->isModified) {
            if (\method_exists($this, "beforeUpdate")) {
                $this->beforeUpdate();
            }

            $cond = new Condition();

            $sqlStack = [];
            foreach(static::getColumns() as $column) {
                if ($column == static::getPrimaryKey())
                    continue;
                $sqlStack[] = Condition::quoteParam($column) . "=" . (\is_null($this->__get($column))
                        ? "NULL" : "'" . $this->__get($column) . "'");
            }

            $cond->eq(static::getPrimaryKey(), $this->__get(static::getPrimaryKey()));

            $cond->setLimit(new Limit(null, 1));

            static::getConnection()->executeNativeQuery(sprintf("UPDATE %s SET %s %s;",
                Condition::quoteParam(static::getTableName()), implode(", ", $sqlStack), (string)$cond),
                $cond->getArgs());

            $this->isNew = false;
            $this->isModified = false;

            if (\method_exists($this, "afterUpdate")) {
                $this->afterUpdate();
            }
        }

        foreach($this->associations as $name => $assoc) {
            if ($assoc instanceof HasOne && $assoc->needsSaving()) {
                $this->__get($name)->save();
            } else if ($assoc instanceof HasMany && $assoc->needsSaving()) {
                $assoc->saveIfNeeded($this);
            }
        }

        return $this;
    }

    /**
     * Delete record.
     *
     * @return bool
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function delete()
    {
        if (\method_exists($this, "beforeDelete")) {
            $this->beforeDelete();
        }

        foreach($this->associations as $assoc) {
            $assoc->delete($this);
        }

        $cond = new Condition();

        $cond->eq(static::getPrimaryKey(), $this->__get(static::getPrimaryKey()));

        $cond->setLimit(new Limit(null, 1));

        static::getConnection()->executeNativeQuery(sprintf("DELETE FROM %s %s;",
            Condition::quoteParam(static::getTableName()), $cond->__toString()), $cond->getArgs());

        $this->frozen = true;

        if (\method_exists($this, "afterDelete")) {
            $this->afterDelete();
        }

        return true;
    }

    /**
     * Ensure true options for query.
     *
     * @param array $params
     *
     * @return array
     */
    public static function isValidOptions(array $params = [])
    {
        $options = [];

        if ($params) {
            if (1 == \count($params) && \is_array($params[0])) {
                $options = $params[0];
            } else {

                if (isset($params[0]) && null !== $params[0]) {
                    $options['select']      = $params[0];
                }

                if (isset($params[1])) {
                    $options['condition']   = $params[1];
                }
            }
        }

        return $options;
    }

    /**
     * Find one element.
     *
     * @return array|mixed|\Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    public static function find()
    {
        return static::_find(\get_called_class(), "first",  static::isValidOptions(\func_get_args()));
    }

    /**
     * Find all elements.
     *
     * @return array|mixed|\Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    public static function findAll()
    {
        return static::_find(\get_called_class(), "all",    static::isValidOptions(\func_get_args()));
    }

    /**
     * Find one element by id.
     *
     * @param int $id
     *
     * @return array|mixed|\Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    public static function findById($id)
    {
        return static::_find(\get_called_class(), (int)$id);
    }

    /**
     * Find all elements by ids.
     *
     * @param array $ids
     *
     * @return array|mixed|\Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    public static function findAllByIds(array $ids = [])
    {
        return static::_find(\get_called_class(), \array_map("intval", $ids));
    }

    /**
     * @param null|string   $class
     * @param int|first|all $id
     * @param array         $options
     *
     * @return array|mixed|\Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    public static function _find($class = null, $id, array $options = [])
    {
        /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $class */
        $class = null === $class ? \get_called_class() : $class;

        if (\is_array($id)) {
            $idsStack = [];

            foreach($id as $_id) $idsStack[] = $_id;

            $id = $idsStack;
        }

        // Выборка
        if (!isset($options['select']) || null === $options['select']) {
            $options['select'] = "*";
        }

        $options['select'] = \implode(", ", (array)$options['select']);

        // Условие
        if (!isset($options['condition'])) {
            $options['condition'] = new Condition();
        }

        // Условие может быть замыкание, так и объектом Criteria
        if (\is_callable($options['condition'])) {
            $cb = $options['condition'];
            $options['condition'] = new Condition();
            \call_user_func($cb, $options['condition']);
        } else if (!$options['condition'] instanceof Condition)
            throw new \InvalidArgumentException("Unexpected class for condition option");

        // В случае если мы получили стэк, состоящий ик идентификаторов
        if (\is_array($id)) {
            $options['condition']->in($class::getPrimaryKey(), $id);
        } else if (\is_string($id) && "first" == $id) {
            // Первый результ
            $options['condition']->setLimit(new Limit(null, 1));
        } else if ("all" != $id) {
            // Полного списка результатов
            $options['condition']->eq($class::getPrimaryKey(), $id);
        }

        /** @var \PDOStatement $st */
        $st = $class::getConnection()->executeNativeQuery(\sprintf("SELECT %s FROM %s %s;",
            $options['select'], Condition::quoteParam($class::getTableName()), $options["condition"]->__toString()),
            $options["condition"]->getArgs());

        if (0 != $st->rowCount()) {
            /** @var array $rows */
            $rows = $st->fetchAll();
            /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord[] $objStack */
            $objStack = [];
            foreach($rows as $row) {
                $objStack[] = new $class($row, false);
            }

            if ($objStack) {
                return \is_array($id) || $id == "all" ? \array_values($objStack) : \array_shift($objStack);
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }
}