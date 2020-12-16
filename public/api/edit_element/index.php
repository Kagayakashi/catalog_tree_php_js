<?php

if(isset($_POST['action']) && $_POST['action'] == 'edit') {
    require_once '../../../db.php';
    
    $params['host'] = 'localhost';
    $params['user'] = 'root';
    $params['pass'] = '';
    $params['db'] = 'test';
    
    $db = new Database($params);
    $rsql = $db->data_update($_POST['id'], $_POST['name'], $_POST['details']);
    
    $result['error'] = 1;
    $result['result'] = "Edit error";
    
    if($rsql) {
        $result['error'] = 0;
        $result['result'] = "Edited";
    }
    
    echo json_encode($result);
}
