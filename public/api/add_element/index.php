<?php

session_start();
$user =  $_SESSION['user_id'];

if(!isset($user) || $user < 1) {
    return;
}

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    require_once '../../../db.php';
    
    $params['host'] = 'localhost';
    $params['user'] = 'root';
    $params['pass'] = '';
    $params['db'] = 'test';
    
    $db = new Database($params);
    
    $rsql = $db->data_insert($user, $_POST['name'], $_POST['details'], $_POST['parent_id']);
    
    $result['error'] = 1;
    $result['result'] = "Add error";
    
    if($rsql) {
        $result['error'] = 0;
        $result['result'] = "Added";
    }
    
    echo json_encode($result);
}
