<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $type
 * @property integer $gender
 * @property string $about
 * @property string $avatar_uri
 * @property integer $created_at
 * @property integer $last_login_at
 * @property integer $mobile
 * @property string $website
 * @property string $twitter_uri
 * @property string $twitter_id
 * @property string $facebook_uri
 * @property string $facebook_id
 * @property string $google_uri
 * @property string $google_id
 * @property string $country
 * @property integer $stat_threads
 * @property integer $stat_replies
 * @property integer $stat_votes
 * @property integer $stat_points
 * @property integer $stat_views
 * @property string $signup_ref
 * @property integer $active
 * @property string $ip_address
 *
 * The followings are the available model relations:
 * @property Thread[] $threads
 * @property ThreadReply[] $threadReplys
 */
class User extends CActiveRecord
{
	public $_identity;
	public $rememberMe;
	public $old_password;
	public $verify_password;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email', 'required'),
			array('password', 'required', 'on'=>'signup'),
			array('username, email', 'required', 'on'=>'update'),
			// Alphanumeric Validator: Only letters, numbers and underscores are allowed.
			array('username', 'match', 'pattern'=>'/^\w+$/', 'on'=>'signup','message'=>Yii::t('core','Invalid username! Alphanumerics only.')),
			// Validator: User name should start with a letter.
			array('username', 'match', 'pattern'=>'/^[a-zA-Z]/', 'on'=>'signup','message'=>Yii::t('core', 'Username should start with a letter.')),
			array('username', 'length', 'min'=>5, 'on'=>'signup'),
			array('username', 'unique', 'on'=>'signup'),
			array('mobile', 'match', 'pattern'=>'/^[\d\ \(\)\+]+$/', 'message'=>Yii::t('core', '{attribute} is invalid.')),
			array('mobile', 'length', 'min'=>7),
			array('mobile', 'required', 'on'=>'membership'),
			array('gender, created_at, last_login_at, stat_votes, stat_threads, stat_points, stat_views, twitter_id,facebook_id, google_id', 'numerical', 'integerOnly'=>true),
			array('username, password, first_name, last_name, country, mobile', 'length', 'max'=>64),
			array('email, website, twitter_uri, facebook_uri, google_uri', 'length', 'max'=>128),
			array('type', 'length', 'max'=>6),
			array('password', 'length', 'min'=>6, 'on'=>'signup, create, update, change_password'),
			array('avatar_uri', 'length', 'max'=>256),
			array('avatar_uri', 'unsafe'),
			array('avatar_uri', 'ImageValidator', 'sub_dir'=>'avatar', 'attributeName'=>'id'),
			array('avatar_uri', 'file', 'types'=>'jpg, gif, png', 'maxSize'=>'5242880', 'allowEmpty'=>true, 'tooLarge'=>'Maximum image size is 5MB.', 'wrongType'=>'Only files with "jpg, gif, png" extensions are allowed.'),
			array('about', 'safe'),
			array('username, email', 'unique', 'on'=>'signup, create, update'),
			array('type', 'required', 'on'=>'create, update'),
			array('email', 'email'),
			array('avatar_uri, created_at, last_login_at, stat_threads, stat_replies, stat_votes, stat_points, stat_views, twitter_id, facebook_id, google_id, signup_ref, ip_address, active', 'unsafe'),
			array('type', 'unsafe', 'on'=>'signup, profile'),
			// Change Password Scenario
			array('old_password, password, verify_password', 'required', 'on'=>'change_password'),
			array('verify_password', 'compare', 'on'=>'change_password', 'compareAttribute'=>'password', 'message'=>(Yii::t('core', 'Retype Password is incorrect!'))),
			array('old_password', 'exist', 'on'=>'change_password', 'className'=>'User', 'criteria'=>array('condition'=>'id='.Yii::app()->user->id), 'attributeName'=>'password', 'message'=>(Yii::t('core','The old passowrd is incorrect!'))),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, first_name, last_name, type, gender, about, avatar_uri, created_at, last_login_at, website, mobile, twitter_id, facebook_id, google_id. twitter_uri, facebook_uri, google_uri, country, signup_ref, ip_address, active', 'safe', 'on'=>'search'),
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
			'threads'=>array(self::HAS_MANY, 'Thread', 'user_id'),
			'threadReplys'=>array(self::HAS_MANY, 'ThreadReply', 'user_id'),
			'threadVotes'=>array(self::HAS_MANY, 'ThreadVote', 'user_id'),
			'threadReplyVotes'=>array(self::HAS_MANY, 'ThreadReplyVote', 'user_id'),
			'membership'=>array(self::HAS_ONE, 'Membership', 'user_id')//, 'on'=>'membership.status='.Constants::MEMBERSHIP_STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::t('core', 'Username'),
			'password' => Yii::t('core', 'Password'),
			'email' => Yii::t('core', 'Email'),
			'first_name' => Yii::t('core', 'First Name'),
			'last_name' => Yii::t('core', 'Last Name'),
			'type' => Yii::t('core', 'Type'),
			'gender' => Yii::t('core', 'Gender'),
			'about' => Yii::t('core', 'About Me'),
			'avatar_uri' => Yii::t('core', 'Avatar'),
			'created_at' => 'Created At',
			'last_login_at' => 'Last Login At',
			'mobile' => Yii::t('core', 'Mobile'),
			'website' => Yii::t('core', 'Website'),
			'twitter_uri' => Yii::t('core', 'Twitter Account'),
			'facebook_uri' => Yii::t('core', 'Facebook Account'),
			'google_uri' => Yii::t('core', 'Google+ Account'),
			'country' => Yii::t('core', 'Country'),
			'name' => Yii::t('core', 'Name'),
			'old_password' => Yii::t('core', 'Old Password'),
			'verify_password' => Yii::t('core', 'Verify Password'),
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('avatar_uri',$this->avatar_uri,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('last_login_at',$this->last_login_at);
		$criteria->compare('twitter_uri',$this->twitter_uri,true);
		$criteria->compare('facebook_uri',$this->facebook_uri,true);
		$criteria->compare('google_uri',$this->facebook_uri,true);
		$criteria->compare('twitter_id',$this->twitter_uri,true);
		$criteria->compare('facebook_id',$this->facebook_uri,true);
		$criteria->compare('google_id',$this->facebook_uri,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('signup_ref',$this->country,true);
		$criteria->compare('ip_address',$this->country,true);
		$criteria->compare('active',$this->country,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if(!$this->ip_address || $this->ip_address=='127.0.0.1'){
			$this->ip_address=IPDetector::clientIP();
		}
		if(!$this->created_at){
			$this->created_at=time();
        }
        return parent::beforeSave();
	}

	public function afterSave()
	{
		parent::afterSave();
		if($this->isNewRecord){
			UserLog::addActivity('Join', $this);
			//Mailer::sendTemplatedEmail($this->email, Yii::t('core', 'Welcome to Amman Hackerspace'), 'user/welcome_email', array('user'=>$this));
		}
	}

	public function getName(){
		if($this->first_name)
			return "{$this->first_name} {$this->last_name}";
		else
			return $this->username;
	}

	public function avatar($w=false, $h=false, $with_container=true, $attributes=array(), $container_style=""){
		return  (($with_container)?'<div style="'.$container_style.'">':'').
					Img::embed($this->avatar_uri, $w, $h,($this->gender==2)?'default-female.jpg':'default-male.jpg',array_merge($attributes, array("title"=>$this->name))).
				(($with_container)?'</div>':'');
	}

	public function avatar_a($w=false, $h=false, $img_attributes=array(), $anchor_attributes=array(), $container_style=""){
		$default_img_attributes = array('title'=>$this->name, 'data-original-title'=>$this->name);
		$default_anchor_attributes = array('href'=> $this->profileLink, 'style'=>"text-decoration: none;");
		return  '<div style="'.$container_style.'">'.
					Img::a($this->avatar_uri, $w, $h,($this->gender==2)?'default-female.jpg':'default-male.jpg',
						array_merge($default_img_attributes , $img_attributes),
						array_merge($default_anchor_attributes , $anchor_attributes)
                	).
				'</div>';
	}

	public function getProfileLink($absolute=false){
		if($absolute || !(Yii::app() instanceof CWebApplication))
			return Yii::app()->urlManager->createAbsoluteUrl('user/view', array('id'=>$this->username));
		return Yii::app()->urlManager->createUrl('user/view', array('id'=>$this->username));
	}

	public function getUserFeed($limit=10, $types=array('thread','thread_reply'), $actions=array('Add'), $newer_than=0, $with_join=true){
		$condition = 'user_id='.$this->id;
		
		$last_index = count($types) - 1;
		$condition .= " AND (((";
		foreach($types as $key=>$type){
			$condition .= " {$type}_id IS NOT NULL";
			if($key < $last_index){
				$condition .= " OR";
			}
		}
		$condition .= " )";
		foreach($actions as $key=>$action){
			$actions[$key]='"'.$action.'"';
		}
		$actions=implode(', ', $actions);
		
		$condition .= " AND action IN ($actions)";
		$condition .= " )";
		if($with_join){
			$condition .= " OR action = 'Join'";
		}

		$condition .= " )";

		if($newer_than>0){
			$condition .= " AND created_at < {$newer_than}";
		}
		$user_feed = UserLog::model()->findAll(array(
			'condition' => $condition,
			'order' => 't.created_at DESC',
			'limit' => $limit,
			));
        return $user_feed;
	}
}