<?php

/**
 * This is the model class for table "{{thread_reply_vote}}".
 *
 * The followings are the available columns in table '{{thread_reply_vote}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $thread_reply_id
 * @property integer $vote_type
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property ThreadReply $threadReply
 * @property User $user
 */
class ThreadReplyVote extends CActiveRecord
{
	public $old_vote_type;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ThreadReplyVote the static model class
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
		return '{{thread_reply_vote}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, thread_reply_id', 'required'),
			array('user_id, thread_reply_id, vote_type, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, thread_reply_id, vote_type, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'threadReply'=>array(self::BELONGS_TO, 'ThreadReply', 'thread_reply_id'),
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'user_id'=>'User',
			'thread_reply_id'=>'Thread Reply',
			'vote_type'=>'Vote Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('thread_reply_id',$this->thread_reply_id);
		$criteria->compare('vote_type',$this->vote_type);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function setAttribute($n, $v){
		if($n=='vote_type') $this->old_vote_type=$this->vote_type;
		return parent::setAttribute($n, $v);
	}

	protected function beforeValidate() {
		if(!$this->user_id){
        	$this->user_id=Yii::app()->user->id;
        }
        return true;
    }

	public function beforeSave()
	{
		if(!$this->created_at){
			$this->created_at=time();
        }else{
        	$this->updated_at=time();
        }
        return parent::beforeSave();
	}

	public function afterSave()
	{
		parent::afterSave();
		$vote_type=Constants::voteType($this->vote_type);
		$old_vote_type=Constants::voteType($this->old_vote_type);
		if(!$this->isNewRecord){
			if(!UserLog::removeActivity($old_vote_type, $this->threadReply, $this->user))
				throw new CHttpException(400, 'Couldn\'n delete old activity');
		}
		UserLog::addActivity($vote_type, $this->threadReply);
		$this->user->stat_votes++;
		$this->user->save();
	}
}