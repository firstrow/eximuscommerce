<?php

/**
 * Present StoreCategory as SJsTree node.
 */
class StoreCategoryNode extends CComponent implements ArrayAccess
{
    /**
     * @var StoreCategory
     */
    protected $model;

    /**
     * @var string category name
     */
    protected $_name;

    /**
     * @var integer category id
     */
    protected $_id;

    /**
     * @var boolean
     */
    protected $_hasChildren;

    /**
     * @var array category children
     */
    protected $_children;

    /**
     * @param StoreCategory $model
     */
    public function __construct(StoreCategory $model)
    {
        $this->model = &$model;
        return $this;
    }

    /**
     * Create nodes from array
     * @static
     * @param array $model
     * @return array
     */
    public static function fromArray($model)
    {
        $result = array();
        foreach ($model as $row)
            $result[] = new StoreCategoryNode($row);
        return $result;
    }

    /**
     * @return bool
     */
    public function getHasChildren()
    {
        return (boolean) $this->model->children()->count();
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return self::fromArray($this->model->children()->findAll());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->model->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->model->id;
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    public function offsetExists($offset) {}
    public function offsetSet($offset, $value) {}
    public function offsetUnset($offset) {}
}
