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

    LPRO.MatchDetails.addNewMatchEventForm = function ($collectionHolder, $newLinkButton, $condition)  {
        let prototype = $collectionHolder.data('prototype');
        let index = $collectionHolder.data('index');
        let newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);
        let $newFormLi = $("<div class=\"" + $condition + "\"></div>")
            .append(newForm);

        $newLinkButton.before($newFormLi);
    };


    LPRO.MatchDetails.addEventDeleteLink =  function ($field, $condition) {
        $('html').on('click', $field, function(e) {
            e.preventDefault();

            $(this).parent($condition).fadeOut().remove();
        });
    };

    LPRO.MatchDetails.handleScorersCollection = function() {
        let $scorers = $('.scorers');
        let addLink = $scorers.data('add-session-condition-link');
        let $addConditionLink = $(addLink);
        let $newLinkButton = $('<div></div>').append($addConditionLink);
        let $sessionCondition = 'scorer';

        let $collectionHolder = $scorers;
        $collectionHolder.append($newLinkButton);

        $collectionHolder.data('index', $collectionHolder.find('.' + $sessionCondition).length);

        $addConditionLink.on('click', function(e) {
            e.preventDefault();

            LPRO.MatchDetails.addNewMatchEventForm($collectionHolder, $newLinkButton, $sessionCondition );
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-scorer', '.'+$sessionCondition);
    };

    LPRO.MatchDetails.handleCardsCollection = function() {
        let $matchCards = $('.match-cards');
        let addLink = $matchCards.data('add-card-link');
        let $addConditionLink = $(addLink);
        let $newLinkButton = $('<div></div>').append($addConditionLink);
        let $sessionCondition = 'match-card';

        let $collectionHolder = $matchCards;
        $collectionHolder.append($newLinkButton);

        $collectionHolder.data('index', $collectionHolder.find('.' + $sessionCondition).length);

        $addConditionLink.on('click', function(e) {
            e.preventDefault();

            LPRO.MatchDetails.addNewMatchEventForm($collectionHolder, $newLinkButton, $sessionCondition );
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-card', '.'+$sessionCondition);
    };

    LPRO.MatchDetails.init = function() {
        LPRO.MatchDetails.handleScorersCollection();
        LPRO.MatchDetails.handleCardsCollection();
        LPRO.MatchDetails.handleGoalFormRow();
        LPRO.MatchDetails.handleCardFormRow();
    };

    LPRO.MatchDetails.init();
});
