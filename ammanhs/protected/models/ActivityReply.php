<?php

/**
 * This is the model class for table "{{activity_reply}}".
 *
 * The followings are the available columns in table '{{activity_reply}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $publish_status
 *
 * The followings are the available model relations:
 * @property Activity $activity
 * @property User $user
 */
class ActivityReply extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return ActivityReply the static model class
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
        return '{{activity_reply}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, activity_id, content', 'required'),
            array('user_id, activity_id, created_at, updated_at, publish_status', 'numerical', 'integerOnly'=>true),
            array('content', 'safe'),
            array('id, user_id, activity_id, created_at, updated_at, publish_status', 'unsafe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, activity_id, content, created_at, updated_at, publish_status', 'safe', 'on'=>'search'),
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
            'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
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
            'activity_id' => 'Activity',
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
        $criteria->compare('activity_id',$this->activity_id);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('created_at',$this->created_at);
        $criteria->compare('updated_at',$this->updated_at);
        $criteria->compare('publish_status',$this->publish_status);

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
        if($this->isNewRecord || $this->scenario=='edit'){
            $this->content=Text::addNofollowRelToAnchors($this->content);
            $this->content=Text::addBlankTargetToAnchors($this->content);
            $this->content=Text::linkUrls($this->content);
        }
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
        if($this->isNewRecord){
            UserLog::addActivity('Add', $this, Constants::ACTIVITY_REPLY_ADDED_EARNED_POINTS);
            $this->user->stat_points+=Constants::ACTIVITY_REPLY_ADDED_EARNED_POINTS;
            $this->user->stat_replies++;
            $this->user->save();
        }
        if($this->isNewRecord || $this->scenario=='edit'){
            // Cloning all external images
            $content=Img::cloneAllExternalImages($this->content, 'activityReply', $this->id);
            Yii::app()->db->createCommand(
                "UPDATE tbl_activity_reply SET content=:content where id=:id"
                )->bindValues(array(':content'=>$content, ':id'=>$this->id))->execute();
        }
        $this->activity->stat_replies=count($this->activity->replies);
        $this->activity->save();
    }

    /**
    * Overriding delete() function, we actually replacing delete with unpublish
    * we don't delete any data!
    */
    public function delete(){
        $this->publish_status=Constants::PUBLISH_STATUS_UNPUBLISHED;
        if(!$this->save()){
            throw new CHttpException(500, 'Couldn\'t unpublish the activity reply.');
        }
        UserLog::removeActivity('Add', $this, $this->user);
    }

    public function getLink($absolute=false){
        return $this->activity->getLink($absolute).'#reply='.$this->id;
    }
}