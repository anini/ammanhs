<?php

class Constants {

          //--*--//--*--//--*--//--*--//--*--//
         //--*--//--*--//--*--//--*--//--*--//
        //--*--//  Publish Statuses //--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //   common across various data    //
     //   nodes: threads, replies ...   //
    //--*--//--*--//--*--//--*--//--*--//

    const PUBLISH_STATUS_UNPUBLISHED=-10;
    const PUBLISH_STATUS_DRAFT=0;
    const PUBLISH_STATUS_PUBLISHED=10;

    private static $_publish_statuses=array(
        self::PUBLISH_STATUS_DRAFT=>'Draft',
        self::PUBLISH_STATUS_PUBLISHED=>'Published',
        self::PUBLISH_STATUS_UNPUBLISHED=>'Unpublished',
    );

    public static function publishStatuses(){
        return self::$_publish_statuses;
    }

    public static function publishStatus($id){
        if (isset(self::$_publish_statuses[$id]))
            return self::$_publish_statuses[$id];
        return '';
    }


        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//     User Types    //--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const USER_TYPE_USER='User';
    const USER_TYPE_MEMBER='Member';
    const USER_TYPE_HACKER='Hacker';
    const USER_TYPE_ADMIN='Admin';

    private static $_user_types=array(
        self::USER_TYPE_USER=>self::USER_TYPE_USER,
        self::USER_TYPE_MEMBER=>self::USER_TYPE_MEMBER,
        self::USER_TYPE_HACKER=>self::USER_TYPE_HACKER,
        self::USER_TYPE_ADMIN=>self::USER_TYPE_ADMIN
    );

    public static function userTypes(){
        return self::$_user_types;
    }

        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//    Thread Types   //--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const THREAD_TYPE_QUESTION='Question';
    const THREAD_TYPE_IDEA='Idea';
    const THREAD_TYPE_DISCUSSION='Discussion';
    const THREAD_TYPE_ANNOUNCEMENT='Announcement';
    const THREAD_TYPE_ARTICLE='Article';

    private static $_thread_types=array(
        self::THREAD_TYPE_QUESTION=>self::THREAD_TYPE_QUESTION,
        self::THREAD_TYPE_IDEA=>self::THREAD_TYPE_IDEA,
        self::THREAD_TYPE_DISCUSSION=>self::THREAD_TYPE_DISCUSSION,
        self::THREAD_TYPE_ANNOUNCEMENT=>self::THREAD_TYPE_ANNOUNCEMENT,
        self::THREAD_TYPE_ARTICLE=>self::THREAD_TYPE_ARTICLE
    );

    public static function threadTypes(){
        return self::$_thread_types;
    }

        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//     Vote Types    //--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const VOTE_UP=1;
    const VOTE_DOWN=-1;

    private static $_vote_types=array(
        self::VOTE_UP=>'VoteUp',
        self::VOTE_DOWN=>'VoteDown',
    );

    public static function voteType($vote_type){
        if(isset(self::$_vote_types[$vote_type]))
            return self::$_vote_types[$vote_type];
        return '';
    }

        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//  Membership Types //--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const MEMBERSHIP_TYPE_FREE='Free';
    const MEMBERSHIP_TYPE_GOLDEN='Golden';
    const MEMBERSHIP_TYPE_PREMIUM='Premium';

    private static $_membership_types=array(
        self::MEMBERSHIP_TYPE_FREE,
        self::MEMBERSHIP_TYPE_GOLDEN,
        self::MEMBERSHIP_TYPE_PREMIUM
    );

    public static function membershipTypes(){
        return self::$_membership_types;
    }
    
        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//Membership Statuses//--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const MEMBERSHIP_STATUS_PENDING=0;
    const MEMBERSHIP_STATUS_APPROVED=10;
    const MEMBERSHIP_STATUS_REJECTED=-10;

    private static $_membership_statuses=array(
        self::MEMBERSHIP_STATUS_PENDING=>'Pending',
        self::MEMBERSHIP_STATUS_APPROVED=>'Approved',
        self::MEMBERSHIP_STATUS_REJECTED=>'Rejected',
    );

    public static function getMembershipStatuses(){
        return array(
            self::MEMBERSHIP_STATUS_PENDING=>Yii::t('core', 'Pending'),
            self::MEMBERSHIP_STATUS_APPROVED=>Yii::t('core', 'Approved'),
            self::MEMBERSHIP_STATUS_REJECTED=>Yii::t('core', 'Rejected'),
        );
    }

    public static function membershipStatus($status){
        $memberships=self::getMembershipStatuses();
        if(isset($memberships[$status]))
            return $memberships[$status];
        return '';
    }

        //--*--//--*--//--*--//--*--//--*--//
       //--*--//--*--//--*--//--*--//--*--//
      //--*--//       Points      //--*--//
     //--*--//--*--//--*--//--*--//--*--//
    //--*--//--*--//--*--//--*--//--*--//

    const THREAD_ADDED_EARNED_POINTS=3;
    const THREAD_REPLY_ADDED_EARNED_POINTS=1;
    
    //--*--//--*--//--*--//--*--//--*--//

}
