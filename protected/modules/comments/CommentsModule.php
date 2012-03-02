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

	public function processRequest($model)
	{
		$comment = new Comment;
		if(Yii::app()->request->isPostRequest)
		{
			$comment->attributes = Yii::app()->request->getPost('Comment');

			if(!Yii::app()->user->isGuest)
			{
				$comment->name = Yii::app()->user->name;
				$comment->email = Yii::app()->user->email;
			}

			if($comment->validate())
			{
				$pkAttr = $model->getObjectPkAttribute();
				$comment->class_name = $model->getClassName();
				$comment->object_pk = $model->$pkAttr;
				$comment->user_id = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
				$comment->save();

				// Refresh page
				Yii::app()->request->redirect(Yii::app()->getRequest()->getUrl(), true);
			}
		}
		return $comment;
	}

}