import $ from "jquery";

$(document).ready(function () {

    let LPRO = LPRO || {};

    LPRO.Datepicker = {};

    LPRO.Datepicker.init = function () {
        $('.datepicker').datetimepicker({
            format: 'd/m/Y H:i'
        });
    };

    LPRO.Datepicker.init();
});
