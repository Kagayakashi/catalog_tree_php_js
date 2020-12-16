<?php

if(isset($_POST['action']) && $_POST['action'] == 'del') {
    require_once '../../../db.php';
    
    $params['host'] = 'localhost';
    $params['user'] = 'root';
    $params['pass'] = '';
    $params['db'] = 'test';
    
    $db = new Database($params);
    $rsql = $db->data_delete($_POST['id']);
    
    $result['error'] = 1;
    $result['result'] = "Delete error";
    
    if($rsql) {
        $result['error'] = 0;
        $result['result'] = "Deleted";
    }
    
    echo json_encode($result);
}
