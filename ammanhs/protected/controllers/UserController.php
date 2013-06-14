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
				'actions'=>array('view','login','signup','connect'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('profile','logout'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','index','update'),
				'roles'=>array('admin'),
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
		$this->layout=null;
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
		$model=$this->loadModel($id);
		$user_feed=$model->getUserFeed(10, array('thread'));
		if(Yii::app()->user->isGuest || Yii::app()->user->id!=$model->id){
			$model->stat_views++;
			$model->save(false);
		}
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
                    'status'=>'success',
                    'message'=>'User has been created successfuly.'
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

	public function actionConnect()
	{
		$this->layout=false;
		if(!Yii::app()->user->isGuest){
			exit();
		}
		$data=array();
		if(isset($_GET['callback_func']) && $_GET['callback_func']){
			$data['callback_func']=$_GET['callback_func'];
		}
		if(isset($_GET['attr']) && $_GET['attr']){
			$data['attr']=$_GET['attr'];
		}
		if(isset($_GET['redirect']) && $_GET['redirect']){
			$data['redirect']=$_GET['redirect'];
		}
		$this->render('connect', $data);
	}

	public function actionLogin()
	{
		$this->layout=false;

		$ref=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';

		if(!Yii::app()->user->isGuest){
			if(!$ref){            
	            $this->redirect($this->homeLink());
	        }
			echo 'logged-in';
			exit();
		}

		if(!$ref || !isset($_GET['modal'])){
			$hash='#connect';
			if(isset($_GET['redirect'])){
                $hash.='?redirect=';
                $uri=urldecode($_GET['redirect']);
                if(strrpos($uri, '/')!==0) $uri='/'.str_replace('_', '/', $uri);
                $hash.=$uri;
            }elseif(isset(Yii::app()->user->returnUrl)){
                $hash.='?redirect=';
                $uri=urldecode(Yii::app()->user->returnUrl);
                $hash.=$uri;
            }
            $this->redirect('/'.$hash);
        }
			
		if(!isset(Yii::app()->session['login_ref']))
			Yii::app()->session['login_ref']=$ref;
		
        $model=new LoginForm;

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
		$data=array('login_form'=>$model);
		if(isset($_POST['callback_func']) && $_POST['callback_func']){
			$data['callback_func']=$_POST['callback_func'];
		}
		if(isset($_POST['attr']) && $_POST['attr']){
			$data['attr']=$_POST['attr'];
		}
		if(isset($_POST['redirect']) && $_POST['redirect']){
			$data['redirect']=$_POST['redirect'];
		}
		if(isset($_POST['input_class'])) $data['input_class']=$_POST['input_class'];
		// display the login form
		$this->render('login', $data);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
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
	        	$login_form=new LoginForm;
	        	$login_form->attributes=$model->attributes;
	        	$login_form->password=$_POST['User']['password'];
	            if($login_form->login()){
					echo 'logged-in';
					exit();
				}
	        }
	        $model->password=null;
	    }
	    $data=array('model'=>$model);
		if(isset($_POST['callback_func']) && $_POST['callback_func']){
			$data['callback_func']=$_POST['callback_func'];
		}
		if(isset($_POST['attr']) && $_POST['attr']){
			$data['attr']=$_POST['attr'];
		}
		if(isset($_POST['redirect']) && $_POST['redirect']){
			$data['redirect']=$_POST['redirect'];
		}
		if(isset($_POST['input_class'])) $data['input_class']=$_POST['input_class'];
		// display the login form
	    $this->render('signup', $data);
	}

	public function actionProfile()
	{
		$model=Yii::app()->user->model;

	    $this->performAjaxValidation($model);

	    if(isset($_POST['User']))
	    {
	        $model->attributes=$_POST['User'];
	        $model->mobile=trim($model->mobile);
	        if(trim($model->website)=='http://') unset($model->website);
	        if(trim($model->facebook_uri)=='http://facebook.com/') unset($model->facebook_uri);
	        if(trim($model->twitter_uri)=='@') unset($model->twitter_uri);
	        if($model->save())
	        {
	        	Yii::app()->user->setFlash('flash', array(
                    'status'=>'success',
                    'message'=>Yii::t('core', 'You profile has been successfuly updated.')
                ));
                $this->redirect(array('view','id'=>$model->id));
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
