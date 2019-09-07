import $ from "jquery";

$(document).ready(function () {

    let LPRO = LPRO || {};

    LPRO.Datepicker = {};

    LPRO.Datepicker.init = function () {
        $('.datepicker').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });
    };

    LPRO.Datepicker.init();
});
