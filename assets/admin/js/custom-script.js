// require('./materialize.min');

$(document).ready( function (){

    console.log('DOM fully loaded and parsed');

    $('.datepicker').on('mousedown', function(event) {
        event.preventDefault();
    });

    $('.datepicker').pickadate({
        format: 'Y-m-d'
    });

    $('.timepicker').pickatime({
        default: 'now',
        twelvehour: false,
        donetext: 'OK',
        autoclose: false,
        vibrate: true
    });

    $('.select-dropdown').on('mousedown', function(event) {
        event.preventDefault();
    });

    $('.dropdown-content > li').on('click', function(event) {
        $('.select-dropdown').removeClass('active');
        $(this).parent().css('display', 'none');
    });

});
