$(document).ready(function () {
    // Hide the loader
    $('#search-loader').fadeTo(500, 0);

    /*
    * Dynamic navigation without reloading the browser
    * Based on the HTML5 History API
    */

    // Detect when a link with the class "search-link" is clicked
    $(document).on('click', 'a.search-link', function (event) {
        // Prevent default behaviour
        event.preventDefault();

        // Save the data attributes of the link
        type = $(this).data('search-type');
        data = $(this).data('search-data');

        // Determine whether to append additional data at the end of the URL
        append = null;
        if (data) {
            append = '/' + data;
        } else {
            append = '';
        }

        // Determine the requested page and push the changes to the URL
        switch (type) {
            case 'user':
                history.pushState(null, null, '/search/users' + append);
                break;
            case 'studio':
                history.pushState(null, null, '/search/studios' + append);
                break;
            case 'project':
                history.pushState(null, null, '/search/projects' + append);
                break;
            case 'topic':
                history.pushState(null, null, '/search/forums' + append);
                break;
            case 'post':
                history.pushState(null, null, '/search/posts' + append);
                break;
            default:
                history.pushState(null, null, '/search');
                break;
        }

        // Load the page following the updated URL
        loadPage();

    })

    $(document).on('click', '#search-go', function (event) {
        // Prevent default behaviour
        event.preventDefault();

        // Save the data attributes of the link
        type = $('#search-type').val();
        data = $('#search-query').val();

        if (!data) {
            halfmoon.initStickyAlert({
                content: 'Please enter a search query.',
                title: 'Invalid query',
                alertType: 'alert-danger',
                hasDismissButton: true,
                timeShown: 3000
            });
            return;
        }

        // Determine the requested page and push the changes to the URL
        switch (type) {
            case 'user':
                history.pushState(null, null, '/search/users/' + data);
                break;
            case 'studio':
                history.pushState(null, null, '/search/studios/' + data);
                break;
            case 'project':
                history.pushState(null, null, '/search/projects/' + data);
                break;
            case 'topic':
                history.pushState(null, null, '/search/forums/' + data);
                break;
            case 'post':
                history.pushState(null, null, '/search/posts/' + data);
                break;
            default:
                halfmoon.initStickyAlert({
                    content: 'Please select a valid search query type.',
                    title: 'Invalid query type',
                    alertType: 'alert-danger',
                    hasDismissButton: true,
                    timeShown: 3000
                });
                return;
        }

        new_pathname = document.location.pathname;
        old_pathname = new_pathname;

        // Load the page following the updated URL
        loadPage();

    })

    function loadPage() {
        // Show the loader
        $('#search-loader').fadeTo(500, 1);

        // Define regular expression to search for a segment of the URL
        regex = /\/search\/([a-z0-9]+)/;
        // Get the current pathname
        pathname = window.location.pathname;
        // Execute the regular expression
        match = pathname.match(regex);
        if (match != null) {
            match = match[1];
        }

        // Determine which file to load based on page
        page = null;
        switch (match) {
            case 'users':
                page = 'user';
                break;
            case 'studios':
                page = 'studio';
                break;
            case 'projects':
                page = 'project';
                break;
            case 'forums':
                page = 'topic';
                break;
            case 'posts':
                page = 'post';
                break;
            default:
                page = 'search';
                break;
        }

        // Load desired file using AJAX
        $.ajax({
            type: 'GET',
            url: '/resources/templates/search/' + page + '.html',
            success: function (data) {
                // Transition to new page
                $('#main-area').fadeTo(500, 0, function () {
                    $('#main-area').html(data);
                    $('#main-area').fadeTo(500, 1, function () {
                        // Hide the loader
                        $('#search-loader').fadeTo(500, 0);
                    })
                })
            }
        });
    }

    old_pathname = document.location.pathname;
    new_pathname = '';

    $(window).on('popstate', function () {
        new_pathname = document.location.pathname;
        //alert(old_pathname + '\n' + new_pathname);
        if (new_pathname != old_pathname) {
            console.log('Fired');
            loadPage();
        }
        old_pathname = new_pathname;
    })


    /*
    * User statistics
    * Based on the Scratch API and ScratchDB
    */









    /*
    username = $('#statistics').data('username');
    $('#statistics').html('<p class="text-center">Please wait while we load <b>' + username + '\'s</b> data...</p>');
    statistics = {}
    $.ajax({
        type: 'GET',
        url: 'https://api.allorigins.win/raw?url=https://api.scratch.mit.edu/users/' + username,
        dataType: 'json',
        success: function(response){
            if(response != ''){
                statistics.id = response.id;
            statistics.username = response.username;
            statistics.scratchteam = response.scratchteam;
            statistics.joined = response.history.joined;
            statistics.status = response.profile.status;
            statistics.bio = response.profile.bio;
            console.log(statistics);
            }else{
                $('#statistics').html('<p class="text-center text-danger">The user <b>' + username + '</b> does not exist!</p>');
                $('#user-loader').fadeTo(1000, 0);
            }
        }
    })*/
})