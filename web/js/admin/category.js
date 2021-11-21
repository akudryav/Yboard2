$(document).ready(function () {
    $('#category-params_flag').on('change', function () {
        if ($(this).is(':checked')) {
            alert('show');
        } else {
            alert('hide');
        }
    });

    $('#add-new-item').click(function (e) {
        var new_line = $('#ref_book_items li.dd-item.template').clone(true);
        new_line.removeClass('template');
        $('#ref_book_items ol.dd-list li.dd-item.template').before(new_line);
        $('#ref_book_items').change();
    });

    $('body').on('click', '.delete-item', function (e) {
        $(this).closest('li').remove();
        $('#ref_book_items').change();
    });
});



