<?php
class WebUser extends CWebUser
{
    private $_model;

    function getModel(){
        return $this->loadUser(Yii::app()->user->id);
    }

    protected function loadUser($id=null){
        if($this->_model===null && $id !== null)
            $this->_model=User::model()->findByPk($id);
        return $this->_model;
    }

    /**
     * Return the roles the user are member of based on its session user id
     * @return array
     */
    public function getAuthAssignments(){
        return array_keys(Yii::app()->getAuthManager()->getAuthAssignments($this->id));
    }

    public function afterLogout(){
        Yii::app()->controller->redirect(Yii::app()->user->getReturnUrl('/'));
    }

    /**
     * Returns the URL that the user should be redirected to after successful login.
     * This property is usually used by the login action. If the login is successful,
     * the action should read this property and use it to redirect the user browser.
     * @param string $defaultUrl the default return URL in case it was not set previously. If this is null,
     * the application entry URL will be considered as the default return URL.
     * @return string the URL that the user should be redirected to after login.
     * @see loginRequired
     */
    public function getReturnUrl($defaultUrl=null)
    {
        if(isset(Yii::app()->session['return_url']))
            $return_url = Yii::app()->session['return_url'];
        elseif(isset($_SERVER['HTTP_REFERER']))
            $return_url = $_SERVER['HTTP_REFERER'];
        elseif($defaultUrl)
            $return_url = $defaultUrl;
        else
            $return_url = '/';
        return $return_url;
    }

    /**
     * @param string $value the URL that the user should be redirected to after login.
     */
    public function setReturnUrl($value)
    {
        Yii::app()->session['return_url'] = $value;
    }
}