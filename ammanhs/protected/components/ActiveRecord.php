<?php
/****
 * 
 * based on ideas from:
 * http://www.yiiframework.com/wiki/123/multiple-database-support-in-yii/
 * http://www.yiiframework.com/extension/multiactiverecord/
 * 
 ****/

class AActiveRecord extends CActiveRecord
{
    // define a readonlydb in config and use it in subclasses
    private static $read_only=false;
    private static $read_only_cn=null;

    public function getDbConnection(){
        return (self::$read_only)?self::getReadOnlyDbConnection() : parent::getDbConnection();
    }

    public static function setReadOnly($status=true){
        self::$read_only=$status;
    }

    public static function setReadWrite(){
        self::$read_only=false;
    }

    public static function getReadOnlyStatus(){
        return self::$read_only;
    }

    /**
     * getReadOnlyDbConnection is a function that connect with read only DB if exist
     * @return CDbConnection
     */
    public static function getReadOnlyDbConnection(){
        // Returns the application components.
        $component=Yii::app()->getComponents(false);
        if(!isset($component['readonlydb']))
            return Yii::app()->db;
        if(!Yii::app()->readonlydb instanceof CDbConnection)
            return Yii::app()->db;
        return Yii::app()->readonlydb;
    }

    // subrelations concept
    public function subrelations(){
        return array();
    }

    public function getRelated($name, $refresh=false, $params=array()){
        $sub=$this->subrelations();
        if(!$refresh && isset($sub[$name])){
            list($other_name,$filter)=$sub[$name];
            if($this->hasRelated($other_name)){
                $this->_related[$name]=call_user_func(array(get_class($this),$filter), $this->_related[$other_name]);
                return $this->_related[$name];
            }
        }
        return parent::getRelated($name, $refresh, $params);
    }

    protected static function publishedFilter($superset) {
        $subset=array();
        foreach($superset as $e){
            if($e->publish_status>0) $subset[]=$e;
        }
        return $subset;
    }

    protected static function unpublishedFilter($superset){
        $subset=array();
        foreach($superset as $e){
            if($e->publish_status<=0) $subset[]=$e;
        }
        return $subset;
    }

}
