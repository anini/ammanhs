<?php

/**
 * This is the model class for table "{{thread_reply}}".
 *
 * The followings are the available columns in table '{{thread_reply}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $stat_votes
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $publish_status
 *
 * The followings are the available model relations:
 * @property Thread $thread
 * @property User $user
 */
class ThreadReply extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ThreadReply the static model class
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
		return '{{thread_reply}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, thread_id, content', 'required'),
			array('user_id, thread_id, stat_votes, created_at, updated_at, publish_status', 'numerical', 'integerOnly'=>true),
			array('content', 'safe'),
			//array('content', 'unique'),
			array('id, user_id, thread_id, stat_votes, created_at, updated_at, publish_status', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, thread_id, stat_votes, content, created_at, updated_at, publish_status', 'safe', 'on'=>'search'),
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
			'thread'=>array(self::BELONGS_TO, 'Thread', 'thread_id'),
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
			'my_up_vote'=>array(self::HAS_ONE, 'ThreadReplyVote', 'thread_reply_id', 'alias'=> 'vote_up', 'on'=>'vote_up.vote_type='.Constants::VOTE_UP.' AND vote_up.user_id='.Yii::app()->user->id),
			'my_down_vote'=>array(self::HAS_ONE, 'ThreadReplyVote', 'thread_reply_id', 'alias'=> 'vote_down', 'on'=>'vote_down.vote_type='.Constants::VOTE_DOWN.' AND vote_down.user_id='.Yii::app()->user->id),
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
			'thread_id' => 'Thread',
			'stat_votes' => 'Stat Votes',
			'content' => 'Content',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'publish_status' => 'Publish Status',
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
		$criteria->compare('thread_id',$this->thread_id);
		$criteria->compare('stat_votes',$this->stat_votes);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('publish_status',$this->publish_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate() {
		if(!$this->user_id){
        	$this->user_id = Yii::app()->user->id;
        }
        return true;
    }

	public function beforeSave()
	{
		if(!$this->created_at){
			$this->created_at = time();
        }else{
        	$this->updated_at = time();
        }
        return parent::beforeSave();
	}

	public function afterSave()
	{
		parent::afterSave();
		if($this->isNewRecord){
			UserLog::addActivity('Add', $this, Constants::THREAD_REPLY_ADDED_EARNED_POINTS);
			$this->user->stat_points+=Constants::THREAD_REPLY_ADDED_EARNED_POINTS;
			$this->user->stat_replies++;
			$this->user->save();
		}
		$this->thread->stat_replies = count($this->thread->replies);
		$this->thread->save();
	}

	public function updateStatVotes(){
		$positive_votes=COUNT(ThreadReplyVote::model()->findAllByAttributes(array('thread_reply_id'=>$this->id, 'vote_type'=>1)));
		$negative_votes=COUNT(ThreadReplyVote::model()->findAllByAttributes(array('thread_reply_id'=>$this->id, 'vote_type'=>-1)));
		$this->stat_votes=(int)($positive_votes-$negative_votes);
		return $this->save();
	}

	/**
	* Overriding delete() function, we actually replacing delete with unpublish
	* we don't delete any data!
	*/
	public function delete(){
		$this->publish_status=Constants::PUBLISH_STATUS_UNPUBLISHED;
		if(!$this->save()){
			throw new CHttpException(500, 'Couldn\'t unpublish the thread.');
		}
		UserLog::removeActivity('Add', $this, $this->user);
	}

	public function getLink($absolute=false){
		if ($absolute || !(Yii::app() instanceof CWebApplication))
			return Yii::app()->urlManager->createAbsoluteUrl('thread/view', array('id' => $this->id)).'#thread='.$this->id;
		return Yii::app()->urlManager->createUrl('thread/view', array('id' => $this->thread->id)).'#reply='.$this->id;
	}

}