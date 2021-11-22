$(document).ready(function () {
    // показать-скрыть блок параметров
    $("#category-params_flag").on('change', function () {
        if ($(this).is(":checked")) {
            $("#ref_book_items").show();
        } else {
            $("#ref_book_items").hide();
        }
    });
    // копирование строки параметров
    $("#add-new-item").click(function (e) {
        var row = $("#ref_book_items").find('.list-group-item:last').clone(true);
        var inputs = row.find("input");
        var index = parseInt((/\[(\d*?)\]/g).exec($(inputs[0]).attr('name'))[1]);
        inputs.each(function () {
            var name = $(this).attr('name');
            name = name.replace('[' + index + ']', '[' + (index + 1) + ']');
            $(this).attr('name', name);
        });
        row.find("a[data-toggle='modal']").data('index', index + 1);
        row.appendTo("#ref_book_items .list-group");
    });
    // удаление строки параметров
    $("#ref_book_items").on("click", ".delete-item", function (e) {
        e.preventDefault();
        $(this).closest("li").remove();
        $("#ref_book_items").change();
    });
    // подготовка списка значений в модалке
    $('#catModal').on('show.bs.modal', function (e) {
        $("#optionsList").val('');
        console.log($(e.relatedTarget).data('index'));
    })
});
