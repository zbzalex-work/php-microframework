<?php

namespace Xand\Component\Database;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use Xand\Component\Database\Query\Condition;
use Xand\Component\Database\Query\Limit;
use Xand\Component\Database\Query\Order;

/**
 * Class GenericModel
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class GenericModel extends Model
{
    /**
     * @var Order[]
     */
    protected $order = [];

    /**
     * @var Limit|null
     */
    protected $limit;

    /**
     * @return static
     */
    public static function newInstance()
    {
        return new static();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return '';
    }

    /**
     * @param Order $order
     *
     * @return static
     */
    public function addOrder(Order $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * @param Limit $limit
     *
     * @return static
     */
    public function setLimit(Limit $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return null|Limit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return OODBBean
     */
    public function create()
    {
        return R::xdispense($this->getType());
    }

    /**
     * @param int   $id
     *
     * @return OODBBean
     */
    public function load($id)
    {
        return R::load($this->getType(), $id);
    }

    /**
     * @param int[] $ids
     *
     * @return OODBBean[]
     */
    public function loadAll(array $ids)
    {
        return R::loadAll($this->getType(), $ids);
    }

    /**
     * @param array $ids
     *
     * @return \RedBeanPHP\OODBBean[]
     */
    public function findAllByIds(array $ids)
    {
        return $this->getAll($ids);
    }

    /**
     * @param int   $id
     *
     * @return NULL|OODBBean
     */
    public function get($id)
    {
        return R::findOne($this->getType(), 'id=?', [
            $id
        ]);
    }

    /**
     * @param int $id
     *
     * @return NULL|\RedBeanPHP\OODBBean
     */
    public function findById($id)
    {
        return $this->get($id);
    }

    /**
     * @param int[] $ids
     *
     * @return OODBBean[]
     */
    public function getAll(array $ids = [])
    {
        return R::loadAll($this->getType(), $ids);
    }

    /**
     * @param null|string   $sql
     * @param array         $params
     *
     * @return int
     */
    public function count($sql = null, array $params = [])
    {
        return R::count($this->getType(), $sql, $params);
    }

    /**
     * @param null|string                       $sql
     * @param array<string, string>|string[]    $params
     *
     * @return array
     */
    public function find($sql = null, array $params = [])
    {
        $sql = null === $sql ? "" : $sql;

        $orderSql = [];
        foreach($this->order as $order) {
            $orderSql[] = $order->toSql(false);
        }

        if ($orderSql)
            $sql.= ' ORDER BY ' . \implode(", ", $orderSql);

        if (null !== $this->limit)
            $sql.= ' ' . $this->limit->toSql();

        return $this->findAll($sql, $params);
    }

    /**
     * @param string                            $sql
     * @param array<string, string>|string[]    $params
     *
     * @return NULL|OODBBean
     */
    public function findOne($sql = null, array $params = [])
    {
        return R::findOne($this->getType(), $sql, $params);
    }

    /**
     * @param string                            $sql
     * @param array<string, string>|string[]    $params
     *
     * @return array
     */
    public function findAll($sql = null, array $params = [])
    {
        return R::findAll($this->getType(), $sql, $params);
    }
}