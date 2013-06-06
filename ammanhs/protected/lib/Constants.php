<?php

class Constants {

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

    public static function membershipTypes() {
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
        if (isset($memberships[$status]))
            return $memberships[$status];
        return '';
    }
    
    //--*--//--*--//--*--//--*--//--*--//

}
