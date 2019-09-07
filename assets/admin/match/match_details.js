import $ from "jquery";

$(document).ready(function () {

    let LPRO = LPRO || {};

    LPRO.MatchDetails = {};

    LPRO.MatchDetails.handleGoalFormRow = function () {
        LPRO.MatchDetails.handleMatchEventFormRow('.add-scorer', '.goal-type-field');
    };

    LPRO.MatchDetails.handleCardFormRow = function () {
        LPRO.MatchDetails.handleMatchEventFormRow('.add-card', '.card-type-field');
    };

    LPRO.MatchDetails.handleMatchEventFormRow = function (matchEventAddButton, matchEventTypeField) {
        $(matchEventAddButton).on('click', function () {
            $(matchEventTypeField).parent().addClass('col-sm-12 col-md');
        })
    };

    LPRO.MatchDetails.addNewMatchEventForm = function ($collectionHolder, $newLinkButton, $deleteLink,  $condition)  {
        let prototype = $collectionHolder.data('prototype');
        let index = $collectionHolder.data('index');
        let newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);
        let $newFormLi = $("<div class=\"" + $condition + "\"></div>")
            .append($deleteLink)
            .append(newForm);


        $newLinkButton.before($newFormLi);
    };

    LPRO.MatchDetails.addEventDeleteLink =  function ($field) {
        $($field).on('click', function(e) {
            e.preventDefault();
            $(this).parent().fadeOut().remove();
        });
    };

    // @todo to refactor
    LPRO.MatchDetails.handleScorersCollection = function() {
        var $collectionHolder;

        let $scorers = $('.scorers');
        let $addLink = $($scorers.data('add-scorer-link'));
        var $newLinkDiv = $('<div></div>').append($addLink);
        $collectionHolder = $scorers;
        $collectionHolder.append($newLinkDiv);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addLink.on('click', function(e) {
            addScorerForm($collectionHolder, $newLinkDiv);
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-scorer');

        var addScorerForm = function ($collectionHolder, $newLinkDiv) {
            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index');
            var newForm = prototype;
            newForm = newForm.replace(/__name__/g, index);
            $collectionHolder.data('index', index + 1);

            var $newFormLi = $('<div></div>').append(newForm);
            $newLinkDiv.before($newFormLi);

            LPRO.MatchDetails.addEventDeleteLink('.delete-scorer');
        }


        //@todo to investigate

        // let $scorers = $('.scorers');
        // let addLink = $scorers.data('add-session-condition-link');
        // let deleteLink = $scorers.data('delete-session-condition-link');
        // let $addConditionLink = $(addLink);
        // let $newLinkButton = $('<div></div>').append($addConditionLink);
        // let $sessionCondition = 'scorer';
        //
        // let $collectionHolder = $scorers;
        // $collectionHolder.append($newLinkButton);
        //
        // $collectionHolder.data('index', $collectionHolder.find('.' + $sessionCondition).length);
        //
        // $addConditionLink.on('click', function(e) {
        //     e.preventDefault();
        //
        //     LPRO.MatchDetails.addNewMatchEventForm($collectionHolder, $newLinkButton, deleteLink, $sessionCondition );
        // });
        //
        // LPRO.MatchDetails.addEventDeleteLink('.delete-scorer', '.'+$sessionCondition);
    };



    // @todo to refactor
    LPRO.MatchDetails.handleCardsCollection = function() {
        var $collectionHolder;

        let $matchCards = $('.match-cards');
        let $addLink = $($matchCards.data('add-card-link'));
        let $newLinkDiv = $('<div></div>').append($addLink);
        $collectionHolder = $matchCards;
        $collectionHolder.append($newLinkDiv);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addLink.on('click', function(e) {
            addCardForm($collectionHolder, $newLinkDiv);
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-card');

        var addCardForm = function ($collectionHolder, $newLinkDiv) {
            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index');
            var newForm = prototype;
            newForm = newForm.replace(/__name__/g, index);
            $collectionHolder.data('index', index + 1);

            var $newFormLi = $('<div></div>').append(newForm);
            $newLinkDiv.before($newFormLi);

            LPRO.MatchDetails.addEventDeleteLink('.delete-card');
        }
    };

    LPRO.MatchDetails.init = function() {
        LPRO.MatchDetails.handleScorersCollection();
        LPRO.MatchDetails.handleCardsCollection();
        LPRO.MatchDetails.handleGoalFormRow();
        LPRO.MatchDetails.handleCardFormRow();
    };

    LPRO.MatchDetails.init();
});
