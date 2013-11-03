<?php

/**
 * This is the model class for table "{{activity_attachment}}".
 *
 * The followings are the available columns in table '{{activity_attachment}}':
 * @property integer $id
 * @property integer $activity_id
 * @property string $name
 * @property string $type
 * @property string $uri
 * @property integer $updated_at
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property Activity $activity
 */
class ActivityAttachment extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return ActivityAttachment the static model class
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
        return '{{activity_attachment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('activity_id, uri', 'required'),
            array('activity_id, updated_at, created_at', 'numerical', 'integerOnly'=>true),
            array('name, uri', 'length', 'max'=>256),
            array('type', 'length', 'max'=>12),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, activity_id, name, type, uri, updated_at, created_at', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'activity_id' => 'Activity',
            'name' => 'Name',
            'type' => 'Type',
            'uri' => 'Uri',
            'updated_at' => 'Updated At',
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
        $criteria->compare('activity_id',$this->activity_id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('uri',$this->uri,true);
        $criteria->compare('updated_at',$this->updated_at);
        $criteria->compare('created_at',$this->created_at);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
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
        $this->activity->stat_attachments=count($this->activity->attachments);
        if(!$this->activity->save()){
            throw new CHttpException(500, 'Couldn\'t save activity.');
        }
    }

    public function beforeDelete()
    {
        $this->activity->stat_attachments=count($this->activity->attachments)-1;
        if(!$this->activity->save()){
            throw new CHttpException(500, 'Couldn\'t save activity.');
        }
        parent::beforeDelete();
    }
}