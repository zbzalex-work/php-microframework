<?php

namespace Xand\Component\Database\ActiveRecord;
use Xand\Component\Database\Exception\ActiveRecordException;
use Xand\Component\Database\Query\Condition;

/**
 * Class HasMany
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class HasMany extends Assoc
{
    public function get(ActiveRecord $source, $force = false)
    {

        if (!\is_array($this->value) || $force) {
            if ($source->isNew()) {
                $this->value = [];
            } else {

                /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $dstClass */
                $dstClass = $this->dstClass;
                /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $srcClass */
                $srcClass = $this->srcClass;

                $dstForeignKey = $this->foreignKey;
                $srcPrimaryKeyValue = $source->__get($srcClass::getPrimaryKey());

                $this->value = (array)$dstClass::findAll([
                    "condition" => function(Condition $cond) use($dstForeignKey, $srcPrimaryKeyValue) {
                        $cond->eq($dstForeignKey, $srcPrimaryKeyValue);
                    }
                ]);
            }
        }

        return $this->value;
    }

    /**
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     * @param bool                                               $force
     *
     * @return array
     */
    public function getIds(ActiveRecord $source, $force = false)
    {
        $idsStack = [];

        /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord[] $objStack */
        $objStack = $this->get($source, $force);

        /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $dstClass */
        $dstClass = $this->dstClass;

        foreach($objStack as $obj) {
            $idsStack[] = $obj->__get($dstClass::getPrimaryKey());
        }

        return $idsStack;
    }

//    public function setIds($idsStack, ActiveRecord $source)
//    {
//
//        $this->get($source, true);
//
//        $existingIdsStack = $this->getIds($source, false);
//
//        $newIdsStack = \array_diff($idsStack, $existingIdsStack);
//        $unaccordedIdsStack = \array_diff($existingIdsStack, $idsStack);
//        $dstClass = $this->dstClass;
//
//        if ($newIdsStack) {
//            $objStack = $dstClass::findAllByIds($newIdsStack);
//            $this->push($objStack, $source);
//        }
//
//        if ($unaccordedIdsStack) {
//            $objStack = $dstClass::findAllByIds($unaccordedIdsStack);
//            $this->breakUp($objStack, $source);
//        }
//    }

//    public function push(array $objStack, ActiveRecord $source)
//    {
//        foreach($objStack as $object) {
//            if (($source->is_new_record() || $object->is_new_record())
//                && isset($this->options['through']) && $this->options['through'])
//                throw new ActiveRecordException("HasManyThroughCantAssociateNewRecords", ActiveRecordException::HasManyThroughCantAssociateNewRecords);
//            if (!$object instanceof $this->dest_class) {
//                throw new ActiveRecordException("Expected class: {$this->dest_class}; Received: ".get_class($object), ActiveRecordException::UnexpectedClass);
//            }
//            if ($source->is_new_record()) {
//                /* we want to save $object after $source gets saved */
//                $object->set_modified(true);
//            }
//            elseif (!isset($this->options['through']) || !$this->options['through']) {
//                /* since source exists, we always want to save $object */
//                $object->{$this->foreign_key} = $source->{$source->get_primary_key()};
//                $this->get($source);
//                $object->save();
//            }
//            elseif ($this->options['through']) {
//                /* $object and $source are guaranteed to exist in the DB */
//                $this->get($source);
//                $skip = false;
//                foreach ($this->value as $val)
//                    if ($val == $object) $skip = true;
//                if (!$skip) {
//                    $through_class = ActiveRecordInflector::classify($this->options['through']);
//                    $fk_1 = ActiveRecordInflector::foreign_key($this->dest_class);
//                    $fk_2 = ActiveRecordInflector::foreign_key($this->source_class);
//                    $k1   = $object->{$object->get_primary_key()};
//                    $k2   = $source->{$source->get_primary_key()};
//                    $through = new $through_class( array($fk_1 => $k1, $fk_2 => $k2) );
//                    $through->save();
//                }
//            }
//            $this->get($source);
//            array_push($this->value, $object);
//        }
//    }

//    public function breakUp(array $objStack, ActiveRecord $source)
//    {
//
//    }

    /**
     * @return bool
     */
    public function needsSaving()
    {
        if (!\is_array($this->value))
            return false;

        foreach($this->value as $value) {
            /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $value */
            if ($value->isModified() || $value->isNew()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     *
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function saveIfNeeded(ActiveRecord $source)
    {
        foreach($this->value as $obj) {
            /** @var \Xand\Component\Database\ActiveRecord\ActiveRecord $obj */
            if ($obj->isModified() || $obj->isNew()) {
//                if (!isset($this->options['through']) || !$this->options['through'])
//                    $value->{ $this->foreignKey } = $source->{ $source->getPrimaryKey() };

                $obj->save();
            }
        }
    }
}