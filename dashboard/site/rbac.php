<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

?>

<!DOCTYPE html>
<html>

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <!-- Title -->
    <title>RBAC | Scratch Tools Dashboard</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/modals.php'; ?>
    <!-- Page wrapper start -->
    <div id="page-wrapper" class="page-wrapper with-navbar with-sidebar with-transitions with-custom-webkit-scrollbars with-custom-css-scrollbars" data-sidebar-type="full-height">

        <!-- Sticky alerts -->
        <div class="sticky-alerts"></div>

        <!-- Navbar start -->
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/navbar.php'; ?>
        <!-- Navbar end -->

        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>

        <!-- Sidebar start -->
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/sidebar.php'; ?>
        <!-- Sidebar end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row row-eq-spacing-lg">
                    <div class="col-lg-9">
                        <div class="content">
                            <h1 class="content-title">
                                Role Based Access-Control (RBAC) Manager
                            </h1>
                            <p>This panel allows you to create, view, update, and delete roles and assign permissions to them.</p>
                        </div>
                        <div class="card">
                            <h2 class="card-title">
                                Manage roles
                            </h2>
                            <br>
                            <button id="add-role" class="btn btn-primary">Add role</button>
                            <div id="rbac-form">
                                <form id="add-role-form" class="mw-full d-none">
                                    <!-- Input -->
                                    <div class="form-group">
                                        <label for="full-name" class="required">Role name</label>
                                        <input type="text" class="form-control" id="add-role-roleName" placeholder="A descriptive name of new role" required="required">
                                    </div>

                                    <!-- Select permissions -->
                                    <div class="form-group">
                                        <label for="languages" class="required">Permissions</label>
                                        <select class="form-control" id="add-role-permissions" multiple="multiple" required="required" size="5">
                                            <?php

                                            $sql = "SELECT permission_desc FROM permissions";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute();
                                            // Fetch column as an array
                                            $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                            foreach ($permissions as $perm_desc) {
                                                echo ' <option value="' . $perm_desc . '">' . $perm_desc . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <input id="cancel-add-role" class="btn" type="button" value="Cancel">
                                    <!-- Submit button -->
                                    <input id="submit-add-role" class="btn btn-primary" type="submit" value="Create new role">
                                </form>
                                <br>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>Permissions</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="rbac-data">
                                    <tr>
                                        <th>
                                            <div class="fake-content">
                                        </th>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="fake-content">
                                        </th>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="fake-content">
                                        </th>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="fake-content">
                                        </th>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                        <td>
                                            <div class="fake-content">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="content">
                            <h2 class="content-title font-size-20">
                                On this page
                            </h2>
                            <div class="fake-content white"></div>
                            <div class="fake-content"></div>
                            <div class="fake-content"></div>
                            <div class="fake-content"></div>
                            <div class="fake-content"></div>
                            <!-- Tip start -->
                            <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/tip.php'; ?>
                            <!-- Tip end -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom footer start -->
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/footer.php'; ?>
            <!-- Custom footer end -->
        </div>
        <!-- Content wrapper end -->
    </div>
    <!-- Page wrapper end -->

    <!-- Include scripts to handle RBAC actions -->
    <script src="/js/dashboard/fetch-rbac-records.js"></script>
    <script src="/js/dashboard/rbac-edit.js"></script>
    <script src="/js/dashboard/rbac-add.js"></script>
    <script src="/js/dashboard/rbac-delete.js"></script>


</body>

</html>