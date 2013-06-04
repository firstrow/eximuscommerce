<?php

/**
 * Base class for all admin controllers.
 */
class SAdminController extends RController
{

	public $layout='application.modules.admin.views.layouts.main';

	/**
	 * Top menu
	 * @var array
	 */
	public $menu=array();

	/**
	 * @var array
	 */
	public $breadcrumbs=array();

	/**
	 * @var string
	 */
	public $pageHeader = '';

	/**
	 * Buttons to display
	 * @var null array
	 */
	public $topButtons = null;

	/**
	 * Initialize component
	 */
	public function init()
	{
		Yii::app()->user->loginUrl = '/admin/auth';
		$this->module->initAdmin();
	}

	/**
	 * @return array
	 */
	public function filters()
	{
		return array('rights');
	}

	/**
	 * @param CAction $action
	 * @return bool
	 */
	public function beforeAction($action)
	{
		// Allow only authorized users access
		if (Yii::app()->user->isGuest && get_class($this) !== 'AuthController')
			Yii::app()->request->redirect($this->createUrl('/admin/auth'));

		Yii::app()->errorHandler->errorAction = '/admin/errors/error';

		return true;
	}

	/**
	 * Extends parent method.
	 * Call renderPartial() instead of render() on ajax request.
	 *
	 * @param  $view
	 * @param null $data
	 * @param bool $return
	 */
	public function render($view,$data=null,$return=false)
	{
		if (Yii::app()->request->isAjaxRequest === true)
			parent::renderPartial($view, $data, $return, false);
		else
			parent::render($view, $data, $return);
	}

	/**
	 * Redirect after save object. Used with SAdminTopButtons.
	 *
	 * @param $model
	 */
	public function smartRedirect($model)
	{
		if (!isset($_POST['REDIRECT']) || Yii::app()->request->isAjaxRequest === true)
			return;

		if (substr($_POST['REDIRECT'], 0) === '/')
			$this->redirect($_POST['REDIRECT']);
		elseif ($_POST['REDIRECT'] === 'update')
			$this->redirect($this->createUrl($_POST['REDIRECT'], array('id' => $model->primaryKey)));
		else
			$this->redirect($this->createUrl($_POST['REDIRECT']));
	}

	/**
	 * Set flash messages.
	 *
	 * @param string $message
	 */
	public function setFlashMessage($message)
	{
		$currentMessages = Yii::app()->user->getFlash('messages');

		if (!is_array($currentMessages))
			$currentMessages = array();

		Yii::app()->user->setFlash('messages', CMap::mergeArray($currentMessages, array($message)));
	}

}
