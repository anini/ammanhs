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
			var_dump($model->ref);die();
			if($model->validate())
			{
				Mailer::sendTemplatedEmail(Yii::app()->params['admin_email'], $model->subject, 'admin/contact_us', array('user_id'=>(Yii::app()->user->isGuest?0:Yii::app()->user->id), 'contact_form'=>$model, 'user_ip'=>IPDetector::clientIP()));
				Yii::app()->user->setFlash('contact', Yii::t('core' ,'Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionSitemap()
	{
		header('Content-Type: application/xml');
		$urls=array();
		if($this->beginCache('ammanhs', array("duration"=>(3600*12)))){
			$urls[]=$this->createAbsoluteUrl('site/threadsSitemap');
			$urls[]=$this->createAbsoluteUrl('site/usersSitemap');
			$this->renderPartial('sitemap',array('urls'=>$urls));
			$this->endCache();
		}
	}

	public function actionThreadsSitemap(){
		header('Content-Type: application/xml');
		if($this->beginCache('threads', array("duration"=>(300*12)))){
			echo
			'<?xml version="1.0" encoding="UTF-8"?>
				<urlset
					xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					xmlns:xhtml="http://www.w3.org/1999/xhtml"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
					>';
			// REVIEW: NOTE: might need a limit and loop to avoid out of memory
			$c_threads=new CDbCriteria();
			$c_threads->condition='publish_status>='.Constants::PUBLISH_STATUS_DRAFT;
			$threads=Thread::model()->findAll($c_threads);
			foreach($threads as $thread){
				$url=$thread->getLink(true);
				$this->renderPartial('_sitemap', array('url'=>$url));
			}
			echo '</urlset>';
			$this->endCache();
		}
	}

	public function actionUsersSitemap(){
		header('Content-Type: application/xml');
		if($this->beginCache('users', array("duration"=>(300*12)))){
			echo
			'<?xml version="1.0" encoding="UTF-8"?>
				<urlset
					xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					xmlns:xhtml="http://www.w3.org/1999/xhtml"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
					>';
			// REVIEW: NOTE: might need a limit and loop to avoid out of memory
			$c_users=new CDbCriteria();
			$c_users->select='id';
			//$c_users->condition="active > 0";
			$users=User::model()->findAll($c_users);
			foreach($users as $user){
				$url=$user->profileLink;
				$this->renderPartial('_sitemap', array('url'=>$url));
			}
			echo '</urlset>';
			$this->endCache();
		}
	}

}