<?php

require $_SERVER["DOCUMENT_ROOT"] . '/resources/lib/simple_html_dom.php';

// Declare an array for holding the response to the API call
$return = ['success' => false];

if (!isset($_GET['type'])) {
    // Undetermined request
    echo json_encode($return);
} else {
    if (!empty($_GET['type'])) {
        $type = $_GET['type'];
        if (empty($_GET['data'])) {
            // Fetch general & average statistics as no username/project/studio/topic was specified
            switch ($type) {
                case 'users':
                    break;
                case 'studios':
                    break;
                case 'projects':
                    break;
                case 'forums':
                    break;
                case 'posts':
                    break;
            }
            echo "Showing general stats:";
        } else {
            $data = $_GET['data'];
            switch ($type) {
                case 'users':
                    $scratchdb_api = file_get_contents('https://scratchdb.lefty.one/v3/user/info/' . $data);
                    $scratchdb_api_projects = file_get_contents('https://scratchdb.lefty.one/v2/project/info/user/' . $data);
                    $scratch_api = file_get_contents('https://api.scratch.mit.edu/users/' . $data);
                    $curator = file_get_contents('https://api.scratch.mit.edu/proxy/featured');
                    $scratchdb_api = json_decode($scratchdb_api, true);
                    $scratchdb_api_projects = json_decode($scratchdb_api_projects, true);
                    $scratch_api = json_decode($scratch_api, true);
                    $curator = json_decode($curator, true);
                    $curator = $curator['curator_top_projects'][0]['curator_name'];
                    if ($data == $curator) {
                        $curator = true;
                    } else {
                        $curator = false;
                    }

                    // Fetch the recent activities of the user
                    $activity_html = file_get_html('https://scratch.mit.edu/messages/ajax/user-activity/?user=' . $data . '&max=1000000');
                    // Remove unnecessary newlines
                    //$activity_html = preg_replace("/\r|\n/", "", $activity_html);

                    $activities = [];
                    $regex = '/<[^>]*>[^<]*<[^>]*>/';
                    foreach ($activity_html->find('ul.activity-stream li') as $activity) {

                        $action = preg_replace($regex, '', $activity);

                        $target = [];

                        $project_regex = '/\/projects\/([0-9]+)\//';
                        $username_regex = '/\/users\/([a-zA-Z0-9_-]+)\//';
                        $studio_regex = '/\/studios\/([0-9]+)\//';

                        if (strpos($action, 'favorited') !== false) {
                            $action = 'favorite';
                            $details = $activity->find('div a', 0);
                            $project_id = preg_match($project_regex, $details->href, $match);
                            $project_id = $match[1];
                            $target = ['project_id' => $project_id, 'project_name' => $details->innertext];
                        } elseif (strpos($action, 'loved') !== false) {
                            $action = 'love';
                            $details = $activity->find('div a', 0);
                            $project_id = preg_match($project_regex, $details->href, $match);
                            $project_id = $match[1];
                            $target = ['project_id' => $project_id, 'project_name' => $details->innertext];
                        } elseif (strpos($action, 'shared the project') !== false) {
                            $action = 'share';
                            $details = $activity->find('div a', 0);
                            $project_id = preg_match($project_regex, $details->href, $match);
                            $project_id = $match[1];
                            $target = ['project_id' => $project_id, 'project_name' => $details->innertext];
                        } elseif (strpos($action, 'is now following') !== false && strpos($action, 'studio') == false) {
                            $action = 'follow';
                            $details = $activity->find('div a', 0);
                            $followed_user = preg_match($username_regex, $details->href, $match);
                            $followed_user = $match[1];
                            $target = ['followed_user' => $followed_user];
                        } elseif (strpos($action, 'is now following the studio') !== false) {
                            $action = 'follow_studio';
                            $details = $activity->find('div a', 0);
                            $studio_id = preg_match($studio_regex, $details->href, $match);
                            $studio_id = $match[1];
                            $target = ['studio_id' => $studio_id, 'studio_name' => $details->innertext];
                        } elseif (strpos($action, 'became a curator of') !== false) {
                            $action = 'curate';
                            $details = $activity->find('div a', 0);
                            $studio_id = preg_match($studio_regex, $details->href, $match);
                            $studio_id = $match[1];
                            $target = ['studio_id' => $studio_id, 'studio_name' => $details->innertext];
                        } elseif (strpos($action, 'was promoted to manager of') !== false) {
                            $action = 'promote';
                            $details = $activity->find('div a', 0);
                            $studio_id = preg_match($studio_regex, $details->href, $match);
                            $studio_id = $match[1];
                            $target = ['studio_id' => $studio_id, 'studio_name' => $details->innertext];
                        } elseif (strpos($action, 'added') !== false) {
                            $action = 'studio_add';
                            // Loop through each <a> tag and find the second and third ones. The first one is redundant as it is the link to the user's profile.
                            $i = 1;
                            foreach ($activity->find('div a') as $link) {
                                switch ($i) {
                                    case 2:
                                        $project_id = preg_match($project_regex, $link->href, $match);
                                        $project_id = $match[1];
                                        $project_name = $link->innertext;
                                        break;
                                    case 3:
                                        $studio_id = preg_match($studio_regex, $link->href, $match);
                                        $studio_id = $match[1];
                                        $studio_name = $link->innertext;
                                        break;
                                }

                                $i++;
                            }
                            $target = ['project_id' => $project_id, 'project_name' => $project_name, 'studio_id' => $studio_id, 'studio_name' => $studio_name];
                        } elseif (strpos($action, 'remixed') !== false) {
                            $action = 'remix';
                            // Loop through each <a> tag and find the first and second ones.
                            $i = 1;
                            foreach ($activity->find('div a') as $link) {
                                switch ($i) {
                                    case 1:
                                        $original_project_id = preg_match($project_regex, $link->href, $match);
                                        $original_project_id = $match[1];
                                        $original_project_name = $link->innertext;
                                        break;
                                    case 2:
                                        $remixed_project_id = preg_match($project_regex, $link->href, $match);
                                        $remixed_project_id = $match[1];
                                        $remixed_project_name = $link->innertext;
                                        break;
                                }

                                $i++;
                            }
                            $target = ['original_project_id' => $original_project_id, 'original_project_name' => $original_project_name, 'remixed_project_id' => $remixed_project_id, 'remixed_project_name' => $remixed_project_name];
                        } elseif (strpos($action, 'joined') !== false) {
                            $action = 'join';
                        } else {
                            $action = '';
                        }

                        // Find item link element
                        //$user = $activity->find('div span.actor', 0);
                        $time = str_replace('&nbsp;', ' ', htmlentities($activity->find('div span.time', 0)->innertext));
                        /*
                        // get title attribute
                        $videoTitle = $videoDetails->title;

                        // get href attribute
                        $videoUrl = 'https://youtube.com' . $videoDetails->href;
*/
                        // push to a list of videos
                        $activities[] = [
                            'action' => $action,
                            'target' => $target,
                            'time' => $time,
                            //'time' => $time
                        ];
                    }

                    // Retrieve user agent
                    if (isset($scratchdb_api_projects['projects'][count($scratchdb_api_projects['projects']) - 1]['info']['scratch_id']) || isset($scratchdb_api_projects['projects'][count($scratchdb_api_projects['projects']) - 1]['info']['scratch_id'])) {
                        $project_info_1 = file_get_contents('https://cdn.projects.scratch.mit.edu/' . $scratchdb_api_projects['projects'][count($scratchdb_api_projects['projects']) - 1]['info']['scratch_id']);
                        $project_info_1 = json_decode($project_info_1, true);
                        if (isset($project_info_1['meta']['agent'])) {
                            $user_agent = $project_info_1['meta']['agent'];
                        } else {
                            $project_info_2 = file_get_contents('https://cdn.projects.scratch.mit.edu/' . $scratchdb_api_projects['projects'][count($scratchdb_api_projects['projects']) - 2]['info']['scratch_id']);
                            $project_info_2 = json_decode($project_info_2, true);
                            if (isset($project_info_2['meta']['agent'])) {
                                $user_agent = $project_info_2['meta']['agent'];
                            } else {
                                if (isset($project_info_1['info']['userAgent'])) {
                                    $user_agent = $project_info_1['info']['userAgent'];
                                } else {
                                    if (isset($project_info_2['info']['userAgent'])) {
                                        $user_agent = $project_info_2['info']['userAgent'];
                                    } else {
                                        $user_agent = null;
                                    }
                                }
                            }
                        }
                    } else {
                        $user_agent = null;
                    }

                    $projects = count($scratchdb_api_projects['projects']) - 1;

                    $return = ['username' => $scratchdb_api['username'], 'id' => $scratchdb_api['id'], 'scratchdb_id' => $scratchdb_api['sys_id'], 'status' => $scratchdb_api['status'], 'scratchteam' => $scratch_api['scratchteam'], 'curator' => $curator, 'school' => $scratchdb_api['school'], 'joined' => $scratch_api['history']['joined'], 'country' => $scratchdb_api['country'], 'bio' => htmlspecialchars($scratch_api['profile']['bio']), 'work' => htmlspecialchars($scratch_api['profile']['status']), 'activity' => $activities, 'icon' => $scratch_api['profile']['images']['90x90'], 'agent' => $user_agent, 'statistics' => ['followers' => $scratchdb_api['statistics']['followers'], 'following' => $scratchdb_api['statistics']['following'], 'loves' => $scratchdb_api['statistics']['loves'], 'favorites' => $scratchdb_api['statistics']['favorites'], 'views' => $scratchdb_api['statistics']['views'], 'comments' => $scratchdb_api['statistics']['comments'], 'projects' => $projects], 'ranks' => ['followers' => $scratchdb_api['statistics']['ranks']['followers'], 'following' => $scratchdb_api['statistics']['ranks']['following'], 'loves' => $scratchdb_api['statistics']['ranks']['loves'], 'favorites' => $scratchdb_api['statistics']['ranks']['favorites'], 'views' => $scratchdb_api['statistics']['ranks']['views'], 'comments' => $scratchdb_api['statistics']['ranks']['comments'], 'country' => ['followers' => $scratchdb_api['statistics']['ranks']['country']['followers'], 'following' => $scratchdb_api['statistics']['ranks']['country']['following'], 'loves' => $scratchdb_api['statistics']['ranks']['country']['loves'], 'favorites' => $scratchdb_api['statistics']['ranks']['country']['favorites'], 'views' => $scratchdb_api['statistics']['ranks']['country']['views'], 'comments' => $scratchdb_api['statistics']['ranks']['country']['comments']]]];
                    break;
                case 'studios':
                    break;
                case 'projects':
                    break;
                case 'forums':
                    break;
                case 'posts':
                    break;
            }
            echo json_encode($return, JSON_UNESCAPED_SLASHES);
        }
    } else {
        // Empty type
        echo json_encode($return);
    }
}
