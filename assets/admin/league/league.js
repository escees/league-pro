import $ from "jquery";
import 'multiselect'
import 'jquery.quicksearch'

$(document).ready(function () {
    'use strict';

    var LeaguePro = LeaguePro || {};

    LeaguePro.League = {};

    LeaguePro.League.handleTeamsMultiselect = function () {
        $('#league_teams').multiSelect({
            selectableHeader: "<input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Wyszukaj drużynę'>",
            selectionHeader: "<input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Wyszukaj drużynę'>",
            afterInit: function(ms){
                let that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function(){
                this.qs1.cache();
                this.qs2.cache();
            }
        });
    };

    LeaguePro.League.handlePlayoffSelect = function () {
        $('#league_isPlayOff').change(function() {
            if (this.checked) {
                $('.playoff-league-select').removeClass('hide')
            }
            if (!this.checked) {
                $('.playoff-league-select').addClass('hide')
            }
        });
    }

    LeaguePro.League.init = function () {
        LeaguePro.League.handleTeamsMultiselect();
        LeaguePro.League.handlePlayoffSelect();
    };

    LeaguePro.League.init();
});
