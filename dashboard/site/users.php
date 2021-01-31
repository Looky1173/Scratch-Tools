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
    <title>Users | Scratch Tools Dashboard</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <!-- User deletion warning modal -->
    <div class="modal" id="delete-user-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <h5 class="modal-title">Confirm deletion</h5>
                <p>
                    Are you sure you would like to delete the user <b id="delete-user-username"></b>? <b class="text-danger">This action cannot be undone!</b>
                </p>
                <div class="text-right mt-20">
                    <a href="#" id="delete-user-close" class="btn mr-5" role="button" data-dismiss="modal">Close</a>
                    <button type="button" id="delete-user-confirm" class="btn btn-danger" disabled="disabled" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- User edit modal -->
    <div class="modal" id="edit-user-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <h5 class="modal-title">Edit</h5>
                <div id="edit-user-main"></div>
                <div class="text-right mt-20">
                    <a href="#" id="edit-user-close" class="btn mr-5" role="button" data-dismiss="modal">Close</a>
                    <button type="button" id="edit-user-save" class="btn btn-primary" disabled="disabled" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
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
                                Users
                            </h1>
                            <p>Here, you can view, modify, and delete accounts registered on Scratch Tools. You can (un)ban users too.</p>
                        </div>
                        <div class="card">
                            <h2 class="card-title">
                                Manage users
                            </h2>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Limit</span>
                                </div>
                                <input id="filter-limit" type="text" class="form-control" value="5">
                            </div>
                            <br>
                            <div>Showing <div id="total-shown" class="fake-content w-25 d-inline-block m-0"></div> results of <div id="total-data" class="fake-content w-25 d-inline-block m-0"></div>.</div>
                            <div id="table-users" class="table-responsive">
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr id="users-head">
                                            <th id="id">
                                                <div class="order" data-order="id"># <div class="order-indicator" data-order-indicator="none"></div>
                                                </div><input id="filter-id" type="text" class="form-control">
                                            </th>
                                            <th>Picture</th>
                                            <th id="username">
                                                <div class="order" data-order="username">Username <div class="order-indicator" data-order-indicator="none"></div>
                                                </div><input id="filter-username" type="text" class="form-control">
                                            </th>
                                            <th id="role">Role<input id="filter-role" type="text" class="form-control"></th>
                                            <th id="login-method">Login method<select class="form-control" id="filter-login-method">
                                                    <option value="" disabled="disabled">Select login method</option>
                                                    <option value="all" selected="selected">All</option>
                                                    <option value="scratch">Scratch</option>
                                                    <option value="password">Password</option>
                                                </select></th>
                                            <th id="created">
                                                <div class="order" data-order="created">Created <div class="order-indicator" data-order-indicator="none"></div>
                                                </div><input id="filter-created-start" type="date" class="form-control"><input id="filter-created-end" type="date" class="form-control">
                                            </th>
                                            <th id="modified">
                                                <div class="order" data-order="modified">Modified <div class="order-indicator" data-order-indicator="none"></div>
                                                </div><input id="filter-modified-start" type="date" class="form-control"><input id="filter-modified-end" type="date" class="form-control">
                                            </th>
                                            <th id="status">Status<select class="form-control" id="filter-status">
                                                    <option value="" disabled="disabled">Select status</option>
                                                    <option value="all" selected="selected">All</option>
                                                    <option value="normal">Normal</option>
                                                    <option value="disabled">Disabled</option>
                                                    <option value="banned">Banned</option>
                                                </select></th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users">
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <nav class="d-flex justify-content-center" aria-label="User navigation">
                                <ul id="users-pagination" class="pagination">
                                </ul>
                            </nav>
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
    <script src="/js/dashboard/users.js"></script>

</body>

</html>