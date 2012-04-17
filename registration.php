<?php
/*
 * Created on 13-Apr-12
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


define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

function register_user ($email, $password){

$firstname = $email; // generate $firstname
$lastname = ''; // generate $lastname
$username = $email; // username is the same as email


/*
I handle this code as if it is a snippet of a method or function!!

First set up some variables/objects     */


//$acl =& JFactory::getACL(); Acl will not work in Joomla1.5/1.6        

/* get the com_user params */
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

$usersParams = &JComponentHelper::getParams( 'com_users' ); // load the Params

// "generate" a new JUser Object
$user = JFactory::getUser(0); // it's important to set the "0" otherwise your admin user information will be loaded

$data = array(); // array for all user settings


//original logic of name creation
//$data['name'] = $firstname.' '.$lastname; // add first- and lastname
$data['name'] = $firstname.$lastname; // add first- and lastname

$data['username'] = $username; // add username
$data['email'] = $email; // add email
//there's no gid field in #__users table from Joomla_1.7/2.5

$usertype = 'Registered';//this is not necessary!!!
jimport('joomla.application.component.helper');
/* this part of the snippet from here: /plugins/user/joomla/joomla.php*/
$config = JComponentHelper::getParams('com_users');
    // Default to Registered.
$defaultUserGroup = $config->get('new_usertype', 2);
//default to defaultUserGroup i.e.,Registered
$data['groups']=array($defaultUserGroup);
$data['password'] = $password; // set the password
$data['password2'] = $password; // confirm the password
$data['sendEmail'] = 1; // should the user receive system mails?

/* Now we can decide, if the user will need an activation */

 $useractivation = $usersParams->get( 'useractivation' ); // in this example, we load the config-setting
 //echo $useractivation;exit();
 if ($useractivation == 1) { // yeah we want an activation

 jimport('joomla.user.helper'); // include libraries/user/helper.php
 $data['block'] = 1; // block the User
 $data['activation'] =JUtility::getHash( JUserHelper::genRandomPassword() ); // set activation hash (don't forget to send an activation email)

}
else { // no we need no activation

 $data['block'] = 1; // don't block the user

}

if (!$user->bind($data)) { // now bind the data to the JUser Object, if it not works....
 JError::raiseWarning('', JText::_( $user->getError())); // ...raise an Warning
    return false; // if you're in a method/function return false

}

if (!$user->save()) { // if the user is NOT saved...
 JError::raiseWarning('', JText::_( $user->getError())); // ...raise an Warning

 return false; // if you're in a method/function return false

}

return $user; // else return the new JUser object

}

$email = JRequest::getVar('email');
$password = JRequest::getVar('password');

//echo 'User registration...'.'<br/>';
if(!register_user($email, $password))
{
$data['status']="failure";
echo json_encode($data);
}
else
{
$data['status']="success";
echo json_encode($data);
}
 //echo '<br/>'.'User registration is completed'.'<br/>';
?>
