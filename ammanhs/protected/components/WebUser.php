<?php
class WebUser extends CWebUser {

  private $_model;

  function getModel()
  {
      return $this->loadUser(Yii::app()->user->id);
    }

    protected function loadUser($id=null)
    {
      if($this->_model===null && $id !== null)
        $this->_model=User::model()->findByPk($id);
      return $this->_model;
  }

  /**
   * Return the roles the user are member of based on its session user id
   * @return array
   */
  public function getAuthAssignments()
  {
      return array_keys(Yii::app()->getAuthManager()->getAuthAssignments($this->id));
  }

}
