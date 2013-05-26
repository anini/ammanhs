<?php

/**
 * This is the model class for table "AuthAssignment".
 *
 * The followings are the available columns in table 'AuthAssignment':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $DATA
 */
class AuthAssignment extends JActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AuthAssignment the static model class
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
		return 'AuthAssignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max'=>64),
			array('bizrule, DATA', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('itemname, userid, bizrule, DATA', 'safe', 'on'=>'search'),
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
			'itemname0'=>array(self::BELONGS_TO, 'AuthItem', 'itemname'),
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname'=>'Itemname',
			'userid'=>'Userid',
			'bizrule'=> 'Bizrule',
			'DATA'=>'Data',
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

		$criteria->compare('itemname',$this->itemname,true);

		$criteria->compare('userid',$this->userid,true);

		$criteria->compare('bizrule',$this->bizrule,true);

		$criteria->compare('DATA',$this->DATA,true);

		return new CActiveDataProvider('AuthAssignment', array(
			'criteria'=>$criteria,
		));
	}

    protected function afterSave() {
        parent::afterSave();
        Yii::app()->authManager->purgeAuthAssignments($this->userid);
    }
}
