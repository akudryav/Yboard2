$(document).ready(function () {

    var refreshChat = function (id) {
        $("#chat").html('<div class="spinner-border m-5" role="status"><span class="sr-only">Loading...</span></div>');
        $("#chat").load("/lk/messages/dialog?chat_id=" + id);
    }

    $("#plist").on("click", ".clearfix", function () {
        refreshChat($(this).data('chat'));
    });

    $("#chat").on("click", "form .input-group-prepend", function () {
        var form = $("#messages-form");
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            data   : form.serialize(),
            success: function (response) {
                if(response.success) {
                    $("#success_alert").addClass("show");
                    $("#messages-message").val('');
                    refreshChat(form.find("#messages-chat_id").val());
                } else {
                    $("#error_alert").addClass("show");
                }
            },
            error  : function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});