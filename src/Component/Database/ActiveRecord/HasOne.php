<?php

namespace Xand\Component\Database\ActiveRecord;
use Xand\Component\Database\Query\Condition;

/**
 * Class HasOne
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class HasOne extends Assoc
{
    /**
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $value
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     *
     * @throws \Exception
     */
    public function set(ActiveRecord $value, ActiveRecord $source)
    {
        if ($value instanceof $this->dstClass)
            throw new \Exception("Unexpected class");

        $dstClass = $this->dstClass;
        $srcClass = $this->srcClass;

        if ($source->isNew()) {
            try
            {
                $value->__set($dstClass::getPrimaryKey(), null);
            } catch(\Exception $e) {}
        } else {
            try
            {
                $value->__set($this->foreignKey, $source->__get($srcClass::getPrimaryKey()));
                $value->save();
            } catch(\Exception $e) {}
        }

        $this->value = $value;
    }

    public function get(ActiveRecord $source, $force = false)
    {
        if (!$this->value instanceof $this->dstClass || $force) {
            if ($source->isNew())
                return null;

            $dstClass = $this->dstClass;
            $srcClass = $this->srcClass;

            $dstForeignKey = $this->foreignKey;
            $srcPrimaryKeyValue = $source->__get($srcClass::getPrimaryKey());

            $this->value = $dstClass::find([
                "condition" => function(Condition $cond) use($dstForeignKey, $srcPrimaryKeyValue) {
                    $cond->eq($dstForeignKey, $srcPrimaryKeyValue);
                }
            ]);
        }

        return $this->value;
    }
}