
function setFavoriteAdv(id, t) {
    $.get('/adverts/favorites/' + id, function (data) {
        if (data == 'true')
            $(t).find('i').attr('class', 'fa fa-bookmark');
        else
            $(t).find('i').attr('class', 'fa fa-bookmark-o');
    })
}

