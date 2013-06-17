<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionTest(){
		$this->layout=false;
		$user=User::model()->findByPk(1);
		$body=$this->renderPartial("/emailTemplates/user/welcome_email", array('user'=>$user), true);
		echo $this->renderPartial("/emailTemplates/layout", array('content'=>$body), true);
	}

	public function actionRefreshHeader(){
		$this->layout=false;
        $this->renderPartial('//layouts/_header');
	}

	public function actionRefreshSidebar(){
		$this->layout=false;
        $this->renderPartial('//layouts/_sidebar');
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('404', $error);
	    }
	}

	/**
	 * Displays the about page
	 */
	public function actionAbout()
	{
		$this->layout='column2';
	    $this->render('about');
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		if(!isset($_GET['modal'])){
			$hash='#contact';
            $this->redirect('/'.$hash);
        }

		$this->layout=false;
		$model=new ContactForm;
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['admin_email'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact', Yii::t('core' ,'Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
}