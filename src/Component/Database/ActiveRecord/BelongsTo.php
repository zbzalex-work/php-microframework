<?php

namespace Xand\Component\Database\ActiveRecord;
use Xand\Component\Database\Query\Condition;
use Xand\Component\Database\Query\Limit;

/**
 * Class BelongsTo
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class BelongsTo extends Assoc
{
    /**
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $value
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     *
     * @throws \Exception
     */
    public function set(ActiveRecord $value, ActiveRecord $source)
    {
        if (!$value instanceof $this->dstClass)
            throw new \Exception("Unexpected class");

        if ($value->isNew()) {
            try
            {
                $source->__set($this->foreignKey, null);
            } catch(\Exception $e) {}
        } else {
            $dstClass = $this->dstClass;
            try
            {
                $source->__set($this->foreignKey, $value->__get($dstClass::getPrimaryKey()));
            } catch(\Exception $e) {}
        }

        $this->value = $value;
    }
    
    public function get(ActiveRecord $source, $force = false)
    {
        if ($this->value instanceof $this->dstClass && !$force) {
            return $this->value;
        }

        $this->value = ActiveRecord::_find($this->dstClass, $source->__get($this->foreignKey), [
            "condition" => function(Condition $cond) {

                $cond->setLimit(new Limit(null, 1));
            }
        ]);

        return $this->value;
    }
}