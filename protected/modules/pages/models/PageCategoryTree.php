<?php

class PageCategoryTree {
	
	public $categories;
	public $level = -1;
	public $result = array();

	public function __construct($categories)
	{
		$this->categories = $categories;
	}

	public function buildTree($parentId = null)
	{
		$this->level++;
		foreach($this->categories as $category)
		{
			if ($category->parent_id == $parentId)
			{
				$category->level = $this->level;

				$this->result[$category->id] = $category;
				$this->buildTree($category->id);
			}
		}
		$this->level--;

		return $this->result;
	}

}