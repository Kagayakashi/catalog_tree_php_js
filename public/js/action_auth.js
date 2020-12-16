// Вызов ajax для запуска "Регистрации" или "Логина" пользователя

function action_login() {
    action = document.getElementById('login_form_action').value;
    
    if(action != 'login') {
        return;
    }
    
    username = document.getElementById('login_form_username').value;
    password = document.getElementById('login_form_password').value;
    
    if(username === '' || password === '') {
        return;
    }
    
    ajax('auth', 'action=login_action&password=' + password + '&username=' + username);
}

function action_register() {
    action = document.getElementById('login_form_action').value;
    
    if(action != 'register') {
        return;
    }
    
    username = document.getElementById('login_form_username').value;
    password = document.getElementById('login_form_password').value;
    passwordre = document.getElementById('login_form_passwordre').value;
    
    if(password != passwordre || username === '' || password === '' || passwordre === '') {
        return;
    }
    
    ajax('auth', 'action=register_action&password=' + password + '&passwordre=' + passwordre + '&username=' + username);
}

function action_logout() {
    ajax('auth', 'action=logout_action');
}
