$(document).ready(function () {
    var setDefaultActive = function() {
        var path = window.location.pathname;
        var menuItem = $(".top-menu .item[href='" + path + "']");

        menuItem.addClass("active");
    };

    setDefaultActive();

    $('.ui.dropdown.item').dropdown({
        on: 'hover',
    });

    $('.ui.left.sidebar').sidebar({
        transition: 'overlay'
    });

    $('.ui.sidebar')
        .sidebar({
            context: $('body')
        })
        .sidebar('attach events', '.menu .item')
    ;
});
