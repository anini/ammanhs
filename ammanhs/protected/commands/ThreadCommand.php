<?php

class ThreadCommand extends CConsoleCommand
{

  public function actionUpdateUniqueTitles(){
    $threads=Thread::model()->findAll();
    foreach($threads as $thread){
      $thread->generateUniqueTitle();
    }
  }

}