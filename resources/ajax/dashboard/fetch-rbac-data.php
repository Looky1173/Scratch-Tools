<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

$roleId = $_POST['id'];
$request = $_POST['request'];

$username = $_SESSION['username'];

$temp_perm_id = [$perm->getPermissionByDesc('rbac_view_records')];
if ($perm->validatePermission($username, $temp_perm_id) == true) {

    if ($request == 'getData') {
        // Get records to prefill form
        $roleName = $perm->getRoleNameById($roleId);
        $permissions = $perm->getPermissionsByRole($roleId);

        $string = "";

        $sql = "SELECT permission_desc FROM permissions";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Fetch column as an array
        $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $permission_ids = $perm->getPermissionsByRole($roleId);
        foreach ($permissions as $perm_desc) {
            $permission_id = $perm->getPermissionByDesc($perm_desc);
            if (in_array($permission_id, $permission_ids) == true) {
                $string .= ' <option selected="selected" value="' . $perm_desc . '">' . $perm_desc . '</option>';
            } else {
                $string .= ' <option value="' . $perm_desc . '">' . $perm_desc . '</option>';
            }
        }

        $response = ['status' => 'success', 'roleName' => $roleName, 'string' => $string];
    }
} else {
    $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_view_rbac_data'];
}
echo json_encode($response);
