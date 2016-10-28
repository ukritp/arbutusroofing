/**
 * SEARCH AJAX AUTOCOMPLETE USING TYPEHEAD + BLOODHOUND
 * https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md
 * https://github.com/bassjobsen/typeahead.js-bootstrap-css/blob/master/typeaheadjs.css
 * https://github.com/twitter/typeahead.js/blob/master/doc/bloodhound.md
 */
 $(document).ready(function () {
    var route = $('#data-route').val();
    // Set the Options for "Bloodhound" suggestion engine
    var engine = new Bloodhound({
        remote: {
            url: route+'/searchajax?keyword=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('keyword'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".keyword").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    },{
        source: engine.ttAdapter(),

        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        // name: 'usersList',

        // // the key from the array we want to display (name,id,email,etc...)
        templates: {
            // empty: [
            //     '<div class="list-group search-results-dropdown"><div class=""> Nothing found --</div></div>'
            // ],
            // header: [
            //     '<div class="list-group search-results-dropdown">Users</div>'
            // ],
            suggestion: function (data) {
                var href = route+"/"+data.id;
                return '<a href="'+href+'">'+ data.value + '</a>'
            }
        }
    });

});