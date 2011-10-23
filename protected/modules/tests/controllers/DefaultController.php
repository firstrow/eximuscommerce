<?php

class TestForm extends CFormModel {
	public $username;
	public $password;
	public $email;
	public $firstName;
	public $lastName;

	public function rules()
	{
		return array(
			array('username,password,email,firstName,lastName','required'),
		);
	}
}

class DefaultController extends SAdminController {
	
	public function actionIndex()
	{
		$model = new TestForm;
		$form = new STabbedForm($this->form(), $model);

		$this->render('index', array(
			'form'=>$form,
		));
	}

	public function form()
	{
		return array(
		    'elements'=>array(
		        'user'=>array(
		            'type'=>'form',
		            'title'=>'Данные для входа',
		            'elements'=>array(
		                'username'=>array(
		                    'type'=>'text',
		                ),
		                'password'=>array(
		                    'type'=>'password',
		                ),
		                'email'=>array(
		                    'type'=>'text',
		                )
		            ),
		        ),
		 
		        'profile'=>array(
		            'type'=>'form',
		            'title'=>'Профиль',
		            'elements'=>array(
		                'firstName'=>array(
		                    'type'=>'text',
		                ),
		                'lastName'=>array(
		                    'type'=>'text',
		                ),
		            ),
		        ),
		    ),
		 
		    'buttons'=>array(
		        'register'=>array(
		            'type'=>'submit',
		            'label'=>'Зарегистрироваться',
		        ),
		    ),
		);
	}

}