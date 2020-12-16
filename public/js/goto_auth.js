// Вызов ajax для смены состояния в приложении на "Регистрация" или "Логин"

function goto_login() {
    ajax('auth', 'action=login');
}

function goto_register() {
    ajax('auth', 'action=register');
}
