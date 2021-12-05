$(document).ready(function () {
    $("body").click(function (event) {
        $("#log").html("clicked: " + event.target.nodeName);
    });
});

function setFavoriteAdv(id, t) {
    $.get('/adverts/favorites/' + id, function (data) {
        if (data == 'true') {
            $(t).find('i').attr('class', 'fa fa-bookmark');
            $(t).attr('title', 'Удалить из избранного');
        } else {
            $(t).find('i').attr('class', 'fa fa-bookmark-o');
            $(t).attr('title', 'Добавить в избранное');
        }
    })
}


