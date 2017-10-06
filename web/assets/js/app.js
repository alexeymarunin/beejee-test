function show_preview( uploaded_url ) {
    var preview = $('#preview');
    var title = $('.card-title');
    var email = $('.user-email');
    var image = $('.task-image');
    var text = $('.card-text');


    title.html($('#username').val());
    email.html($('#email').val());
    text.html($('#content').val());
    if ( uploaded_url ) image.attr( 'src', uploaded_url );

    preview.show();
}

$(document).ready(function() {
    $('#preview-btn').on('click', function() {
        show_preview();
    });
    $('#username').on('change', function() {
        show_preview();
    });
    $('#email').on('change', function() {
        show_preview();
    });
    $('#content').on('change', function() {
        show_preview();
    });
    $('#image').on('change', function() {
        var formElement = document.querySelector('form');
        var formData = new FormData(formElement);
        var request = new XMLHttpRequest();
        request.open('POST', '/image/upload');
        formData.append('preview', 1);

        request.onload = function(e) {
            if (request.status == 200) {
                var response = JSON.parse( request.response );
                show_preview( response.url );
            }
            else {
            }
        };

        request.send(formData);
    });
});