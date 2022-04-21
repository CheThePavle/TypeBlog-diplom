$(function() {
    window.onload = function () {
        var bodyHTML = $("body");
        bodyHTML.attr('class', 'loaded_hiding');
        window.setTimeout(function () {
            bodyHTML.attr('class', 'loaded');
            bodyHTML.removeAttr('loaded_hiding');
        }, 500);
    }
});