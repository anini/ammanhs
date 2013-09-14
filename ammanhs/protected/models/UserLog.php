<?php

/**
 * This is the model class for table "{{user_log}}".
 *
 * The followings are the available columns in table '{{user_log}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property integer $thread_id
 * @property integer $thread_reply_id
 * @property integer $targeted_user_id
 * @property string $uri
 * @property integer $points_earned
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property User $targetedUser
 * @property Thread $thread
 * @property ThreadReply $threadReply
 * @property User $user
 */
class UserLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserLog the static model class
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
		return '{{user_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, thread_id, thread_reply_id, targeted_user_id, points_earned, created_at', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>11),
			array('uri', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, action, thread_id, thread_reply_id, targeted_user_id, uri, points_earned, created_at', 'safe', 'on'=>'search'),
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
			'targetedUser' => array(self::BELONGS_TO, 'User', 'targeted_user_id'),
			'thread' => array(self::BELONGS_TO, 'Thread', 'thread_id'),
			'threadReply' => array(self::BELONGS_TO, 'ThreadReply', 'thread_reply_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'action' => 'Action',
			'thread_id' => 'Thread',
			'thread_reply_id' => 'Thread Reply',
			'targeted_user_id' => 'Targeted User',
			'uri' => 'Uri',
			'points_earned' => 'Points Earned',
			'created_at' => 'Created At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('thread_id',$this->thread_id);
		$criteria->compare('thread_reply_id',$this->thread_reply_id);
		$criteria->compare('targeted_user_id',$this->targeted_user_id);
		$criteria->compare('uri',$this->uri,true);
		$criteria->compare('points_earned',$this->points_earned);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate()
	{
		if(!$this->user_id){
        	$this->user_id=Yii::app()->user->id;
        }
        return true;
    }

	public function beforeSave()
	{
		if(!$this->created_at){
			$this->created_at=time();
        }
        return parent::beforeSave();
	}

	public static function addActivity($action, $object=null, $points_earned=0){
		$thread_id=null;
		$thread_reply_id=null;
		$thread_id=null;
		$targeted_user_id=null;
		$uri='';

		$object_class=get_class($object);
		switch($object_class){
			case 'Thread':
				$thread_id=$object->id;
				$uri=$object->link;
				break;
			case 'ThreadReply':
				$thread_reply_id=$object->id;
				$uri=$object->link;
				break;
			case 'User':
				if($action!='Join')
					$targeted_user_id=$object->id;
				$uri=$object->profileLink;
				break;
		}

		$user_activity=new UserLog();
		$user_activity->action=$action;
		$user_activity->thread_id=$thread_id;
		$user_activity->thread_reply_id=$thread_reply_id;
		$user_activity->thread_id=$thread_id;
		$user_activity->targeted_user_id=$targeted_user_id;
		$user_activity->points_earned=$points_earned;
		$user_activity->uri=$uri;
		if($action=='Join')
			$user_activity->user_id=$object->id;
		if(!$user_activity->save()){
			echo CActiveForm::validate($user_activity);
			Yii::app()->end();
			throw new CHttpException(400, 'Couldn\'n save user activity');
		}
		return true;
	}

	public static function removeActivity($action, $object, $user){
		$object_class=get_class($object);
		$object_id=$object->id;
		$user_id=$user->id;
		$minus_points=0;
		switch($object_class){
			case 'Thread':
				if($action=='Add'){
					$minus_points=Constants::THREAD_ADDED_EARNED_POINTS;
					$user->stat_threads--;
				}
				$condition="thread_id={$object_id}";
				break;
			case 'ThreadReply':
				if($action=='Add'){
					$minus_points=Constants::THREAD_REPLY_ADDED_EARNED_POINTS;
					$user->stat_replies--;
				}
				$condition="thread_reply_id={$object_id}";
				break;
			case 'User':
				if($action!='Join')
					$condition="targeted_user_id={$object_id}";
				break;
		}
		if(!$condition) return false;
		$condition.=" AND user_id={$user_id} AND action=\"{$action}\"";
		$deleted=self::model()->deleteAll($condition);
		if($minus_points){
			$user->stat_points-=$minus_points;
			$user->save(false);
		}
		return true;
	}

}