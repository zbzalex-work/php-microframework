<?php

namespace Xand\Component\Database\ActiveRecord;

/**
 * Class Assoc
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Assoc
{
    /**
     * @var mixed|void
     */
    protected $dstClass;

    /**
     * @var string
     */
    protected $srcClass;

    /**
     * @var \Xand\Component\Database\ActiveRecord\ActiveRecord
     */
    protected $value;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $foreignKey;

    /**
     * Assoc constructor.
     *
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     * @param                                                    $dst
     * @param array                                              $options
     */
    public function __construct(ActiveRecord $source, $dst, array $options = [])
    {
        if (!isset($options['foreign_key']))
            throw new \InvalidArgumentException();

        $this->srcClass = \get_class($source);
        $this->dstClass = isset($options['class']) ? $options['class'] : $dst;
        if (isset($options['class'])) unset($options['class']);
        $this->foreignKey = $options['foreign_key'];
        unset($options['foreign_key']);

        $this->options = $options;
    }

    public function get(ActiveRecord $src) {}
    public function set(ActiveRecord $dst, ActiveRecord $src) {}

    /**
     * @return bool
     */
    public function needsSaving()
    {
        return $this->value instanceof $this->dstClass && ($this->value->isNew() || $this->value->isModified());
    }

    /**
     * @param \Xand\Component\Database\ActiveRecord\ActiveRecord $source
     *
     * @throws \Xand\Component\Database\Exception\ActiveRecordException
     */
    public function delete(ActiveRecord $source)
    {
        if (isset($this->options['depend'])) {
            $this->get($source);
            if (\is_array($this->value)) {
                foreach($this->value as $obj) {
                    $obj->delete();
                }
            } else if (null !== $this->value) {
                $this->value->delete();
            }
        }
    }
}