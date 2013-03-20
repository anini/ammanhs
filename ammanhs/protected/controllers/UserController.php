<?php

class UserController extends Controller
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
				'actions'=>array('view','login','signup'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('profile','logout'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','index','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model for the normal users.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionShow($id)
	{
		$this->layout = null;
		$this->render('show',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Displays a particular model for the admisn with admin links.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$user_feed = $model->getUserFeed();
		$this->render('view',array(
			'model'=>$model,
			'user_feed'=>$user_feed,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User('create');

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->password=md5($model->password);
			if($model->save())
			{
				Yii::app()->user->setFlash('flash', array(
                    'status' => 'success',
                    'message' => 'User has been created successfuly.'
                ));
				$this->redirect(array('view','id'=>$model->id));
			}
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

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionLogin()
	{
		$this->layout=false;
		if(!Yii::app()->user->isGuest){
			echo 'logged-in';
			exit();
		}
			
		if(!isset(Yii::app()->session['login_ref']))
			Yii::app()->session['login_ref']=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'/';
		
        $model = new LoginForm;

	    // collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				echo 'logged-in';
				exit();
			}
		}
		// display the login form
		$this->render('login',array('login_form'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
	}

	public function actionSignup()
	{
		$this->layout=false;

		if(!Yii::app()->user->isGuest){
			echo 'logged-in';
			exit();
		}

		$model=new User('signup');

	    if(isset($_POST['User']))
	    {
	        $model->attributes=$_POST['User'];
	        if($_POST['User']['password'])
	        	$model->password=md5($model->password);
	        if($model->save())
	        {
	        	$login_form = new LoginForm;
	        	$login_form->attributes = $model->attributes;
	            if($login_form->login()){
					echo 'logged-in';
					exit();
				}
	        }
	        $model->password = null;
	    }
	    $this->render('signup',array('model'=>$model));
	}

	public function actionProfile()
	{
		$model=Yii::app()->user->model;

	    $this->performAjaxValidation($model);

	    if(isset($_POST['User']))
	    {
	    	/*$uploadedFile=CUploadedFile::getInstance($model,'avatar_uri');
	    	if(!empty($uploadedFile)){
                $ext = 'jpg'; // pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $a=explode('/', $uploadedFile->type);
                if (count($a)==2 && $a[0]=='image') {
                	$ext=$a[1];
	    			$uri="avatars/{$model->username}.$ext";
	    			$uploadedFile->saveAs(Yii::app()->basePath.'/../images/'.$uri);
	    			$model->avatar_uri=$uri;
	    		} else {
	    			$model->addError('avatar_uri', 'banana');
	    		}
	    	}*/
	        $model->attributes=$_POST['User'];
	        if($model->save())
	        {
	        	Yii::app()->user->setFlash('flash', array(
                    'status' => 'success',
                    'message' => 'You profile has been successfuly updated.'
                ));
	        }
	    }
	    $this->render('profile',array('model'=>$model));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		if(is_numeric($id))
			$model=User::model()->findByPk($id);
		else
			$model=User::model()->findByAttributes(array('username'=>$id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
