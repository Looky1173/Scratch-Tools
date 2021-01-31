<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);
$u = new HandleUsers($db);

$request = $_POST['request'];

$username = $_SESSION['username'];

if ($request == 'load_data') {
    $temp_perm_id = [$perm->getPermissionByDesc('access_users')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {

        $page = $_POST['page'];
        $limit = $_POST['limit'];
        $filters = $_POST['filters'];
        $order = $_POST['order']['order'];
        $order_by = $_POST['order']['order-by'];
        $table = '';
        $tmp_results_role = [];
        $tmp_results_login_method = [];

        if ($page > 1) {
            $start = ($page - 1) * $limit;
        } else {
            $start = 0;
        }

        $sql = "SELECT * FROM accounts";
        $sql .= " WHERE id LIKE '%" . $filters['id'] . "%'";
        $sql .= " AND username LIKE '%" . $filters['username'] . "%'";
        if (!empty($filters['created']['start']) && !empty($filters['created']['end'])) {
            $sql .= " AND (created BETWEEN '" . $filters['created']['start'] . "' AND '" . $filters['created']['end'] . "')";
        }
        if (!empty($filters['modified']['start']) && !empty($filters['modified']['end'])) {
            $sql .= " AND (modified BETWEEN '" . $filters['modified']['start'] . "' AND '" . $filters['modified']['end'] . "')";
        }
        switch ($order_by) {
            case 'id':
                $table = 'id';
                break;
            case 'username':
                $table = 'username';
                break;
            case 'created':
                $table = 'created';
                break;
            case 'modified':
                $table = 'modified';
                break;
            default:
                $table = '';
                break;
        }
        if (!empty($table)) {
            if ($order == 'asc') {
                $sql .= " ORDER BY " . $table . " ASC";
            } elseif ($order == 'desc') {
                $sql .= " ORDER BY " . $table . " DESC";
            }
        }
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Count returned results
        $total_data = $stmt->rowCount();
        $tmp = $stmt->fetchAll();

        if (!empty($filters['role'])) {
            foreach ($tmp as $user) {
                $role = $perm->getRoleByUsername($user['username']);
                $role = $perm->getRoleNameById($role);
                if (strpos($role, $filters['role']) !== false) {
                    $tmp_results_role[] = $user;
                }
            }
        } else {
            $tmp_results_role = $tmp;
        }

        if ($filters['login_method'] != 'all') {
            $login_method = '';
            switch ($filters['login_method']) {
                case 'scratch':
                    $login_method = 'scratch-login';
                    break;
                case 'password':
                    $login_method = 'pwd-login';
                    break;
            }
            foreach ($tmp_results_role as $user) {
                $login = $u->checkLoginType($user['username']);
                if ($login_method == $login) {
                    $tmp_results_login_method[] = $user;
                }
            }
        } else {
            if (!empty($filters['role'])) {
                $tmp_results_login_method = $tmp_results_role;
            } else {
                $tmp_results_login_method = $tmp;
            }
        }

        $total_data = count($tmp_results_login_method);

        if ($total_data == 0) {
            $response = ['status' => 'fail', 'error_type' => 'data', 'reason' => 'no_data_returned'];
            echo json_encode($response);
            return;
        }

        $sql .= " LIMIT " . $start . ", " . $limit;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Fetch column as an array
        $data = $stmt->fetchAll();
        $total_shown = $stmt->rowCount();

        $tmp_results_role = [];
        $tmp_results_login_method = [];
        if (!empty($filters['role'])) {
            foreach ($data as $user) {
                $role = $perm->getRoleByUsername($user['username']);
                $role = $perm->getRoleNameById($role);
                if (strpos($role, $filters['role']) !== false) {
                    $tmp_results_role[] = $user;
                }
            }
        } else {
            $tmp_results_role = $data;
        }

        if ($filters['login_method'] != 'all') {
            $login_method = '';
            switch ($filters['login_method']) {
                case 'scratch':
                    $login_method = 'scratch-login';
                    break;
                case 'password':
                    $login_method = 'pwd-login';
                    break;
            }
            foreach ($tmp_results_role as $user) {
                $login = $u->checkLoginType($user['username']);
                if ($login_method == $login) {
                    $tmp_results_login_method[] = $user;
                }
            }
        } else {
            if (!empty($filters['role'])) {
                $tmp_results_login_method = $tmp_results_role;
            } else {
                $tmp_results_login_method = $data;
            }
        }

        $data = $tmp_results_login_method;
        $users = '';

        foreach ($data as $user) {
            $users .= '<tr data-id="' . $user['id'] . '">';
            $users .= '<th>' . $user['id'] . '</th>';
            $users .= '<td style="text-align:center;"><div class="profile-picture fake-content w-50 h-50"><script>loadImage("' . $user['username'] . '", "' . $user['id'] . '")</script></div></td>';
            $users .= '<td class="username" data-username="' . $user['username'] . '">' . $user['username'] . '</td>';
            $role = $perm->getRoleByUsername($user['username']);
            $role = $perm->getRoleNameById($role);
            $users .= '<td>' . $role . '</td>';
            $login = $u->checkLoginType($user['username']);
            if ($login == 'scratch-login') {
                $users .= '<td>Scratch</td>';
            } elseif ($login == 'pwd-login') {
                $users .= '<td>Password</td>';
            } else {
                $users .= '<td><code>error</code></td>';
            }
            $users .= '<code class="code">';
            $users .= '<td>' . $user['created'] . '</td>';
            $users .= '<td>' . $user['modified'] . '</td>';
            $users .= '<td>...</td>';
            $users .= '<td><div class="d-flex"><a class="btn btn-primary mr-10 users-edit"><i class="fas fa-edit"></i></a><a class="btn btn-danger users-delete"><i class="fas fa-trash"></i></a></div></td>';
            $users .= '</tr>';
        }


        $total_paginations = ceil($total_data / $limit);
        $previous_pagination = '';
        $next_pagination = '';
        $actual_pagination = '';
        if ($total_paginations > 4) {
            if ($page < 5) {
                for ($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_paginations;
            } else {
                $end_limit = $total_paginations - 5;
                if ($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $end_limit; $count <= $total_paginations; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_paginations;
                }
            }
        } else {
            for ($count = 1; $count <= $total_paginations; $count++) {
                $page_array[] = $count;
            }
        }

        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $actual_pagination .= '
                <li class="page-item active" aria-current="page">
                    <a href="#" class="page-link" tabindex="-1">' . $page_array[$count] . '</a>
                </li>';

                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_pagination = '
                    <li class="page-item">
                        <a href="#" class="page-link" data-page_number="' . $previous_id . '">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>';
                } else {
                    $previous_pagination = '
                    <li class="page-item disabled">
                        <a href="#" class="page-link">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>';
                }

                $next_id = $page_array[$count] + 1;
                if ($next_id > $total_paginations) {
                    $next_pagination = '
                    <li class="page-item disabled">
                        <a href="#" class="page-link">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>';
                } else {
                    $next_pagination = '
                    <li class="page-item">
                        <a href="#" class="page-link" data-page_number="' . $next_id . '">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $actual_pagination .= '<li class="page-item ellipsis"></li>';
                } else {
                    $actual_pagination .= '
                    <li class="page-item">
                        <a href="#" class="page-link" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</a>
                    </li>';
                }
            }
        }

        $pagination = $previous_pagination . $actual_pagination . $next_pagination;
        $response = ['status' => 'success', 'start' => $start, 'data' => $data, 'pagination' => $pagination, 'filters' => $filters, 'users' => $users, 'tmp_login_method' => $tmp_results_login_method, 'tmp_role' => $tmp_results_role, 'total' => $total_data, 'total_shown' => $total_shown];
        /*
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
    */
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_access_users'];
    }
} elseif ($request == 'init_edit_user') {
    $select = '';
    $temp_perm_id = [$perm->getPermissionByDesc('edit_users')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $user_role = $perm->getRoleByUsername($username);
        $user_role = $perm->getRoleNameById($user_role);

        $sql = "SELECT * FROM roles";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $roles = $stmt->fetchAll();

        $select .= '<select class="form-control" id="edit-user-role">';
        $select .= '<option value="' . $user_role . '" disabled="disabled" selected="selected">' . $user_role . ' (current)</option>';
        foreach ($roles as $role) {
            if ($role['role_name'] !== $user_role) {
                $select .= '<option value="' . $role['role_name'] . '">' . $role['role_name'] . '</option>';
            }
        }
        $select .= '</select>';

        $response = ['status' => 'success', 'select' => $select];
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_edit_users'];
    }
} elseif ($request == 'edit_user') {
    $temp_perm_id = [$perm->getPermissionByDesc('edit_users')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        $id = $_POST['id'];
        $role = $_POST['role'];

        $role = $perm->getRoleIdByName($role);
        if ($u->updateUser('', '', $role, '', '', '', $id)) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'fail', 'error_type' => 'unknown', 'reason' => 'request_failed_for_unknown_reason'];
        }
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_edit_users'];
    }
} elseif ($request == 'delete_data') {
    $temp_perm_id = [$perm->getPermissionByDesc('delete_users')];
    if ($perm->validatePermission($username, $temp_perm_id) == true) {
        if ($u->deleteUser($_POST['id'], false) == true) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'fail', 'error_type' => 'unknown', 'reason' => 'request_failed_for_unknown_reason'];
        }
    } else {
        $response = ['status' => 'fail', 'error_type' => 'auth', 'reason' => 'not_authorised_to_delete_users'];
    }
}
echo json_encode($response);
