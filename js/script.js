$(document).ready(function() {

    // menghilangkan tombol pencarian
    $('#tombol-cari').hide()

    // event ketika keyword pencarian diisi
    $('#keyword').on('keyup', function() {

        // munculkan icon loading
        $('.loader').show();

        // ajax using load
        // $('#container').load('ajax/movies.php?keyword=' + $('#keyword').val());

        // $.get()
        $.get('ajax/movies.php?keyword=' + $('#keyword').val(), function(data)  {
            $('#container').html(data);
            $('.loader').hide();
        });

    });

});