
function setFavoriteAdv(id, t) {
    $.get('/adverts/favorites/' + id, function (data) {
        if (data == 'true')
            $(t).find('i').attr('class', 'fa fa-bookmark');
        else
            $(t).find('i').attr('class', 'fa fa-bookmark-o');
    })
}

function refreshChat(id) {
    $("#chat").html('<div class="spinner-border m-5" role="status"><span class="sr-only">Loading...</span></div>');
    $("#chat").load( "/lk/messages/dialog?chat_id="+id );
}

