import $ from "jquery";
import 'multiselect'
import 'jquery.quicksearch'

$(document).ready(function () {
    'use strict';

    var LeaguePro = LeaguePro || {};

    LeaguePro.Season = {};

    LeaguePro.Season.handleTeamsMultiselect = function () {
        $('#season_teams').multiSelect({
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

    LeaguePro.Season.init = function () {
        LeaguePro.Season.handleTeamsMultiselect();
    };

    LeaguePro.Season.init();
});
