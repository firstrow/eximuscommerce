<?php

class CommentsModule extends BaseModule
{
	/**
	 * @var string
	 */
	public $moduleName = 'comments';

	/**
	 * Init module
	 */
	public function init()
	{
		$this->setImport(array(
			'comments.models.Comment',
		));
	}

}