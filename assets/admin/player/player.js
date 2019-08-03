import $ from "jquery";

$(document).ready(function () {

    if (sessionStorage.getItem('isJsAlreadyLoaded') === 'true') {
        return;
    }

    let LPRO = LPRO || {};

    LPRO.Player = {};

    LPRO.Player.handleAddPlayerForm = function () {
        $('.add-player').on('click', function (e) {
            let addPlayerFormSelector = '#add-player-form-body';
            console.log('dupa1');
            $(addPlayerFormSelector).html('');
            $(addPlayerFormSelector).load($(this).data('href'));

            $('#add-player-modal').on('show.bs.modal', function(e) {
                $(this).find('#save-player').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Player.handleEditPlayerForm = function () {
        $('.edit-player').on('click', function (e) {
            let editPlayerFormSelector = '#edit-player-form-body';
            $(editPlayerFormSelector).html('');
            console.log('dupa2');
            $(editPlayerFormSelector).load($(this).data('href'));

            $('#edit-player-modal').on('show.bs.modal', function(e) {
                $(this).find('#edit-player').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Player.handleDeletePlayerForm = function () {
        $('.delete-player').on('click', function (e) {
            $('#delete-player-modal').on('show.bs.modal', function(e) {
                $('#name').html($(e.relatedTarget).data('name'));
                $(this).find('#delete-player').attr({
                    'href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Player.handleSaveAddPlayerForm = function () {
        LPRO.Player.handleAjax('#save-player')
    } ;

    LPRO.Player.handleSaveEditPlayerForm = function () {
        LPRO.Player.handleAjax('#edit-player')
    } ;

    LPRO.Player.handleDetailTooltips = function () {
        $('.add-player').tooltip();
    };


    LPRO.Player.handleAjax = function (button) {
        let modalClose = true;
        $('body').on('click', button, function (e) {
            e.preventDefault();

            let $button = $(this);
            let isEditButton = button === '#edit-player';
            if ($button.hasClass('disabled')) {
                return;
            }

            let $form = $('form[name=player]');
            let section ='#team-list';
            let $serializedForm = $form.serialize();
            let $section = $(section);
            let ajaxUrl = $(this).data('href');

            if (isEditButton) {
                ajaxUrl = $form.data('edit-player');
            }

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
                    window.location.reload()
                }

                if (typeof data.status === 'undefined') {
                    $('form[name=player]').replaceWith($(data).find('form[name=player]'));
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
        LPRO.Player.handleAddPlayerForm();
        LPRO.Player.handleSaveEditPlayerForm();
        LPRO.Player.handleSaveAddPlayerForm();
        LPRO.Player.handleDeletePlayerForm();
        LPRO.Player.handleEditPlayerForm();
        // LPRO.Player.handleAjax();
    };

    LPRO.Player.init();
});
