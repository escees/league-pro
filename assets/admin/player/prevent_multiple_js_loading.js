import $ from "jquery";

$(document).ready(function () {
    'use strict';

    var LPRO = LPRO || {};

    LPRO.preventCaching = {};

    LPRO.preventCaching.setInSessionStorageLoadingInfo = function () {
        sessionStorage.setItem('isJsAlreadyLoaded', 'true');
    };

    LPRO.preventCaching.sessionStorageClear = function () {
        $(window).on("unload", function() {
            sessionStorage.clear();
        });
    };

    LPRO.preventCaching.init = function () {
        LPRO.preventCaching.sessionStorageClear();
        LPRO.preventCaching.setInSessionStorageLoadingInfo();
    };

    LPRO.preventCaching.init();
});
