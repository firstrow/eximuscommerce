<?php

class PageCategoryTree {
	
	public $categories = array();
	public $result = array();

	public $path = array();
	public $level = -1;

	public function __construct($categories = null)
	{
		if ($categories === null)
			$this->categories = PageCategory::model()->findAll();
		else
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
				$this->path[] = $category->url;

				$category->level = $this->level;
				$category->path = implode('/', $this->path);

				$this->result[$category->id] = $category;
				$this->buildTree($category->id);

				array_pop($this->path);
			}
		}
		$this->level--;

		return $this->result;
	}

	/**
	 * Rebuild ful_url after category save.
	 */
	public function rebuildFullUrl()
	{
        $this->buildTree();
        foreach ($this->result as $category) 
        {
        	$category->full_url = $category->path;
        	$category->save(false);
        }
	}

	/**
	 * Get category from tree by id.
	 * @param type $id 
	 * @return PageCategory
	 */
	public function getById($id)
	{
		return $this->result[$id];
	}

}