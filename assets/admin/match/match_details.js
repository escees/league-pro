import $ from "jquery";

$(document).ready(function () {

    var LPRO = LPRO || {};

    LPRO.MatchDetails = {};

    LPRO.MatchDetails.init = function() {
        LPRO.MatchDetails.handleScorersCollection();
        LPRO.MatchDetails.handleCardsCollection();
    };

    LPRO.MatchDetails.addNewMatchEventForm = function ($collectionHolder, $newLinkButton, $deleteLink, $condition)  {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);

        var $newFormLi = $("<div class=\"" + $condition + "\"></div>")
            .append(newForm)
            .append($deleteLink);

        $newLinkButton.before($newFormLi);
    }


    LPRO.MatchDetails.addEventDeleteLink =  function ($field, $condition) {
        $('html').on('click', $field, function(e) {
            e.preventDefault();

            $(this).parent($condition).remove();
        });
    }

    LPRO.MatchDetails.handleScorersCollection = function() {
        var addLink = $('.scorers').data('add-session-condition-link');
        var deleteLink = $('.scorers').data('delete-session-condition-link');
        var $addConditionLink = $(addLink);
        var $newLinkButton = $('<div></div>').append($addConditionLink);
        var $sessionCondition = 'scorer';

        var $collectionHolder = $('.scorers');
        $collectionHolder.append($newLinkButton);

        $collectionHolder.data('index', $collectionHolder.find('.' + $sessionCondition).length);

        $addConditionLink.on('click', function(e) {
            e.preventDefault();

            LPRO.MatchDetails.addNewMatchEventForm($collectionHolder, $newLinkButton, deleteLink, $sessionCondition );
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-scorer', '.'+$sessionCondition);
    };

    LPRO.MatchDetails.handleCardsCollection = function() {
        var addLink = $('.match-cards').data('add-card-link');
        var deleteLink = $('.match-cards').data('delete-card-link');
        var $addConditionLink = $(addLink);
        var $newLinkButton = $('<div></div>').append($addConditionLink);
        var $sessionCondition = 'match-card';

        var $collectionHolder = $('.match-cards');
        $collectionHolder.append($newLinkButton);

        $collectionHolder.data('index', $collectionHolder.find('.' + $sessionCondition).length);

        $addConditionLink.on('click', function(e) {
            e.preventDefault();

            LPRO.MatchDetails.addNewMatchEventForm($collectionHolder, $newLinkButton, deleteLink, $sessionCondition );
        });

        LPRO.MatchDetails.addEventDeleteLink('.delete-card', '.'+$sessionCondition);
    };

    LPRO.MatchDetails.init();
});
