<?php

class CacheCommand extends CConsoleCommand
{

  public function actionClear(){
    if(Yii::app()->cache instanceof CMemCache){
      echo "sending cache clear: ";
      system("( sleep 1; echo flush_all; sleep 1; echo quit; ) | nc localhost 11211");
    } else {
      system("redis-cli keys '*:dbschemamysql:*' | xargs -r redis-cli del");
      system("redis-cli keys '*COutputCache*' | xargs -r redis-cli del");
      system("redis-cli keys '*auth_item_parents_for_child*' | xargs -r redis-cli del");
    }
    if(Yii::app()->authManager instanceof CachingDbAuthManager) Yii::app()->authManager->purgeCache();
  }

  public function actionList($pattern="*"){
    var_dump(Yii::app()->cache->keys($pattern));
  }

  public function actionTest(){
    //var_dump(Yii::app()->cache);die();
    Yii::app()->commoncache->set('foobar', 15, 3600);
    var_dump(Yii::app()->commoncache->get('foobar'));
  }

}