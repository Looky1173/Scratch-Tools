<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

$tips = [
    'normal' => [
        'You can delete your account in the dashboard.',
        'Scratch Tools is open-source, check it out on <a href="https://github.com/Looky1173/Scratch-Tools" target="_blank">GitHub</a>!',
        'Have an awesome idea? Use the <i>Contact us</i> form to propose it or post an issue on <a href="https://github.com/Looky1173/Scratch-Tools" target="_blank">GitHub</a>!',
        'It is possible to change the authentication method of your account under the <i>My account</i> tab.',
        'Collaborations allow multiple users to work on the same project real-time, and to organise them better.',
        'You will receive a warning when you are about to leave Scratch Tools and go to an external site.',
        'Have a shop on Scratch? Register it in the <i>Shops</i> tab!'
    ],
    'moderator' => [
        'You can view all users in the <i>Users</i> tab located in the sidebar.',
        'You can change the featured project in the <i>Featured</i> tab.'
    ],
    'admin' => [
        'To sign out all users, go to the <i>Users</i> tab!',
        'Don\'t forget to put the site in maintanence mode when pushing changes to the site!',
        'The <i>Role Based Access-Control (RBAC)</i> tab is used to create roles and assign permissions to them.'
    ]
];

$userRole = $perm->getRoleByUsername($_SESSION['username']);
$userRole = $perm->getRoleNameById($userRole);

if ($userRole == 'user') {
    $types = ['normal'];
} else if ($userRole == 'moderator') {
    $types = ['normal', 'moderator'];
} else if ($userRole == 'administrator') {
    $types = ['normal', 'moderator', 'admin'];
}

if (!empty($_SESSION['last_tip'])) {
    do {
        $last_tip = [];
        $type = array_rand($types);
        $type = $types[$type];
        $last_tip[] = $type;
        $tip = array_rand($tips[$type]);
        $last_tip[] = $tip;
    } while ($tip == $tips[$_SESSION['last_tip'][0]][$_SESSION['last_tip'][1]]);
} else {
    $last_tip = [];
    $type = array_rand($types);
    $type = $types[$type];
    $last_tip[] = $type;
    $tip = array_rand($tips[$type]);
    $last_tip[] = $tip;
}


$_SESSION['last_tip'] = $last_tip;

$response = ['tip' => $tips[$type][$tip]];

echo json_encode($response);