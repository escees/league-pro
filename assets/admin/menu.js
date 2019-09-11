import $ from "jquery";
import Chart from "chart.js";
require('../admin2/js/jquery.datetimepicker.full.min');

window.ShardsDashboards = window.ShardsDashboards ? window.ShardsDashboards : {};

$.extend($.easing, {
    easeOutSine: function easeOutSine(x, t, b, c, d) {
        return c * Math.sin(t / d * (Math.PI / 2)) + b;
    }
});

/**
 * Chart.js - Line Chart with Vertical Line
 */
Chart.defaults.LineWithLine = Chart.defaults.line;
Chart.controllers.LineWithLine = Chart.controllers.line.extend({
    draw: function draw(ease) {
        Chart.controllers.line.prototype.draw.call(this, ease);
        if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
            var activePoint = this.chart.tooltip._active[0],
                ctx = this.chart.ctx,
                x = activePoint.tooltipPosition().x,
                topY = this.chart.scales['y-axis-0'].top,
                bottomY = this.chart.scales['y-axis-0'].bottom;

            // Draw the line
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, topY);
            ctx.lineTo(x, bottomY);
            ctx.lineWidth = 0.5;
            ctx.strokeStyle = '#ddd';
            ctx.stroke();
            ctx.restore();
        }
    }
});



$(document).ready(function () {
    var LPRO = LPRO || {};

    LPRO.MatchDashboard = {};

    //@todo fix active class in menu
    var setDefaultActive = function() {
        var path = window.location.pathname;
        var menuItem = $("a.nav-item[href='" + path + "']");
        $('.main-sidebar').find('a.nav-link').removeClass('active');
        menuItem.addClass("active");
    };

    setDefaultActive();

    $('.toggle-sidebar').click(function (e) {
        $('.main-sidebar').toggleClass('open');
    });

    var slideConfig = {
        duration: 270,
        easing: 'easeOutSine'
    };

    $(window).on('load', function() {
        $('.match-datepicker').attr('value', '').val('')
    });

    $('.match-datepicker').datetimepicker({
        format: 'd/m/Y H:i'
    });

    // Add dropdown animations when toggled.
    $(':not(.main-sidebar--icons-only) .dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(slideConfig);
    });

    $(':not(.main-sidebar--icons-only) .dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(slideConfig);
    });


    LPRO.MatchDashboard.handleSetScoreForm = function () {
        $('.set-score').on('click', function (e) {
            let $matchId = $(this).data('match-id');
            let setScoreSelector = '#score-form-body';
            $(setScoreSelector).load($(this).data('href'));

            $('#edit-score-modal').on('show.bs.modal', function(e) {
                $(this).find('#save-score').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                    'data-match-id': $(e.relatedTarget).data('match-id')
                });
            });
        });
    };

    LPRO.MatchDashboard.handleDetailTooltips = function () {
        $('.match-details').tooltip();
    };


    LPRO.MatchDashboard.handleAjax = function () {
        var modalClose = true;
        $('body').on('click', '#save-score', function (e) {
            e.preventDefault();

            var $button = $(this);
            if ($button.hasClass('disabled')) {
                return;
            }

            var $form = $('form[name=simple_match_details]');
            var section = '#match-' + $(this).data('match-id');
            var $serializedForm = $form.serialize();
            var $section = $(section);
            var ajaxUrl = $(this).data('href');

            $.ajax({
                method: 'POST',
                url: ajaxUrl,
                data: $serializedForm
            }).done(function(data) {
                $button.removeClass('disabled');
                if (data.status === true) {
                    var $newSection = $(data.body).find(section);
                    $section.replaceWith($newSection);
                    window.location.reload()
                }
                if (typeof data.status === 'undefined') {
                    $('form[name=simple_match_details]').replaceWith(data);
                    modalClose = false;
                }
            }).always(function () {
                if(modalClose) {
                    $('.modal').modal('hide');
                }
            })
        });
    };

    LPRO.MatchDashboard.init = function () {
        LPRO.MatchDashboard.handleAjax();
        LPRO.MatchDashboard.handleSetScoreForm();
        LPRO.MatchDashboard.handleDetailTooltips();
    };

    LPRO.MatchDashboard.init();
});
