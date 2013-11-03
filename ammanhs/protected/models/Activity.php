<?php

/**
 * This is the model class for table "{{activity}}".
 *
 * The followings are the available columns in table '{{activity}}':
 * @property integer $id
 * @property integer $date
 * @property string $title
 * @property string $photo_uri
 * @property string $content
 * @property string $tags
 * @property string $uq_title
 * @property integer $stat_photos
 * @property integer $stat_attachments
 * @property integer $stat_replies
 * @property integer $stat_views
 * @property integer $publish_status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property ActivityPhoto[] $photos
 */
class Activity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Activity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{activity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, title, content', 'required'),
			array('date, stat_photos, stat_attachments, stat_views, stat_replies, publish_status, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('title, photo_uri', 'length', 'max'=>256),
			array('tags', 'length', 'max'=>128),
			array('photo_uri, unique_title, stat_photos, stat_attachments, stat_views, stat_replies, publish_status', 'unsafe'),
			array('photo_uri', 'ImageValidator', 'sub_dir'=>'activity', 'attributeName'=>'id'),
			array('photo_uri', 'file', 'types'=>'jpg, gif, png', 'maxSize'=>'5242880', 'allowEmpty'=>true, 'tooLarge'=>'Maximum image size is 5MB.', 'wrongType'=>'Only files with "jpg, gif, png" extensions are allowed.'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, title, photo_uri, content, tags, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'photos'=>array(self::HAS_MANY, 'ActivityPhoto', 'activity_id'),
			'replies'=>array(self::HAS_MANY, 'ActivityReply', 'activity_id'),
			'attachments'=>array(self::HAS_MANY, 'ActivityAttachment', 'activity_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'date'=>Yii::t('core', 'Date'),
			'title'=>Yii::t('core', 'Title'),
			'photo_uri'=>Yii::t('core', 'Photo'),
			'content'=>Yii::t('core', 'Content'),
			'tags'=>Yii::t('core', 'Tags'),
			'unique_title'=>'Unique Title',
			'stat_photos'=>Yii::t('core', 'Stat Photos'),
			'stat_photos'=>Yii::t('core', 'Stat Attachments'),
			'stat_views'=>Yii::t('core', 'Stat Views'),
			'stat_replies'=>Yii::t('core', 'Stat Replies'),
			'publish_status'=>'Status',
			'created_at'=>'Created At',
			'updated_at'=>'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('date', $this->date);
		$criteria->compare('title', $this->title,true);
		$criteria->compare('photo_uri', $this->photo_uri,true);
		$criteria->compare('content', $this->content,true);
		$criteria->compare('tags', $this->tags,true);
		$criteria->compare('uq_title', $this->uq_title,true);
		$criteria->compare('stat_photos', $this->created_at);
		$criteria->compare('stat_attachments', $this->created_at);
		$criteria->compare('stat_replies', $this->created_at);
		$criteria->compare('stat_views', $this->created_at);
		$criteria->compare('publish_status',$this->publish_status);
		$criteria->compare('created_at', $this->created_at);
		$criteria->compare('updated_at', $this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$this->generateUniqueTitle(false);
		}
		if(!$this->created_at){
			$this->created_at=time();
        }else{
        	$this->updated_at=time();
        }
        return parent::beforeSave();
	}

	public function photo($w=false, $h=false, $with_container=true, $attributes=array(), $container_style="")
	{
		return  (($with_container)?'<div style="'.$container_style.'">':'').
					Img::embed($this->photo_uri, $w, $h, 'ammanhs_logo.jpg', array_merge($attributes, array("title"=>$this->title))).
				(($with_container)?'</div>':'');
	}

	public function photo_a($w=false, $h=false, $img_attributes=array(), $anchor_attributes=array(), $with_container=true)
	{
		$default_img_attributes=array('title'=>$this->title, 'data-original-title'=>$this->title);
		$default_anchor_attributes=array('href'=> $this->link, 'style'=>"text-decoration: none;");
		return  (($with_container)?'<div class="cover-photo">':'').
					Img::a($this->photo_uri, $w, $h, 'ammanhs_logo.jpg',
						array_merge($default_img_attributes, $img_attributes),
						array_merge($default_anchor_attributes, $anchor_attributes)
                	).
				(($with_container)?'</div>':'');
	}

	/**
	 * Overriding delete() function, we actually replacing delete with unpublish
	 * we don't delete any data!
	 */
	public function delete(){
		$this->publish_status=Constants::PUBLISH_STATUS_UNPUBLISHED;
		if(!$this->save()){
			throw new CHttpException(500, 'Couldn\'t unpublish the activity.');
		}
	}

	public function getLink($absolute=false){
		if($absolute || !(Yii::app() instanceof CWebApplication))
			return Yii::app()->urlManager->createAbsoluteUrl('activity/view', array('id'=>$this->uq_title));
		return Yii::app()->urlManager->createUrl('activity/view', array('id'=>$this->uq_title));
	}

	public function generateUniqueTitle($save=true){
		$title=$this->title;
		if(strlen($title)>200){
			$title=substr($title, 0, 200);
		}
		$uq_title=UrlManager::seoUrl($title);
		$temp_uq_title=$uq_title;
		$done=false;
		$n=2;
		while(!$done){
			$old_activity=Activity::model()->findByAttributes(array('uq_title'=>$temp_uq_title));
			if(!$old_activity || $old_activity->id==$this->id){
				$done=true;
			}else{
				$temp_uq_title=$uq_title.'-'.$n;
				$n++;
			}
			if($n>100){
				throw new CHttpException(500, 'Unique title generation trials exceeded, try later');
			}
		}
		$this->uq_title=$temp_uq_title;
		if($save){
			$this->save(false);
		}
	}
}