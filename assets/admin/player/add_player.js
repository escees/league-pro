import $ from "jquery";

$(document).ready(function () {

    if (sessionStorage.getItem('isJsAlreadyLoaded') === 'true') {
        return;
    }

    let LPRO = LPRO || {};

    LPRO.Player = {};

    LPRO.Player.handleAddPlayerForm = function () {
        console.log('dupa');
        $('.add-player').on('click', function (e) {
            let addPlayerFormSelector = '#add-player-form-body';
            $(addPlayerFormSelector).load($(this).data('href'));

            $('#add-player-modal').on('show.bs.modal', function(e) {
                $(this).find('#save-player').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Player.handleDetailTooltips = function () {
        $('.add-player').tooltip();
    };


    LPRO.Player.handleAjax = function () {
        let modalClose = true;
        $('body').on('click', '#save-player', function (e) {
            e.preventDefault();

            var $button = $(this);
            if ($button.hasClass('disabled')) {
                return;
            }

            let selectedTeamId = $('#player_team').find('option:selected').val();
            let $form = $('form[name=player]');
            let section ='.team-' + selectedTeamId;
            let $serializedForm = $form.serialize();
            let $section = $(section);
            let ajaxUrl = $(this).data('href');

            $.ajax({
                method: 'POST',
                url: ajaxUrl,
                data: $serializedForm
            }).done(function(data) {
                $button.removeClass('disabled');
                if (data.status === true) {
                    let $newSection = $(data.body).find(section);
                    $section.replaceWith($newSection);

                    if ($('.modal-backdrop').hasClass('show')) {
                        $('.modal-backdrop').removeClass('show')
                    }

                }
                if (typeof data.status === 'undefined') {
                    $('form[name=player]').replaceWith(data);
                    modalClose = false;
                }
            }).always(function () {
                if(modalClose) {
                    $('.modal').modal('hide');
                }
            })
        });
    };


    LPRO.Player.init = function() {
        // LPRO.Player.handleScorersCollection();
        // LPRO.Player.handleCardsCollection();
        // LPRO.Player.handleGoalFormRow();
        LPRO.Player.handleAddPlayerForm();
        LPRO.Player.handleAjax();
    };

    LPRO.Player.init();
});
