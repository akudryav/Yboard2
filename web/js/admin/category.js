$(document).ready(function () {

    $("#category-params_flag").on('change', function () {
        if ($(this).is(":checked")) {
            $("#ref_book_items").show();
        } else {
            $("#ref_book_items").hide();
        }
    });

    $("#add-new-item").click(function (e) {
        /*var row = $("#template").clone(false).removeAttr('id');
        row.find('span').remove();
        row.find('is_select2').select2({
            tags: true
        });
        row.appendTo("#ref_book_items");*/
        $.ajax({
            url: "/admin/category/param",
            data: {'index': 0},
            success: function(data) {
                $('#ref_book_items').append(data);
            }
        });
        /*$.ajax({
            url: "/admin/category/param",
            dataType : 'html',
            cache: false,
            success : function(html){
                var li = $(html).find('li').html();
                $('#ref_book_items').append(li);
            }
        });*/

    });

    $("#ref_book_items").on("click", ".delete-item", function (e) {
        $(this).closest("li").remove();
        $("#ref_book_items").change();
    });
});
