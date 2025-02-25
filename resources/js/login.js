import $ from 'jquery';

// Toggle password visibility
$('.toggle-password').on('click', function() {
    let passwordField = $(this).closest('.input-group').find('.password');

    if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
    } else {
        passwordField.attr('type', 'password');
    }
});

// Toggle confirm password visibility
$('.toggle-confirm-password').on('click', function() {
    let confirmPasswordField = $(this).closest('.input-group').find('.confirm-password');

    if (confirmPasswordField.attr('type') === 'password') {
        confirmPasswordField.attr('type', 'text');
    } else {
        confirmPasswordField.attr('type', 'password');
    }
});
