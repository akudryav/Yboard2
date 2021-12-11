$(document).ready(function () {
    $(".js_favor").click(function (e) {
        e.preventDefault();
        var link = $(this);
        var iclass = 'fa fa-bookmark-o';
        var title = 'Добавить в избранное';
        $.get('/adverts/favorites/' + link.data('id'), function (data) {
            if (data == 'true') {
                iclass = 'fa fa-bookmark';
                title = 'Удалить из избранного';
            }
            link.find('i').attr('class', iclass);
            link.attr('title', title);
            if(link.hasClass('btn')) {
                link.text(title);
            }
        })
    });
});



