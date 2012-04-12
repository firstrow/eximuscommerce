Usage:

1. Connect behavior to AR model
    'comments' => array(
        'class'       => 'comments.components.CommentBehavior',
        'class_name'  => 'store.models.StoreProduct', // Alias to commentable model
        'owner_title' => 'name', // Attribute name to present comment owner in admin panel
    )
2. Update view where to enable comments
    ...
    $this->renderPartial('comments.views.comment.create', array(
        'model'=>$model, // Commentable model instance
    ));
    ...
3. Add captcha action
    ...
    public function actions(){
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
        );
    }
    ...