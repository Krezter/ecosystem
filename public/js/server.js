function Server() {
    let token;

    this.test = function () {
        return $.post('/test', { method: 'test'});
    };

    this.startSimulation = function (size, time, save) {
        return $.post('api', { method: 'startSimulation', size : size, time : time, token : token, save : save});
    };

    this.continueSimulation = function (size, time, save) {
        return $.post('api', { method: 'continueSimulation', size : size, time : time, token : token, save : save});
    };

    this.login = async function (login, password) {
        const result = await $.post('/login', { method: 'login', login, password });
        if (result.result) {
            token = result.data;
        }
        return result;
    };

    this.logout = async function () {
        return $.post('/logout', { method: 'logout', token });
    };
}