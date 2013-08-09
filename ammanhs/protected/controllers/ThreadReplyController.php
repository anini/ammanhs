<?php

class ThreadReplyController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','vote'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($thread_id)
	{
		if (empty($_POST['ThreadReply']) || !Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, 'Bad request.');
        }

        $thread = Thread::model()->findByPk($thread_id);
        if(!$thread){
        	throw new CHttpException(404, 'Thread is not exist.');
        }

		$model = new ThreadReply;
		$model->thread_id=$thread_id;
		$parser = new CMarkdownParser;
    	$_POST['ThreadReply']['content'] = $parser->safeTransform($_POST['ThreadReply']['content']);
		$model->attributes = $_POST['ThreadReply'];
	
		if($model->save())
			return $this->renderPartial('view', array('model'=>$model));
		else
			return false;
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

		if(isset($_POST['ThreadReply']))
		{
			$model->attributes=$_POST['ThreadReply'];
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

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ThreadReply');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionVote()
	{
		if (empty($_POST['Vote']) || !Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, 'Bad request.');
        }

        $thread_reply_id=$_POST['Vote']['thread_reply_id'];
        $vote_type=$_POST['Vote']['type'];
        $user_id=Yii::app()->user->id;
        $thread_reply=ThreadReply::model()->findByPk($thread_reply_id);
        $thread_reply_vote=ThreadReplyVote::model()->findByAttributes(array('user_id'=>$user_id, 'thread_reply_id'=>$thread_reply_id));
        
        if (!$thread_reply_vote){
        	$thread_reply_vote=new ThreadReplyVote();
        	$thread_reply_vote->thread_reply_id=$thread_reply_id;
        }elseif($thread_reply_vote->vote_type==$vote_type){
        	Yii::app()->end();
        }

        $thread_reply_vote->vote_type=$vote_type;
        
        if($thread_reply_vote->save()){
        	$errno=0;	
        }else{
        	$errno=1;
        }
        
        if($thread_reply->updateStatVotes())
        	$stat_votes=$thread_reply->stat_votes;

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
		$model=new ThreadReply('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ThreadReply']))
			$model->attributes=$_GET['ThreadReply'];

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
		$model=ThreadReply::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='thread-reply-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
