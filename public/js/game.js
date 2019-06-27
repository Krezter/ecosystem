function Game(server) {
    this.init = function() {
        let save = true;
        let previousSize = $('#size').val();

        /**
         * Отправить ajax запрос на новую игру
         */
        $('#new-game').on('click', async function() {
            const size = $('#size').val();
            const time = $('#time').val();

            if (size > 0 && time > 0) {
                previousSize = size;
                $('#textarea-logs').val('');
                const result = await server.startSimulation(size, time, save);

                if (result.result) {
                    $('#continue-game').prop( "disabled", false );
                    //console.log('Успешная отправка и принятие формы');
                    render(result.data);
                } else {
                    //console.log('Ошибка отправки запроса! ' + result.error);
                }
            } else {
                alert('Введите значения!');
            }
        });

        /**
         * Отправить ajax запрос на продолжение игры
         */
        $('#continue-game').on('click', async () => {
            const size = $('#size').val();
            const time = $('#time').val();

            if (size > 0 && time > 0) {
                const result = await server.continueSimulation(size, time, save);

                if (result.result) {
                    //console.log('Успешная отправка и принятие формы');
                    render(result.data);
                } else {
                    //console.log('Ошибка отправки запроса! ' + result.error);
                }
            } else {
                alert('Введите значения!');
            }
        });

        /**
         * Проверка на изменение размера карты
         */
        $('#size').on('keyup', async () => {
            const size = $('#size').val();
            if (previousSize !== size && previousSize !== 0) {
                $('#continue-game').prop( "disabled", true );
                $('#continue-game').prop('title', 'Нельзя продолжить изменив размер поля');
            }
            if (previousSize === size) {
                $('#continue-game').prop( "disabled", false );
                $('#continue-game').prop('title', '');
            }
        });

        /**
         * Чтение CSV файла и запись значений в поля размера и времени
         */
        $("#csv").change(function(e) {
            const ext = $("input#csv").val().split(".").pop().toLowerCase();
            if($.inArray(ext, ["csv"]) === -1) {
                return false;
            }
            if (e.target.files !== undefined) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const csvval=e.target.result.split("\n");
                    const csvvalue=csvval[0].split(",");
                    $('#size').val(csvvalue[0]);
                    $('#time').val(csvvalue[1]);
                    if (previousSize !== 0 && previousSize !== $('#size').val()) {
                        $('#continue-game').prop( "disabled", true );
                        $('#continue-game').prop('title', 'Нельзя продолжить изменив размер поля');
                    }
                };
                reader.readAsText(e.target.files.item(0));
            }
            return false;
        });

        $('.radio').change(function() {
            $('.radio').not(this).prop({checked: false});
            save = $('#db-save').prop('checked');
            previousSize = 0;
            $('#size').val(0);
            $('#continue-game').prop( "disabled", true );
            $('#continue-game').prop('title', 'Нельзя продолжить изменив сеанс');
        });
    };

    function render(data) {
        $('#textarea-logs').val(data);
    }
}