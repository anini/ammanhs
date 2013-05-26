<?php

class RbacController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view','index','id_Create'),
				'roles'=>array('root'),
			),
			array('deny', // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Rbac;
		$model->setScenario('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rbac'])){
			$model->attributes=$_POST['Rbac'];
			if($model->validate()){
				$user_model=User::model()->findByAttributes(array('username'=>$model->username));
				$model->userid=$user_model->id;
				$model->save(false);
			}
		}

		$this->render('create', array(
			'model'=>$model,
		));
	}

	public function actionId_Create()
	{
		$model=new Rbac;
		$model->setScenario('id_Create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rbac'])){
			$model->attributes=$_POST['Rbac'];
			if($model->validate()){
				$user_model=User::model()->findByAttributes(array('id'=>$model->userid));
				$model->userid=$user_model->id;
				$model->save(false);
			}
		}

		$this->render('id_create', array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$oldRole=$model->itemname;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rbac']))
		{
			$model->attributes=$_POST['Rbac'];
			if($model->save()){
				$this->redirect(array('admin'));
			}
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		// we only allow deletion via POST request
		if(true || Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Rbac();
		if(isset($_GET['Rbac']))
			$model->attributes=$_GET['Rbac'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionShow()
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->select="itemname, userid";
		$authusers=AuthAssignment::model()->findAll($criteria);
		$this->render('show', array(
			'model'=>$model,
			'authusers'=>$authusers,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Rbac('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Rbac']))
			$model->attributes=$_GET['Rbac'];
		$this->render('admin', array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Rbac::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rbac-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
