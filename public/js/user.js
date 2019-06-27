function User(options) {
    const server = options.server;
    const callbacks = options.callbacks || {};
    const loginSuccess = callbacks.loginSuccess;
    const logoutSuccess = callbacks.logoutSuccess;

    this.init = function() {
        $('#auth').on('click', async () => {
            const login = $('#login').val();
            const password = $('#password').val();
            if (login && password) {
                const result = await server.login(login, password);
                if (result.result) {
                    const result = await server.checkPreviousGame();
                    if (result.result && result.data !== 0) {
                        $('#continue-game').prop( "disabled", false );
                        $('#size').val(result.data);
                    } else {
                        $('#continue-game').prop( 'disabled', true);
                    }
                    loginSuccess();
                } else {
                    alert('Неудачная авторизация!');
                }
            } else {
                alert('Введите логин и пароль!');
            }
        });

        $('#logout').on('click', async () => {
            const result = await server.logout();
            if (result.result) {
                logoutSuccess();
            } else {
                alert('Вылогиниться не удалось!');
            }
        });
    }
}