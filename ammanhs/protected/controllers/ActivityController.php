<?php

class ActivityController extends Controller
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
				'actions'=>array('index', 'view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('reply'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create', 'update', 'admin', 'delete', 'updateCoverPhoto','updateAlbum', 'uploadFile', 'deleteFile', 'updatePhotosCaptions', 'updateAttachments', 'updateAttachmentsNamesAndTypes', 'delete'),
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
		$model=Activity::model()->with('attachments', 'photos', 'replies')->findByAttributes(array('uq_title'=>$id));
		if(!$model && is_numeric(($id))){
			$model=Activity::model()->findByPk($id);
			if($model){
				$this->redirect($model->link, true, 301);
			}
		}

		if(!$model || $model->publish_status<Constants::PUBLISH_STATUS_DRAFT){
			Yii::app()->user->setFlash('flash', array(
                    'status'=>'error',
                    'message'=>Yii::t('core', 'Sorry! This is activity is no longer available.')
                ));
                $this->redirect(array('index'), true, 301);
		}

		if(!isset(Yii::app()->session['viewed_activities']) || !in_array($model->id, Yii::app()->session['viewed_activities'])){
			if(!isset(Yii::app()->session['viewed_activities'])) Yii::app()->session['viewed_activities']=array();
			$viewed_activities=Yii::app()->session['viewed_activities'];
			$viewed_activities[]=$model->id;
			Yii::app()->session['viewed_activities']=$viewed_activities;
			$model->stat_views++;
			$model->save(false);
		}

		$activity_attachments=$model->attachments;
		$activity_photos=$model->photos;
		$activity_replies=$model->replies;
		$activity_reply=new ActivityReply;

		$this->render('view',array(
			'model'=>$model,
			'activity_attachments'=>$activity_attachments,
			'activity_photos'=>$activity_photos,
			'activity_replies'=>$activity_replies,
			'activity_reply'=>$activity_reply,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Activity;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Activity']))
		{
			$parser=new CMarkdownParser;
    		$_POST['Activity']['content']=$parser->safeTransform($_POST['Activity']['content']);
			$model->attributes=$_POST['Activity'];
			if($_POST['Activity']['date']){
				$model->date=strtotime($model->date);
			}
			if($model->save()){
				$this->redirect(array('updateCoverPhoto','id'=>$model->id));
				//$this->redirect(array('view','id'=>$model->uq_title));
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
		$model->date=date('m/d/Y', $model->date);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Activity']))
		{
			$parser=new CMarkdownParser;
    		$_POST['Activity']['content']=$parser->safeTransform($_POST['Activity']['content']);
			$model->attributes=$_POST['Activity'];
			$model->date=strtotime($model->date);
			if($model->save()){
				$this->redirect(array('updateCoverPhoto','id'=>$model->id));
				//$this->redirect(array('view','id'=>$model->uq_title));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes (Unpublish) a particular model.
	 * If deletion (unpublishing) is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//if(Yii::app()->request->isPostRequest)
		//{
			// we only allow deletion (unpublishing) via POST request
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('flash', array(
                    'status'=>'success',
                    'message'=>'Activity has been unpublished successfully!',
                ));

			// if AJAX request(triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		//}
		//else
		//	throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$activities=Activity::model()->findAll(array(
			'order'=>'date desc',
			'condition'=>'publish_status>='.Constants::PUBLISH_STATUS_DRAFT,
			));

		$this->render('index',array(
			'activities'=>$activities,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='main';
		$model=new Activity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Activity']))
			$model->attributes=$_GET['Activity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionUpdateCoverPhoto($id){
		$model=$this->loadModel($id);

		if(isset($_POST['Activity']))
		{
			$model->attributes=$_POST['Activity'];
			if($model->save()){
				$this->redirect(array('updateAlbum','id'=>$model->id));
			}
		}

		$this->render('cover_photo', array(
			'model'=>$model,
			)
		);
	}

	public function actionUpdateAlbum($id){
		//$this->layout='main';
		$model=Activity::model()->with('photos')->findByPk($id);
		$photos=$model->photos;
		$this->render('photos', array(
			'model'=>$model,
			'photos'=>$photos,
			)
		);
	}

	public function actionUpdateAttachments($id){
		$model=Activity::model()->with('attachments')->findByPk($id);
		$attachments=$model->attachments;
		$this->render('attachments', array(
			'model'=>$model,
			'attachments'=>$attachments,
			)
		);
	}

	public function actionUploadFile($activity_id, $folder){
		error_reporting(E_ALL | E_STRICT);
		$timestamp=hexdec('0x'.substr(uniqid(),-8));
		$file_name=Text::slugify($activity_id.'-'.$timestamp);
		$upload_handler=new UploadHandler('/images/activity/'.$activity_id.'/'.$folder.'/',
			array(
				'file_name'=>$file_name,
				'param_name'=>'files',
				)
			);
		if($upload_handler->response){
			$response=json_decode($upload_handler->response);
			if(isset($response->files[0]->url)){
				$url=$response->files[0]->url;
				$uri=explode('/images/', $url);
				$uri=$uri[1];
				$file_path=Yii::app()->basePath.'/../images/'.$uri;

				switch($folder){
					case 'attachments':
						$model=new ActivityAttachment;
						if(isset($_POST['name']) && $_POST['name']){
							$model->name=$_POST['name'];
							$response->files[0]->filename=$_POST['name'];
						}else{
							$response->files[0]->filename='';
						}
						if(isset($_POST['type']) && $_POST['type']){
							$model->type=$_POST['type'];
						}
						break;
					case 'album':
						// Adding watermark on the image
						Img::addWatermark($image_path);
						$model=new ActivityPhoto;
						if(isset($_POST['caption']) && $_POST['caption']){
							$model->caption=$_POST['caption'];
							$response->files[0]->caption=$_POST['caption'];
						}else{
							$response->files[0]->caption='';
						}
						break;
					default:
						echo 'Undefined folder';
						Yii::app()->end();
						break;
				}
				$model->activity_id=$activity_id;
				$model->uri=$uri;
				
				if(!$model->save()){
					throw new CHttpException(500, 'Couldn\'t save model.');
				}
				if($folder=='attachments'){
					$response->files[0]->filetype=$model->type;
				}
				$response->files[0]->deleteUrl=$this->createUrl('activity/deleteFile', array('model_id'=>$model->id, 'model_name'=>'Activity'.($folder=='attachments'?'Attachment':'Photo')));
				$response->files[0]->model_id=$model->id;
			}
			echo(json_encode($response));
		}
	}

	public function actionDeleteFile($model_id, $model_name){
		$model=$model_name::model()->findByPk($model_id);
		if($model){
			$file_path=Yii::app()->basePath.'/../images/'.$model->uri;
			if(is_writable($file_path)){
				if(unlink($file_path)){
					echo 'File deleted!';
				}else{
					echo 'Could\'nt delete file!';
				}
			}else{
				echo 'File not readable!';
			}
			if($model_name=='ActivityPhoto'){
				$path=explode('/album/', $file_path);
				$thumb_path=$path[0].'/album/thumbnail/'.$path[1];
				if(is_writable($file_path)){
					if(unlink($thumb_path)){
						echo 'Thumbnail deleted!';
					}else{
						echo 'Could\'nt delete thumbnail!';
					}
				}else{
					echo 'Thumbnail not readable!';
				}
			}
			if($model->delete()){
				echo 'Model deleted!';
			}else{
				echo 'Could\'nt delete the model!';
			}
		}else{
			echo 'Model not found!';
		}
	}

	public function actionUpdatePhotosCaptions($activity_id){
		if(isset($_POST['caption']) && $_POST['caption']){
			$model=Activity::model()->with('photos')->findByPk($activity_id);
			if(!$model){
				echo Yii::t('core', 'Error has been occurred!');
				Yii::app()->end();
			}
			$changes=0;
			$photos=$model->photos;
			foreach($photos as $photo){
				if(isset($_POST['caption'][$photo->id]) && $photo->caption!=$_POST['caption'][$photo->id]){
					$photo->caption=$_POST['caption'][$photo->id];
					if(!$photo->save()){
						echo Yii::t('core', 'Error has been occurred!');
						Yii::app()->end();
					}
					$changes++;
				}
			}
			if($changes){
				echo Yii::t('core', 'Captions updated successfuly!');
			}else{
				echo Yii::t('core', 'No changes!');
			}
		}
	}

	public function actionUpdateAttachmentsNamesAndTypes($activity_id){
		if(isset($_POST['name']) && isset($_POST['type']) && $_POST['name'] && $_POST['type']){
			$model=Activity::model()->with('attachments')->findByPk($activity_id);
			if(!$model){
				echo Yii::t('core', 'Error has been occurred!');
				Yii::app()->end();
			}
			$changes=0;
			$attachments=$model->attachments;
			foreach($attachments as $attachment){
				$changed=0;
				if(isset($_POST['name'][$attachment->id]) && $attachment->name!=$_POST['name'][$attachment->id]){
					$attachment->name=$_POST['name'][$attachment->id];
					$changed=1;
				}
				if(isset($_POST['type'][$attachment->id]) && $attachment->type!=$_POST['type'][$attachment->id]){
					$attachment->type=$_POST['type'][$attachment->id];
					$changed=1;	
				}
				if($changed){
					if(!$attachment->save()){
						echo Yii::t('core', 'Error has been occurred!');
						Yii::app()->end();
					}
					$changes=1;
				}
			}
			if($changes){
				echo Yii::t('core', 'Names & types updated successfuly!');
			}else{
				echo Yii::t('core', 'No changes!');
			}
		}
	}

	public function actionReply($activity_id){
		if(empty($_POST['ActivityReply']) || !Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, 'Bad request.');
        }

        $activity=Activity::model()->findByPk($activity_id);
        if(!$activity){
        	throw new CHttpException(404, 'Activity is not exist.');
        }

		$model=new ActivityReply;
		$model->activity_id=$activity_id;
		$parser=new CMarkdownParser;
    	$_POST['ActivityReply']['content']=$parser->safeTransform($_POST['ActivityReply']['content']);
		$model->attributes=$_POST['ActivityReply'];
	
		if($model->save())
			return $this->renderPartial('_reply', array('model'=>$model));
		else
			return false;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Activity::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='activity-form')
		{
			if(isset($_POST['Activity']['date'])) $_POST['Activity']['date']=strtotime($_POST['Activity']['date']);
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
