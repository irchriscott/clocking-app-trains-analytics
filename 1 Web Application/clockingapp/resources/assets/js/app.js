require('./bootstrap');

$(function(){
    $(document).ready(function(){
        $(".cl-delete-user").deleteUser();
        $("#cl-users-list").loadUserReports();
        var items = $("#cl-users-list");
        var list = items.find("li");
        if(list.length > 0){
            var first = list.get(0);
            first.click();
        }
    });
});

//Confirm user deletation

jQuery.fn.deleteUser = function(){
    $(this).submit(function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("action");
        var data = new FormData($(this)[0]);
        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'accept',
            zindex: 999,
            title: 'Delete User',
            message: 'Do you really want to delete this user ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    $.ajax({
                        type:"POST",
                        url: url,
                        data:data,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            if(response.type == "success"){
                                showSuccessMessage("success", response.text);
                                $("#user-" + id).fadeOut();
                            } else {
                                showErrorMessage("error", response.text);
                            }
                        },
                        error: function(error){
                            showErrorMessage("error", error);
                        }
                    });
                    
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

//Load reports on user click

jQuery.fn.loadUserReports = function(){
    $(this).children("li").click(function(){
        var url = $(this).attr("data-url");
        $(this).addClass("active").siblings().removeClass("active");
        setLoadData("cl-reports-container", url);
    });
}

// Show toast for different messages

function showInfoMessage(id, message) {
    iziToast.info({
        id: id,
        timeout: 5000,
        title: 'Info',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false,
    });
}

function showErrorMessage(id, message) {
    iziToast.error({
        id: id,
        timeout: 5000,
        title: 'Error',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false,
    });
}

function showSuccessMessage(id, message) {
    iziToast.success({
        id: id,
        timeout: 5000,
        title: 'Success',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false,
    });
}

function setLoadData(container, url) {
    setTimeout(function () {
        $("#" + container).load(url, function () {
            $(this).children("span").hide();
        }, function (error) {
            showErrorMessage("error", error);
        });
    });
}