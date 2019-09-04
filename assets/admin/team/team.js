import $ from "jquery";

$(document).ready(function () {

    if (sessionStorage.getItem('isJsAlreadyLoaded') === 'true') {
        return;
    }

    let LPRO = LPRO || {};

    LPRO.Team = {};

    LPRO.Team.handleAddTeamForm = function () {
        $('.add-team').on('click', function (e) {
            let addPlayerFormSelector = '#add-team-form-body';
            $(addPlayerFormSelector).html('');
            $(addPlayerFormSelector).load($(this).data('href'));

            $('#add-team-modal').on('show.bs.modal', function(e) {
                $(this).find('#save-team').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Team.handleEditTeamForm = function () {
        $('.edit-team').on('click', function (e) {
            let editPlayerFormSelector = '#edit-team-form-body';
            $(editPlayerFormSelector).html('');
            $('#edit-team-form-body').load($(this).data('href'));

            $('#edit-team-modal').on('show.bs.modal', function(e) {
                $(this).find('#edit-team').attr({
                    'data-href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Team.handleDeleteTeamForm = function () {
        $('.delete-team').on('click', function (e) {
            $('#delete-team-modal').on('show.bs.modal', function(e) {
                $('#name').html($(e.relatedTarget).data('name'));
                $(this).find('#delete-team').attr({
                    'href': $(e.relatedTarget).data('href'),
                });
            });
        });
    };

    LPRO.Team.handleSaveAddTeamForm = function () {
        LPRO.Team.handleAjax('#save-team')
    } ;

    LPRO.Team.handleSaveEditTeamForm = function () {
        LPRO.Team.handleAjax('#edit-team')
    } ;

    LPRO.Team.handleAjax = function (button) {
        let modalClose = true;
        $('body').on('click', button, function (e) {
            e.preventDefault();

            let $button = $(this);
            let isEditButton = button === '#edit-team';
            if ($button.hasClass('disabled')) {
                return;
            }

            let $form = $('form[name=team]');
            let section ='#team-list';
            let $serializedForm = $form.serialize();
            let $section = $(section);
            let ajaxUrl = $(this).data('href');
            if (isEditButton) {
                ajaxUrl = $form.data('edit-team');
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
                    // window.location.reload()
                }

                if (typeof data.status === 'undefined') {
                    $('form[name=team]').replaceWith($(data).find('form[name=team]'));
                    modalClose = false;
                }
            }).always(function () {
                if(modalClose) {
                    $('.modal').modal('hide');
                }
            })
        });
    };


    LPRO.Team.init = function() {
        LPRO.Team.handleAddTeamForm();
        LPRO.Team.handleSaveEditTeamForm();
        LPRO.Team.handleSaveAddTeamForm();
        LPRO.Team.handleDeleteTeamForm();
        LPRO.Team.handleEditTeamForm();
    };

    LPRO.Team.init();
});
