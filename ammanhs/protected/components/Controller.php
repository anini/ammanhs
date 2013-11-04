<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $protocol;
	public $subdomain='www'; // if omitted will set to www
	public $basedomain=null;

	/**
	 * internally used method
	 */
	public function dynamicPartialCallback() {
		$params=func_get_args();
	    $view=array_shift($params);
	    $data=array_shift($params);
	    $processOutput=array_shift($params);
	    return $this->renderPartial($view, $data, true, $processOutput);
	}

	/**
	 * renders a partial dynamically even when done between beginCache/endCache
	 * Note: be aware of $data passed by controller
	 */
	public function dynamicPartial($view, $data=NULL, $processOutput=false) {
		return $this->renderDynamic('dynamicPartialCallback', $view, $data, $processOutput);
	}

	public function assertSubdomain(){
		$host=strstr($_SERVER['HTTP_HOST'], ':', true);
		if("$host:80"==$_SERVER['HTTP_HOST']){
			$_SERVER['HTTP_HOST']=$host;
		}
		$domains=explode(".", $_SERVER['HTTP_HOST'], 2);
		$subdomain=$domains[0];
		// Return with no-op if valid
		if($_SERVER['HTTP_HOST']==Yii::app()->params['host']){
			$this->subdomain='www';
			$this->basedomain=$_SERVER['HTTP_HOST'];
			return;
		}
		$this->subdomain=$subdomain;
		$this->basedomain=isset($domains[1])?$domains[1]:$_SERVER['HTTP_HOST'];
		if($this->basedomain!=Yii::app()->params['host']) $this->redirect('http://'.Yii::app()->params['host'].'/');
		if($subdomain=='www') return;
		$this->redirect('http://'.Yii::app()->params['host'].'/');
	}

	public function init(){
		parent::init();
		if(Yii::app()->getUser()->getIsGuest()){
			setcookie('bogo', '1', 0, '/', '.ammanhs.com');
		}else{
			setcookie('bogo', '0', 0, '/', '.ammanhs.com');
		}

        // Check if the user is banned
        if(!Yii::app()->user->isGuest){
        	if(Yii::app()->user->model->active<=0){
        		Yii::app()->user->logout();
        		$this->redirect('http://'.Yii::app()->params['host'].'?ref=sorry_user_banned');
        		die('Banned User');
        	}
        }

        $this->protocol=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])?"https":"http";

        $this->assertSubdomain(); // this would redirect non-valid subdomain  
    }

}