<?php

class PageCategoryTree {
	
	public $categories = array();
	public $result = array();
	public $level = -1;

	public function __construct($categories)
	{
		$this->categories = $categories;
	}

	/**
	 * Build simple category tree.
	 * @param type $parentId Parent category id. Set category id to get all childs.
	 * @return array
	 */
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