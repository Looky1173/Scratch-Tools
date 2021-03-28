$(document).ready(function () {
    loading = false;


    // Function to fetch user stats
    function getUser(username) {
        loading = true;
        setTimeout(function () {
            if (loading) {
                $('<div style="display: none;" id="still_loading" class="d-flex justify-content-center"><b class="text-secondary font-size-20"><i class="fas fa-search"></i> Still loading...</b></div>').insertAfter('#description');
                $('#still_loading').fadeIn(fadeAnimationDuration);
            }
        }, 5000);
        $.ajax({
            type: 'GET',
            url: '/api/statistics/users/' + username,
            dataType: 'json',
            success: function (response) {
                loading = false;
                if ($('#still_loading').length) {
                    $('#still_loading').fadeOut(fadeAnimationDuration, function () {
                        $('#still_loading').remove();
                    })
                }
                console.log(response);
                if (response.curator == true || response.school != null) {
                    if (response.school != null) {
                        $('#user_about_badges').html('<span class="badge-group mb-10" role="group" aria-label="User statuses"><span class="badge badge-primary">' + response.status + '</span><span class="badge badge-success">Curator</span><span class="badge badge-secondary">Education account</span></span>');
                    } else {
                        $('#user_about_badges').html('<span class="badge-group mb-10" role="group" aria-label="User statuses"><span class="badge badge-primary">' + response.status + '</span><span class="badge badge-success">Curator</span></span>');
                    }
                } else {
                    $('#user_about_badges').html('<span class="badge-group mb-10" role="group" aria-label="User statuses"><span class="badge badge-primary">' + response.status + '</span></span>');
                }
                $('#user_about_picture').html('<img src="' + response.icon + '" class="h-150 w-150 h-lg-100 w-lg-100" onerror="$(\'#user_about_picture\').html(\'<b>Sorry</b>, we were unable to load this profile picture!\')">');
                $('#user_about_username').html('<b data-toggle="tooltip" data-title="ID: ' + response.id + ' ScratchDB_ID: ' + response.scratchdb_id + '">' + response.username + '</b>');
                $('#user_about_scratch').prop('disabled', false);
                $('#user_about_scratchstats').prop('disabled', false);
                $('#user_about_ocular').prop('disabled', false);
                $(document).on('click', '#user_about_scratch', function () {
                    window.open('https://scratch.mit.edu/users/' + response.username, '_blank');
                })
                $(document).on('click', '#user_about_scratchstats', function () {
                    window.open('https://scratchstats.com/' + response.username, '_blank');
                })
                $(document).on('click', '#user_about_ocular', function () {
                    window.open('https://ocular.jeffalo.net/user/' + response.username, '_blank');
                })
                activities = '';
                activities += '<ul>';
                console.log(response.activity);
                response.activity.forEach(activity => {
                    switch (activity.action) {
                        case 'favorite':
                            activities += '<li>' + response.username + ' <b>favorited <a href="https://scratch.mit.edu/projects/' + activity.target.project_id + '">' + activity.target.project_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'love':
                            activities += '<li>' + response.username + ' <b>loved <a href="https://scratch.mit.edu/projects/' + activity.target.project_id + '">' + activity.target.project_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'love':
                            activities += '<li>' + response.username + ' <b>loved <a href="https://scratch.mit.edu/projects/' + activity.target.project_id + '">' + activity.target.project_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'share':
                            activities += '<li>' + response.username + ' <b>shared the project <a href="https://scratch.mit.edu/projects/' + activity.target.project_id + '">' + activity.target.project_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'follow':
                            activities += '<li>' + response.username + ' <b>followed the user <a href="https://scratch.mit.edu/users/' + activity.target.followed_user + '">' + activity.target.followed_user + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'follow_studio':
                            activities += '<li>' + response.username + ' <b>followed the studio <a href="https://scratch.mit.edu/studios/' + activity.target.studio_id + '">' + activity.target.studio_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'curate':
                            activities += '<li>' + response.username + ' <b>became a curator of the studio <a href="https://scratch.mit.edu/studios/' + activity.target.studio_id + '">' + activity.target.studio_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'studio_add':
                            activities += '<li>' + response.username + ' <b>added the project <a href="https://scratch.mit.edu/projects/' + activity.target.project_id + '">' + activity.target.project_name + '</a></b> to the studio <b><a href="https://scratch.mit.edu/studios/' + activity.target.studio_id + '">' + activity.target.studio_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'remix':
                            activities += '<li>' + response.username + ' <b>remixed the project <a href="https://scratch.mit.edu/projects/' + activity.target.original_project_id + '">' + activity.target.original_project_name + '</a></b> as <b><a href="https://scratch.mit.edu/projects/' + activity.target.remixed_project_id + '">' + activity.target.remixed_project_name + '</a></b> ' + activity.time + '</li>';
                            break;
                        case 'join':
                            activities += '<li>' + response.username + ' <b>joined Scratch 🎉</b> ' + activity.time + '</li>';
                            break;


                    }
                });
                activities += '</ul>';
                $('#user_info').html('<p><b>Status:</b> ' + response.bio.replace(/\n/g, "<br />") + '</p><hr><p><b>Work:</b> ' + response.work.replace(/\n/g, "<br />") + '</p><hr><p><b>Activity:</b> ' + activities + '</p>');
                join_date = new Date(response.joined).toString();
                $('#user_join').html('<b>Joined: </b>' + join_date + '<br><b>Country: </b>' + response.country);

                // Extract browser and OS information from user agent
                if (response.agent) {
                    parser = new UAParser();
                    parser.setUA(response.agent);
                    agent = parser.getResult();

                    $('#user_os').html('<b><span data-toggle="tooltip" data-title="Operating System">OS</span>: </b><span data-toggle="tooltip" data-title="Version: ' + agent.os.version + '">' + agent.os.name + '</span><br><b>Browser: </b><span data-toggle="tooltip" data-title="Version: ' + agent.browser.version + '">' + agent.browser.name + '</span>');
                } else {
                    $('#user_os').html('<span class="text-danger"><b>Sorry</b>, we were unable to determine the operating system and browser of ' + response.username + '.</span>');
                }

                function adjustRanks() {
                    global_ranks = $('#user_ranks_global').is(':checked');
                    if (global_ranks) {
                        $('#user_ranks_followers').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.followers + '</b></div><div class="font-size-12 align-self-center">followers</div></div>');
                        $('#user_ranks_following').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.following + '</b></div><div class="font-size-12 align-self-center">following</div></div>');
                        $('#user_ranks_loves').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.loves + '</b></div><div class="font-size-12 align-self-center">loves</div></div>');
                        $('#user_ranks_favorites').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.favorites + '</b></div><div class="font-size-12 align-self-center">favorites</div></div>');
                        $('#user_ranks_views').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.views + '</b></div><div class="font-size-12 align-self-center">views</div></div>');
                        $('#user_ranks_comments').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.comments + '</b></div><div class="font-size-12 align-self-center">comments</div></div>');
                    } else {
                        $('#user_ranks_followers').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.followers + '</b></div><div class="font-size-12 align-self-center">followers</div></div>');
                        $('#user_ranks_following').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.following + '</b></div><div class="font-size-12 align-self-center">following</div></div>');
                        $('#user_ranks_loves').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.loves + '</b></div><div class="font-size-12 align-self-center">loves</div></div>');
                        $('#user_ranks_favorites').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.favorites + '</b></div><div class="font-size-12 align-self-center">favorites</div></div>');
                        $('#user_ranks_views').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.views + '</b></div><div class="font-size-12 align-self-center">views</div></div>');
                        $('#user_ranks_comments').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center">#<b>' + response.ranks.country.comments + '</b></div><div class="font-size-12 align-self-center">comments</div></div>');
                    }
                }

                adjustRanks();
                $(document).on('click', '#user_ranks_global', function () {
                    adjustRanks();
                })

                $('#user_stats_followers').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.followers + '</b></div><div class="font-size-12 align-self-center">followers</div></div>');
                $('#user_stats_following').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.following + '</b></div><div class="font-size-12 align-self-center">following</div></div>');
                $('#user_stats_loves').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.loves + '</b></div><div class="font-size-12 align-self-center">loves on all projects</div></div>');
                $('#user_stats_favorites').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.favorites + '</b></div><div class="font-size-12 align-self-center">favorites on all projects</div></div>');
                $('#user_stats_views').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.views + '</b></div><div class="font-size-12 align-self-center">views on all projects</div></div>');
                $('#user_stats_comments').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.comments + '</b></div><div class="font-size-12 align-self-center">comments on all projects</div></div>');
                $('#user_stats_projects').html('<div class="d-flex flex-column"><div class="font-size-20 align-self-center"><b>' + response.statistics.projects + '</b></div><div class="font-size-12 align-self-center">projects</div></div>');
            }
        })
    }



    // Define regular expression to search for the username segment of the URL
    regex = /\/search\/[a-z0-9]+\/([a-zA-Z0-9_-]+)/;
    // Get the current pathname
    pathname = window.location.pathname;
    // Execute the regular expression
    match = pathname.match(regex);
    if (match != null) {
        match = match[1];
    }

    // Fetch users stats
    getUser(match);
})