import $ from 'jquery'
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver';

$(document).ready(function () {
    tinymce.init({
        selector: '.tinymce',
        height: 400
    });

    $('.news-item').tooltip();
});
