<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);
$user = new HandleUsers($db);

$request = $_POST['request'];
$response = [];

$username = $_SESSION['username'];

if ($request == 'getAuthType') {
    $auth_type = $user->checkLoginType($username);
    if ($auth_type !== 'not found') {
        $response = ['status' => 'success', 'auth_type' => $auth_type];
    } else {
        $response = ['status' => 'fail', 'error_type' => 'information_unavaible', 'reason' => 'user_not_found'];
    }
} else if ($request == 'changeAuthMethodToPassword') {
    $ok = true;

    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!empty($password) && empty($password_repeat) || empty($password) && !empty($password_repeat) || empty($password) && empty($password_repeat)) {
        $response = ['status' => 'fail', 'error_type' => 'general', 'reason' => 'incomplete_form'];
        $ok = false;
    } else if ($password != $password_repeat) {
        $response = ['status' => 'fail', 'error_type' => 'password', 'reason' => 'passwords_do_not_match'];
        $ok = false;
    } else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $response = ['status' => 'fail', 'error_type' => 'password', 'reason' => 'invalid_passwords'];
        $ok = false;
    }

    if ($ok == true) {
        $id = $user->getUserInformation($username, '');
        $id = $id['id'];
        $user->updateUser('', $password, '', '', '', '', $id);
        $response = ['status' => 'success'];
    }
} else if ($request == 'changeAuthMethodToScratchLogin') {
    $id = $user->getUserInformation($username, '');
        $id = $id['id'];
        $user->changeAuthMethodToScratchLogin('', $id);
        $response = ['status' => 'success'];
}

echo json_encode($response);
