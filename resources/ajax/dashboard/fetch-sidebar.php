<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

$userRole = $perm->getRoleByUsername($_SESSION['username']);

$perm_desc = ['access_account_settings', 'access_account_advanced', 'access_collaborations', 'access_shops', 'access_maintenance', 'access_users', 'access_logs', 'access_rbac', 'access_featured', 'access_announcements'];

$response = [];

foreach ($perm_desc as $desc) {
    $perm_id = $perm->getPermissionByDesc($desc);
    if ($perm->validatePermission($_SESSION['username'], [$perm_id]) == true) {
        $response[$desc] = true;
    } else {
        $response[$desc] = false;
    }
}
echo json_encode($response);
