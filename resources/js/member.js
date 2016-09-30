$('#form_logout').click(function (e) {
    e.preventDefault();
    $.post(
        '/logout',
        {},
        function (data) {
            if (data == 'ajax_ok') {
                $("#user-menu").load(location.href + " #user-menu");
            }
        },
        'text'
    );
});
$('#form_login').submit(function (e) {
    e.preventDefault();
    $.post(
        '/login',
        {
            login: $('#login').val(),
            password: $('#password').val()
        },
        function (data) {
            if (data == 'ajax_ok') {
                $("#user-menu").load(location.href + " #user-menu");
                $('.my-login-modal').modal('toggle');
            }
            else {
                $('#form-login-errors').html(data);
            }
        },
        'text'
    );
});