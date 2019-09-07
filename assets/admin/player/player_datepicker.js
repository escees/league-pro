import $ from "jquery";

$(document).ready(function () {

    let LPRO = LPRO || {};

    LPRO.PlayerDatepicker = {};

    LPRO.PlayerDatepicker.init = function () {
        $('.datepicker').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });
    };

    LPRO.PlayerDatepicker.init();
});
