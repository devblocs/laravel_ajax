// when document is loade
$('document').ready(function(){
    // get the button click event
    $('#show_password').on('click', function(){
        var passwordField = $('#password'); // save the password field
        var passwordFieldType = passwordField.attr('type'); // get the attribute type of password field

        // if field type is password
        if(passwordFieldType == 'password'){
            passwordField.attr('type', 'text'); // set password type to text
            $(this).text('Hide'); // set button text hide
        }else{
            passwordField.attr('type', 'password'); // set password type to text
            $(this).text('Show'); // set button text hide
        }
    });
});