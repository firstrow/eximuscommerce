<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * @var string
	 */
	public $pageKeywords;

	/**
	 * @var string
	 */
	public $pageDescription;

	/**
	 * @var string
	 */
	private $_pageTitle;

	/**
	 * Set layout and view
	 * @param mixed $model
	 * @param string $view Default view name
	 * @return string
	 */
	protected function setDesign($model, $view)
	{
		// Set layout
		if ($model->layout)
			$this->layout = $model->layout;

		// Use custom page view
		if ($model->view)
			$view = $model->view;

		return $view;
	}

	/**
	 * @param $message
	 */
	public  function addFlashMessage($message)
	{
		$currentMessages = Yii::app()->user->getFlash('messages');

		if (!is_array($currentMessages))
			$currentMessages = array();

		Yii::app()->user->setFlash('messages', CMap::mergeArray($currentMessages, array($message)));
	}

	public function setPageTitle($title)
	{
		$this->_pageTitle=$title;
	}


	public function getPageTitle()
	{
		$title=Yii::app()->settings->get('core', 'siteName');
		if(!empty($this->_pageTitle))
			$title=$this->_pageTitle.=' / '.$title;
		return $title;
	}
}