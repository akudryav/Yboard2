// Звёздный рейтинг
$(document).ready(function () {
    var opts = {
        units: 5,
        step: 1
    };
    var $rater = $("#star");
    $on = $rater.find('.rater-starsOn');
    $off = $rater.find('.rater-starsOff');
    opts.size = $on.height();
    if (opts.rating == undefined) opts.rating = $on.width() / opts.size;

    $off.mousemove(function (e) {
        var left = e.clientX - $off.offset().left;
        var width = $off.width() - ($off.width() - left);
        width = Math.ceil(width / (opts.size / opts.step)) * opts.size / opts.step;
        $on.width(width);
    }).hover(function (e) {
        $on.addClass('rater-starsHover');
    }, function (e) {
        $on.removeClass('rater-starsHover');
        $on.width(opts.rating * opts.size);
    }).click(function (e) {
        var r = Math.round($on.width() / $off.width() * (opts.units * opts.step)) / opts.step;
        $off.unbind('click').unbind('mousemove').unbind('mouseenter').unbind('mouseleave');
        $off.css('cursor', 'default');
        $on.css('cursor', 'default');
        $("#reviews-rating").val(r);
        $('#rateModal').modal('show');
    }).css('cursor', 'pointer');
    $on.css('cursor', 'pointer');

    $(".chat-list li").click(function () {
        $(".chat-list li").removeClass("active");
        $(this).addClass("active");
        $("#reviews-advert_id").val($(this).data("advert"));
    });
    $('#rating-form').on('beforeSubmit', function () {
        var $yiiform = $(this);
        // отправляем данные на сервер
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: $yiiform.serializeArray()
            })
            .done(function(data) {
                if(data.success) {
                    opts.rating = parseFloat(data.profile.rating_avg);
                    $off.fadeTo(200, 0.1, function () {
                        $on.removeClass('rater-starsHover').width(opts.rating * opts.size);
                        $rater.find('.rater-rateCount').text(data.profile.rating_count);
                        $rater.find('.rater-rating').text(opts.rating.toFixed(1));
                        $off.fadeTo(200, 1);
                    });
                    $('#rateModal').modal('hide')
                } else {
                    // сервер вернул ошибку и не сохранил наши данные
                    $("#feedback").html(data.errors).show();
                }
            })
            .fail(function () {
                // не удалось выполнить запрос к серверу
                alert("Ошибка сервера");
                $on.removeClass('rater-starsHover').width(opts.rating * opts.size);
                $off.fadeTo(2200, 1);
            })

        return false; // отменяем отправку данных формы

    })
});

