
function setFavoriteAdv(id, t) {
    $.get('/adverts/favorites/' + id, function (data) {
        if (data == 'true')
            $(t).find('i').attr('class', 'fa fa-bookmark');
        else
            $(t).find('i').attr('class', 'fa fa-bookmark-o');
    })
}

function loadFields(t) {

    $("#Adverts_category_id").val($(t).val());

    $.get('/cat_fields/' + $(t).val(), function (data) {

        if (data.indexOf('fields_list') !== -1)
            $("#bulletin_form").show();
        else
            $("#bulletin_form").hide();

        console.log(t);
        console.log($(t).parent());

        $(t).parent().parent().find('div.ajax-div').html("<div>" + data + "<div class='ajax-div'></div></div>");
    });

}
