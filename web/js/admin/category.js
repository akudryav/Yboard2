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
    $("#add-new-item").click(function () {
        var row = $("#ref_book_items").find(".list-group-item:last").clone(true);
        var inputs = row.find("input");
        var index = parseInt((/\[(\d*?)\]/g).exec($(inputs[0]).attr('name'))[1]);
        inputs.each(function () {
            var name = $(this).attr('name');
            name = name.replace('[' + index + ']', '[' + (index + 1) + ']');
            $(this).attr('name', name);
            if(name.indexOf('values') !== -1) {
                row.find("a[data-toggle='modal']").data('name', name);
            }
            if(name.indexOf('code') !== -1) {
                $(this).val('');
            }
        });

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
        var name = $(e.relatedTarget).data('name');
        $(this).find('.btn-info').data('name', name);
        console.log("input[name='"+name+"']");
        var values = $("#ref_book_items").find("input[name='"+name+"']").val();
        values = values.replace(/,/g, "\n");
        $("#optionsList").val(values);
    })
    // Передача данных из модалки
    $("#catModal").on('click', '.btn-info', function () {
        var name = $(this).data('name');
        var values = $("#optionsList").val();
        values = values.replace(/\n/g, ",");
        $("#ref_book_items").find("input[name='"+name+"']").val(values);
        $('#catModal').modal('hide');
    });
});
