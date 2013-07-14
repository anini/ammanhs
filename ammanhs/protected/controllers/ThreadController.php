<?php

class ThreadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','threads','recent','top'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','me','vote'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$is_guest=true;
		$thread_voted=false;
		$with='replies';
		if(!Yii::app()->user->isGuest){
			$is_guest=false;
			$with.=', replies.my_up_vote, replies.my_down_vote';
			$thread_vote=ThreadVote::model()->findByAttributes(array('user_id'=>Yii::app()->user->id, 'thread_id'=>$id));
			if($thread_vote){
				if($thread_vote->vote_type==Constants::VOTE_UP) $thread_voted='up';
				else $thread_voted='down';
			}
		}

		$model=Thread::model()->with($with)->findByPk($id);

		if($model->publish_status<Constants::PUBLISH_STATUS_DRAFT){
			Yii::app()->user->setFlash('flash', array(
                    'status'=>'error',
                    'message'=>Yii::t('core', 'Sorry! This is thread is no longer available.')
                ));
                $this->redirect(array('index'));
		}

		if(!isset(Yii::app()->session['viewed_threads']) || !in_array($model->id, Yii::app()->session['viewed_threads'])){
			if(!isset(Yii::app()->session['viewed_threads'])) Yii::app()->session['viewed_threads']=array();
			$viewed_threads=Yii::app()->session['viewed_threads'];
			$viewed_threads[]=$model->id;
			Yii::app()->session['viewed_threads']=$viewed_threads;
			$model->stat_views++;
			$model->save(false);
		}

		$thread_replies=$model->replies;
		$thread_reply=new ThreadReply;
		
		
		$this->render('view',array(
			'model'=>$model,
			'thread_reply'=>$thread_reply,
			'thread_voted'=>$thread_voted,
			'thread_replies'=>$thread_replies,
			'is_guest'=>$is_guest,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Thread;

		$this->performAjaxValidation($model);

		if(isset($_GET['title'])) $model->title=$_GET['title'];

		if(isset($_POST['Thread']))
		{
			$parser=new CMarkdownParser;
    		$_POST['Thread']['content']=$parser->safeTransform($_POST['Thread']['content']);
			$model->attributes=$_POST['Thread'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Thread']))
		{
			$model->attributes=$_POST['Thread'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request(triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$threads=Thread::model()->findAll(array(
				'order'=>'created_at desc',
				'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
				));
		$this->render('index',array(
			'threads'=>$threads,
			'type'=>'recent',
		));
	}

	public function actionRecent()
	{
		$threads=Thread::model()->findAll(array(
			'order'=>'created_at desc',
			'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
			));
		
		$this->render('index',array(
			'threads'=>$threads,
			'type'=>'recent',
		));
	}

	public function actionTop()
	{
		$threads=Thread::model()->findAll(array(
			'order'=>'stat_replies desc, stat_votes desc, stat_views desc, created_at desc',
			'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
			));
		
		$this->render('index',array(
			'threads'=>$threads,
			'type'=>'top',
		));
	}

	public function actionMe()
	{
		$threads=Thread::model()->findAll(array(
			'order'=>'created_at desc',
			'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT.' AND user_id='.Yii::app()->user->id));
		
		$this->render('index',array(
			'threads'=>$threads,
			'type'=>'me',
		));
	}


	public function actionThreads($type){
		//This action should only be called via Ajax
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect(array('/thread#me'));
        }
		switch($type){
			case '1':
				if(Yii::app()->user->isGuest){
					Yii::app()->user->returnUrl='/thread#me';
					$login_form=new LoginForm;
					return $this->renderPartial('//user/login', array('model'=>$login_form));
				}
				$threads=Thread::model()->findAll(array(
					'order'=>'created_at desc',
					'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT.' AND user_id='.Yii::app()->user->id));
				$type='me';
				break;
			case '2':
				$threads=Thread::model()->findAll(array(
					'order'=>'stat_replies desc',
					'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
					));
				$type='top';
				break;
			default:
				$threads=Thread::model()->findAll(array(
					'order'=>'created_at desc',
					'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
					));
				$type='recent';
				break;
		}
		return $this->renderPartial('_threads', array('threads'=>$threads, 'type'=>$type));
	}

	public function actionVote()
	{
		if(empty($_POST['Vote']) || !Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, 'Bad request.');
        }

        $thread_id=$_POST['Vote']['thread_id'];
        $vote_type=$_POST['Vote']['type'];
        $user_id=Yii::app()->user->id;
        $thread=Thread::model()->findByPk($thread_id);
        $thread_vote=ThreadVote::model()->findByAttributes(array('user_id'=>$user_id, 'thread_id'=>$thread_id));
        
        if(!$thread_vote){
        	$thread_vote=new ThreadVote();
        	$thread_vote->thread_id=$thread_id;
        }elseif($thread_vote->vote_type==$vote_type){
        	Yii::app()->end();
        }

        $thread_vote->vote_type=$vote_type;
        
        if($thread_vote->save()){
        	$errno=0;	
        }else{
        	$errno=1;
        }

        if($thread->updateStatVotes())
        	$stat_votes=$thread->stat_votes;
        
        $r=array('errno'=>$errno, 'vote_type'=>$vote_type, 'stat_votes'=>$stat_votes);
        $json=CJSON::encode($r);
        header('Content-type: text/javascript; charset=UTF-8');
        echo $json;  
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='main';
		$model=new Thread('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Thread']))
			$model->attributes=$_GET['Thread'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Thread::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='thread-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
