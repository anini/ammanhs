<?php

/**
 * This is the model class for table "{{AuthAssignment}}".
 *
 * The followings are the available columns in table '{{AuthAssignment}}':
 */
class Rbac extends JActiveRecord
{

	public $username;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Rbac the static model class
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
			//array('userid', 'unsafe'),
			//array('username, itemname', 'required'),
			array('username', 'required', 'on'=>'create'),
			array('userid', 'required', 'on'=>'id_Create'),
			array('username' , 'exist', 'className'=>'User' ,'attributeName'=>'username'),
			array('userid' , 'exist', 'className'=>'User' ,'attributeName'=>'id'),
			//array('userid', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>128),
			array('bizrule', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, itemname', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'userid'=>'User',
			'itemname'=>'Role Name',
			'bizrule'=>'Business Rule',
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
		$criteria->compare('username', $this->username);
		$criteria->compare('userid', $this->userid);
		$criteria->compare('itemname', $this->itemname);
		$criteria->with=array('user');

		return new CActiveDataProvider('Rbac', array('criteria'=>$criteria, 'pagination'=>array('pageSize'=>50)));
	}

	public static function roles()
	{
	  	$_roles=AuthItem::model()->findAll();
	  	$roles=array();
	    foreach($_roles as $role){
	    	$roles[$role->name]=$role->name;
	    }
	    return $roles; 
	}

	public static function roleById($name){
		return AuthItem::model()->find('name='.$name)->name;
	}

	public static function grantRole($user_id, $item){
		$rbac=New Rbac();
		$rbac->userid=$user_id;
		$rbac->itemname=$item;
		if($rbac->validate()){
			$rbac->save();
			return true;
		}
		return false;
	}

}
