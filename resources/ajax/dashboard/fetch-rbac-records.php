<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

// String to store retrieved data
$rbac_data = "";

$response = [];

$username = $_SESSION['username'];

$temp_perm_id = [$perm->getPermissionByDesc('rbac_view_records')];
if ($perm->validatePermission($username, $temp_perm_id) == true) {
    $sql = "SELECT * FROM roles";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    // Fetch column as an array
    $roles = $stmt->fetchAll();
    foreach ($roles as $role) {
        $rbac_data .= '<tr>';
        $rbac_data .= '<th>' . $role['role_id'] . '</th>';
        $rbac_data .= '<td>' . $role['role_name'] . '</td>';
        $perms = $perm->getPermissionsByRole($role['role_id']);
        $rbac_data .= '<td>';
        $rbac_data .= '<code class="code">';
        foreach ($perms as $permission) {
            $rbac_data .= $perm->getPermissionById($permission);
            if ($permission !== end($perms)) {
                $rbac_data .= ', ';
            }
        }
        $rbac_data .= '</code>';
        $rbac_data .= '</td>';
        $rbac_data .= '<td><div class="d-flex"><a data-id="' . $role['role_id'] . '" class="btn btn-primary mr-10 rbac-edit">Edit</a><a data-id="' . $role['role_id'] . '" class="btn btn-danger rbac-delete">Delete</a></div></td>';
        $rbac_data .= '</tr>';
    }
    $response = ['status' => 'success', 'rbac_data' => $rbac_data];
} else {
    $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_view_rbac_data'];
}

echo json_encode($response);
