$(document).ready(function() {

    $('#exampleFormControlInputimage').on('change', function() {
        if ($('#exampleFormControlInputimage').val()) {
            val = 'Выбран файл: ' + $(this)[0].files[0]['name'];
            $('.custom-file-label').html(val);
        } else {
            $('.custom-file-label').text('Выберите изображение');
        }
    });

});