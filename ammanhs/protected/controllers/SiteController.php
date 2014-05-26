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

	public function actionUpdateThreadsUniqueTitles(){
		if(Yii::app()->user->isGuest || Yii::app()->user->model->id!=1) die('-_-');
		$threads=Thread::model()->findAll();
		foreach($threads as $t){
			$t->generateUniqueTitle(true);
			echo $t->uq_title.'<br>';
		}
		exit();
	}

	public function actionFix(){
		if(Yii::app()->user->isGuest || Yii::app()->user->model->id!=1) die('-_-');
		die('This is really dangerous!');
		Yii::app()->db->createCommand(
			"drop table tbl_user_log;"
		)->execute();
		Yii::app()->db->createCommand(
			"rename table tbl_user_log_old to tbl_user_log;"
		)->execute();

		$data = Yii::app()->db->createCommand(
			"
			select * from
			(
				select
					user_id,
					'Add' as action,
					id as thread_id,
					null as thread_reply_id,
					null as activity_reply_id,
					null as targeted_user_id,
					concat('/thread/', id) as uri,
					3 as points_earned,
					created_at
				from
					tbl_thread
				where
					publish_status>=0

				UNION ALL

				select
					user_id,
					'Add' as action,
					null as thread_id,
					id as thread_reply_id,
					null as activity_reply_id,
					null as targeted_user_id,
					concat('/thread/', thread_id, '/#reply-', id) as uri,
					1 as points_earned,
					created_at
				from
					tbl_thread_reply
				where
					publish_status>=0

				UNION ALL

				select
					user_id,
					'Add' as action,
					null as thread_id,
					null as thread_reply_id,
					id as activity_reply_id,
					null as targeted_user_id,
					concat('/activity/', activity_id, '/#reply-', id) as uri,
					1 as points_earned,
					created_at
				from
					tbl_activity_reply
				where
					publish_status>=0

				UNION ALL

				select
					user_id,
					case when (vote_type = 1) then 'VoteUp' else 'VoteDown' end as action,
					thread_id,
					null as thread_reply_id,
					null as activity_reply_id,
					null as targeted_user_id,
					concat('/thread/', thread_id) as uri,
					0 as points_earned,
					(case when (updated_at is null) then created_at else updated_at end) as created_at
				from
					tbl_thread_vote

				UNION ALL

				select
					user_id,
					case when (vote_type = 1) then 'VoteUp' else 'VoteDown' end as action,
					null as thread_id,
					thread_reply_id,
					null as activity_reply_id,
					null as targeted_user_id,
					concat('/thread/', (select thread_id from tbl_thread_reply where id = thread_reply_id), '/#reply-', thread_reply_id) as uri,
					0 as points_earned,
					(case when (updated_at is null) then created_at else updated_at end) as created_at
				from
					tbl_thread_reply_vote

				UNION ALL

				select
					id as user_id,
					'Join' as action,
					null as thread_id,
					null as thread_reply_id,
					null as activity_reply_id,
					null as targeted_user_id,
					concat('/u/', id) as uri,
					0 as points_earned,
					created_at
				from
					tbl_user
			) as a

			order by created_at
			"
		)->queryAll();
		$str_data='';
		$count=sizeof($data);
		foreach($data as $k=>$record){
			$str_data.='('.
				$record['user_id'].',"'.
				$record['action'].'",'.
				(is_null($record['thread_id'])?'null':$record['thread_id']).','.
				(is_null($record['thread_reply_id'])?'null':$record['thread_reply_id']).','.
				(is_null($record['activity_reply_id'])?'null':$record['activity_reply_id']).','.
				(is_null($record['targeted_user_id'])?'null':$record['targeted_user_id']).',"'.
				$record['uri'].'",'.
				$record['points_earned'].','.
				$record['created_at'].
				')';
			if($k<$count-1) $str_data.=',';
		}

		Yii::app()->db->createCommand(
			"
			CREATE TABLE tbl_user_log_temp
			(
				id int(11) NOT NULL AUTO_INCREMENT,
				user_id int(11) NOT NULL,
				action enum('Add','Edit','VoteUp','VoteDown','Follow','Join','Unsubscribe') NOT NULL DEFAULT 'Add',
				thread_id int(11) DEFAULT NULL,
				thread_reply_id int(11) DEFAULT NULL,
				targeted_user_id int(11) DEFAULT NULL,
				uri varchar(256) DEFAULT NULL,
				points_earned int(11) NOT NULL DEFAULT '0',
				created_at int(11) DEFAULT NULL,
				activity_reply_id int(11) DEFAULT NULL,
				PRIMARY KEY (id),
				KEY ix_tbl_user_log_user_id (user_id),
				KEY ix_tbl_user_log_action (action),
				KEY ix_tbl_user_log_thread_id (thread_id),
				KEY ix_tbl_user_log_thread_reply_id (thread_reply_id),
				KEY ix_tbl_user_log_targeted_user_id (targeted_user_id),
				KEY ix_tbl_user_log_created_at (created_at),
				KEY ix_tbl_user_log_activity_reply_id (activity_reply_id)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
			"
		)->execute();

		Yii::app()->db->createCommand(
			'insert into tbl_user_log_temp
				(
					user_id,
					action,
					thread_id,
					thread_reply_id,
					activity_reply_id,
					targeted_user_id,
					uri,
					points_earned,
					created_at
				)
				values '.$str_data.';'
		)->execute();

		Yii::app()->db->createCommand(
			"rename table tbl_user_log to tbl_user_log_old;"
		)->execute();

		Yii::app()->db->createCommand(
			"rename table tbl_user_log_temp to tbl_user_log;"
		)->execute();
	}

	public function actionTest(){
		if(Yii::app()->user->isGuest || Yii::app()->user->model->id!=1) die('-_-');
		$replies=ThreadReply::model()->findAll();
		foreach ($replies as $r){
			$r->scenario='edit';
			$r->save();
		}
		die('done!');
		$threads=Thread::model()->findAll();
		$content='';
		foreach ($threads as $t){
			$content.=$t->content;
		}
		preg_match_all('/<[\s]*img[^src]*src="([^"]*)"[^>]*>/', $content, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
		$sources=array();
		foreach($matches as $matche){
			echo($matche[1][0]);echo("\n");
		}
		die();
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
		/*if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}*/
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
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
			$urls[]=$this->createAbsoluteUrl('site/activitiesSitemap');
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
			$this->renderPartial('_sitemap', array('url'=>Yii::app()->urlManager->createAbsoluteUrl('thread/index')));
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
			$this->renderPartial('_sitemap', array('url'=>Yii::app()->urlManager->createAbsoluteUrl('site/index')));
			// REVIEW: NOTE: might need a limit and loop to avoid out of memory
			$c_users=new CDbCriteria();
			//$c_users->condition="active > 0";
			$users=User::model()->findAll($c_users);
			foreach($users as $user){
				$url=$user->getProfileLink(true);
				$this->renderPartial('_sitemap', array('url'=>$url));
			}
			echo '</urlset>';
			$this->endCache();
		}
	}

	public function actionActivitiesSitemap(){
		header('Content-Type: application/xml');
		if($this->beginCache('activities', array("duration"=>(300*12)))){
			echo
			'<?xml version="1.0" encoding="UTF-8"?>
				<urlset
					xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					xmlns:xhtml="http://www.w3.org/1999/xhtml"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
					>';
			$this->renderPartial('_sitemap', array('url'=>Yii::app()->urlManager->createAbsoluteUrl('activity/index')));
			// REVIEW: NOTE: might need a limit and loop to avoid out of memory
			$c_activities=new CDbCriteria();
			$c_activities->condition='publish_status>='.Constants::PUBLISH_STATUS_DRAFT;
			$activities=Activity::model()->findAll($c_activities);
			foreach($activities as $activity){
				$url=$activity->getLink(true);
				$this->renderPartial('_sitemap', array('url'=>$url));
			}
			echo '</urlset>';
			$this->endCache();
		}
	}
}