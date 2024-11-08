$(document).ready(function () {
    $('.offers-form').on('beforeSubmit', function () {
        alert('Валидация формы прошла успешно');
    });

    function updateData() {
        var name = $('#name-input').val();
        var email = $('#email-input').val();

        $.ajax({
            url: 'offers/index', // Укажите правильный URL
            type: 'GET',
            data: {
                name: name,
                email: email
            },
            success: function (response) {
                $('#data-container').html(response); // Обновляем контейнер данными
            },
            error: function () {
                alert('Ошибка при обновлении данных.');
            }
        });
    }

    $('#name-input').on('input', updateData);
    $('#email-input').on('input', updateData);

    $('#offer-form').on('beforeSubmit', function (e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        var name = $('#offers-name').val();
        var email = $('#offers-email').val();
        var phone = $('#offers-phone').val();

        $.ajax({
            url: 'offers/create', // URL для отправки формы
            type: 'POST',
            data: {
                name: name,
                phone: phone,
                email: email,
            },
            success: function (response) {
                $('#offers-name').val('');
                $('#offers-email').val('');
                $('#offers-phone').val('');
                $.pjax.reload({ container: '#pjax-container' });
            },
            error: function () {
                alert('Ошибка при добавлении записи.');
            }
        });

        return false; // Предотвращаем дальнейшую отправку формы
    });

    $('.edit-button').on('click', function (e) {
        e.preventDefault(); // Предотвращаем переход по ссылке
        
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phone = $(this).data('phone');

        $('#edit-id').val(id);
        $('#edit-name').val(name);
        $('#edit-email').val(email);
        $('#edit-phone').val(phone);

       
        
        $('#edit-modal').show(); // Показываем модальное окно
        $('#form-container').hide();
    });

    // Обработка отправки формы редактирования
    $('#edit-form').on('submit', function (e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        var id = $('#edit-id').val();
        var name = $('#edit-name').val();
        var email = $('#edit-email').val();
        var phone = $('#edit-phone').val();

        $.ajax({
            url: 'offers/update?id=' + id,
            type: 'POST',
            data: {
                name: name,
                email: email,
                phone: phone,
            },
            success: function (response) {
                if (response.success) {
                    $.pjax.reload({ container: '#pjax-container' }); // Если используете Pjax

                    $('#edit-modal').hide(); // Закрываем модальное окно
                    
                    $('#form-container').show();
                    

                } else {
                    alert('пошёл: ' + response.errors);
                }
            },
            error: function () {
                alert('Ошибка при редактировании записи.');
            }
        });
    });
});