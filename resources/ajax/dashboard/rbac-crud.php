<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

$request = $_POST['request'];

$username = $_SESSION['username'];

if ($request == 'updateData') {
    $temp_perm_id = [$perm->getPermissionByDesc('rbac_edit_records')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        $role_id = $_POST['id'];
        $role_name = $_POST['roleName'];
        $role_permissions = $_POST['permissions'];

        $sql = "UPDATE roles SET role_name=? WHERE role_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$role_name, $role_id]);

        $sql = "DELETE FROM roles_permissions WHERE role_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$role_id]);

        foreach ($role_permissions as $perm_desc) {
            $perm_id = $perm->getPermissionByDesc($perm_desc);
            $sql = "INSERT INTO roles_permissions(role_id, permission_id) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$role_id, $perm_id]);
        }

        $response = ['status' => 'success'];
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_edit_rbac_data'];
    }
} else if ($request == 'addData') {
    $temp_perm_id = [$perm->getPermissionByDesc('rbac_add_records')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        $role_name = $_POST['roleName'];
        $role_permissions = $_POST['permissions'];

        $sql = "INSERT INTO roles(role_name) VALUES (?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$role_name]);
        $role_id = $db->lastInsertId('role_id');

        foreach ($role_permissions as $perm_desc) {
            $perm_id = $perm->getPermissionByDesc($perm_desc);
            $sql = "INSERT INTO roles_permissions(role_id, permission_id) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$role_id, $perm_id]);
        }

        $response = ['status' => 'success'];
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_add_rbac_data'];
    }
} else if ($request == 'deleteData') {
    $temp_perm_id = [$perm->getPermissionByDesc('rbac_delete_records')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        $role_id = $_POST['id'];

        $sql = "SELECT * FROM accounts WHERE role=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$role_id]);
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            $response = ['status' => 'fail', 'reason' => 'users_exist_with_role'];
        } else {
            $sql = "DELETE FROM roles_permissions WHERE role_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$role_id]);

            $sql = "DELETE FROM roles WHERE role_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$role_id]);

            $response = ['status' => 'success'];
        }
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_delete_rbac_data'];
    }
}

echo json_encode($response);
