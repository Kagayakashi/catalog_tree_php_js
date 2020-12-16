<?php

require_once 'db.php';

class Application {
    private $db;
    private $html = '';
    
    // Запуск приложения
    public function run() {
        $params['host'] = 'localhost';
        $params['user'] = 'root';
        $params['pass'] = '';
        $params['db'] = 'test';
        
        $this->db = new Database($params);
        $this->init();
        $this->html_startup();
        $this->render();
    }
    
    // Инициализация переменных сессии
    private function init() {
        session_start();
        if(!isset($_SESSION['is_logged_in'])) {
            $_SESSION['is_logged_in'] = false;
        }
        if(!isset($_SESSION['state'])) {
            $_SESSION['state'] = 'login';
        }
        if(!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 0;
        }
        if(!isset($_SESSION['result'])){
          $_SESSION['result'] = null;
        }
    }
    
    // Вывод html на страницу
    private function render() {
        echo $this->html;
    }
    
    // Формирование основного документа html
    private function html_startup() {
        $this->html = '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Дерево</title>
                <link rel="stylesheet" href="styles.css">
            </head>
            <body>
                <div id="app">
                    '.$this->html_body().'
                </div>
                <script>console.log(\''.$_SESSION['result'].'\')</script>
                <script src="js/prevent_resubmit_form.js"></script>
                <script src="js/ajax.js"></script>
                <script src="js/goto_auth.js"></script>
                <script src="js/action_auth.js"></script>
                <script src="js/tree.js"></script>
                <script src="js/edit_tree.js"></script>
            </body>
        </html>';
    }
    
    // Формирование тела body в html по условию. Логин, регистрация или дерево.
    private function html_body() {

        if($_SESSION['is_logged_in']) {
            $html = $this->html_tree();
        }
        elseif($_SESSION['state'] == 'register') {
            $html = $this->html_register();
        }
        elseif($_SESSION['state'] == 'login') {
            $html = $this->html_login();
        }
        
        return $html;
    }
    
    // Формирование тела body в html для логина
    private function html_login() {
        $html = '<form action="/" method="post">';
        $html .= '<label for="username"><b>Наименование</b></label><br>';
        $html .= '<input id="login_form_username" type="text" placeholder="Наименование" name="username" id="username" required><br>';
        $html .= '<label for="password"><b>Пароль</b></label><br>';
        $html .= '<input id="login_form_password" type="password" placeholder="Пароль" name="password" id="password" required><br>';
        $html .= '<input id="login_form_action" type="hidden" name="action" value="login">';
        $html .= '<input type="submit" value="Войти" onclick="action_login()">';
        $html .= '</form><br>';
        
        $html .= $this->html_goto_register();
        
        return $html;
    }
    
    // Формирование тела body в html для регистрации
    private function html_register() {
        $html = '<form action="/" method="post">';
        $html .= '<label for="username"><b>Наименование</b></label><br>';
        $html .= '<input id="login_form_username" type="text" placeholder="Наименование" name="username" id="username" required><br>';
        $html .= '<label for="password"><b>Пароль</b></label><br>';
        $html .= '<input id="login_form_password" type="password" placeholder="Пароль" name="password" id="password" required><br>';
        $html .= '<label for="password-repeat"><b>Пароль еще раз</b></label><br>';
        $html .= '<input id="login_form_passwordre" type="password" placeholder="Пароль еще раз" name="password-repeat" id="password-repeat" required><br>';
        $html .= '<input id="login_form_action" type="hidden" name="action" value="register">';
        $html .= '<input type="submit" value="Зарегистрироваться" onclick="action_register()">';
        $html .= '</form><br>';
        
        $html .= $this->html_goto_login();
        
        return $html;
    }
    
    // Формирование дерева элементов
    // Выполняется запрос в БД на получение данных
    private function html_tree() {
        $html = '<ul class="tree"><li>'.$this->html_new_element_form().'</li>';
        
        $elems = $this->db->data_select($_SESSION['user_id']);
        
        $html .= $this->html_tree_foreach($elems);
        
        $html .= $this->html_logout();
        
        return $html;
    }
    
    // Формирование основных элементов дерева, для каждого элемента выполняется:
    //    -формирование кнопок "добавить", "изменить", "удалить"
    //    -рекурсивный вызов функции html_tree_subelems, для формирования дочерних элементов
    private function html_tree_foreach($elems) {
        $html = '';
        
        if(!$elems) {
            return $html;
        }
        
        while($row = $elems->fetch_assoc()) {
            $html .= '<li><span class="caret">'.$row['S_NAME'].' </span>';
            $html .= '<span class="caret-desc">['.$row['S_DETAILS'].']</span>';
            $html .= ' | ';
            $html .= '<span class="caret-edit" id="edit_elem_btn_'.$row['I_ID'].'" onclick="edit_elem_form(event)">Изменить</span>';
            $html .= ' | ';
            $html .= '<span class="caret-delete">'.$this->html_delete_element_form($row).'</span>';
            $html .= $this->html_edit_element_form($row);
            $html .= $this->html_tree_subelems($row['I_ID']);
            $html .= '</li>';
        }
        
        return $html;
    }
    
    // Рекурсивная функция
    // Формирование дочерних элементов дерева
    // Выполняется запрос в БД на получение данных
    private function html_tree_subelems($parent_id) {
        $html = '<ul class="nested">';
        $html .= '<li>'.$this->html_new_element_form($parent_id).'</li>';
      
        $elems = $this->db->data_select($_SESSION['user_id'], $parent_id);
      
        // Return and close "ul" if no result
        if($elems) {
            $html .= $this->html_tree_foreach($elems);
        }
      
        $html .= '</ul>';
      
        return $html;
    }
    
    // Формирование формы заполнения для кнопки "Добавить элемент"
    private function html_new_element_form($parent_id = 0) {
        $html = '<span class="new_element_btn" id="new_elem_btn_'.$parent_id.'" onclick="add_new_elem_form(event)">Добавить элемент</span>';
      
        $html .= '<form action="" id="new_elem_frm_'.$parent_id.'" class="new_form" method="post">
          <input type="text" class="new_element_text" id="new_elem_txt_'.$parent_id.'" placeholder="Наименование">
          <br><input type="text" class="new_element_desc" id="new_elem_dtl_'.$parent_id.'" placeholder="Описание">
          <br><input type="submit" class="new_element_sbm" id="new_elem_sbm_'.$parent_id.'" value="Добавить" onclick="add_new_elem(event)">
        </form>';
      
        return $html;
    }
    
    // Формирование формы заполнения для кнопки "Изменить элемент"
    private function html_edit_element_form($row) {
        $html = '<form action="" id="edit_elem_frm_'.$row['I_ID'].'" class="edit_form" method="post">
          <input type="text" class="edit_element_text" id="edit_elem_txt_'.$row['I_ID'].'" placeholder="Наименование" value="'.$row['S_NAME'].'">
          <br><input type="text" class="edit_element_desc" id="edit_elem_dtl_'.$row['I_ID'].'" placeholder="Описание" value="'.$row['S_DETAILS'].'">
          <br><input type="submit" class="edit_element_sbm" id="edit_elem_sbm_'.$row['I_ID'].'" value="Изменить" onclick="edit_elem(event)">
        </form>';
      
        return $html;
    }
    
    // Формирование формы удаления элемента для кнопки "Удалить элемент"
    private function html_delete_element_form($row) {
        $html = '<form action="" class="del_form" method="post">
          <input type="submit" class="del_element_sbm" value="Удалить" onclick="del_elem('.$row['I_ID'].')">
        </form>';
      
        return $html;
    }
    
    // Формирование формы для кнопки "Перейти в регистрацию"
    private function html_goto_register() {
        $html = '<form action="" class="" method="post">
          <input type="submit" class="" id="" value="Регистрация" onclick="goto_register()">
        </form>';
      
        return $html;
    }
    
    // Формирование формы для кнопки "Перейти в логин"
    private function html_goto_login() {
        $html = '<form action="" class="" method="post">
          <input type="submit" class="" id="" value="Авторизация" onclick="goto_login()">
        </form>';
      
        return $html;
    }
    
    // Формирование формы для кнопки "Выйти"
    private function html_logout() {
        $html = '<form action="" class="" method="post">
          <input type="submit" class="" id="" value="Выйти" onclick="action_logout()">
        </form>';
      
        return $html;
    }
}
