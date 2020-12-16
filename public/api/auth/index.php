<?php
// Комплекс авторизации. "Логин", "Регистрация"

$AUTH_FORM_LIST = array('login', 'register');
$AUTH_ACTION_LIST = array('login_action', 'register_action', 'logout_action');

$result['error'] = 9;
$result['result'] = 'Nothing';

if(isset($_POST['action']) && in_array($_POST['action'], $AUTH_FORM_LIST)) {
    // Show Auth Form
    session_start();
    $_SESSION['state'] = $_POST['action'];
    
    $result['error'] = 0;
    $result['result'] = 'Form '.$_POST['action'];
}
elseif(isset($_POST['action']) && in_array($_POST['action'], $AUTH_ACTION_LIST)) {
    // Auth action
    session_start();
    
    require_once '../../../db.php';
    
    $params['host'] = 'localhost';
    $params['user'] = 'root';
    $params['pass'] = '';
    $params['db'] = 'test';
    
    $db = new Database($params);
    
    if($_POST['action'] == 'login_action') {
        $user_found = $db->user_select($_POST['username'], $_POST['password']);
        
        $result['error'] = 1;
        $result['result'] = 'Login Error';
        
        if($user_found != false) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $user_found;
            
            $result['error'] = 0;
            $result['result'] = 'Logged in';
        }
    }
    elseif($_POST['action'] == 'register_action') {
        $user_created = $db->user_insert($_POST['username'], $_POST['password']);
        
        $result['error'] = 1;
        $result['result'] = 'Register Error';
        
        if($user_created) {
            $_SESSION['state'] = 'login';
            $result['error'] = 0;
            $result['result'] = 'Registered';
        }
    }
    elseif($_POST['action'] == 'logout_action') {
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_id']);
        unset($_SESSION['state']);
        unset($_SESSION['result']);
        
        session_destroy();
        
        $result['error'] = 0;
        $result['result'] = 'Logged out';
    }
}

$_SESSION['result'] = json_encode($result);
echo json_encode($result);
