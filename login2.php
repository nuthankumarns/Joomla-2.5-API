<?php
/*
 * Created on 11-Apr-12
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 /*
  * loading Joomla environment
  */
define( '_JEXEC', 1 );
$JUnit_home = $_SERVER['SCRIPT_FILENAME'];
//define('JPATH_BASE', dirname(__FILE__) );//this is when we are in the root
//define( 'JPATH_BASE', realpath(dirname(__FILE__)));
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/..' ));
//echo JPATH_BASE;exit();
define( 'DS', DIRECTORY_SEPARATOR );
//echo JPATH_BASE .DS.'includes'.DS.'defines.php';exit();
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
//require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'application'.DS.'component'.DS.'helper.php' );

 class serviceAuthentication
 {
 	function __construct() {
  // params
  $this->username = JRequest::getVar('user', '');
  $this->password = JRequest::getVar('password', '');
  //echo $this->username;exit();
  $this->checkParameters();
}

private function checkParameters() {
  // datatype checks
  if ($this->username == '') {
    die('ERROR: user is blank');
  }
  if ($this->password == '') {
    die('ERROR: password is blank');
  }

  self::execute();
  //$this->execute();
}

function execute() {

  jimport( 'joomla.user.authentication');
  jimport('joomla.application.component.helper');
 // jimport( 'joomla.session.session' );
//  jimport('joomla.plugin.plugin');
 // jimport( 'plugins.user.joomla.joomla' );
// echo JPATH_BASE;

 //require_once ( JPATH_BASE .DS.'plugins'.DS.'user'.DS.'joomla'.DS.'joomla.php' );
// import plugins/user/joomla/joomla.php;
  //import libraries/joomla/application/component/helper.php
  $mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
$mainframe->login();
  $auth =  JAuthentication::getInstance();

  $credentials = array( 'username' => $this->username, 'password' => $this->password );
 JFactory::getApplication()->login(array('username'=>$this->username, 'password'=>$this->password));

  //print_r($credentials);
  $options = array();
  $response = $auth->authenticate($credentials, $options);
  //$response = $auth->authenticate($result, $options);
  //  $session =& JFactory::getSession();
//$myUser = $session->get( 'myUser', 'empty' );
//$session =& JFactory::getSession();
//$session->set( 'myvar', 'helloworld' );
//onUserLogin::onUserLogin();
//var_dump($session);exit();
  echo json_encode($response);
  echo $response->status;
 //  echo JAUTHENTICATE_STATUS_SUCCESS;
//print_r($response);
  // success
 /* return ($response->status === JAUTHENTICATE_STATUS_SUCCESS) {
    $response->status = true;
  } else {
  // failed
    $response->status = false;
  }
  echo json_encode($response);*/
}
 }

 $a=new serviceAuthentication();

?>
