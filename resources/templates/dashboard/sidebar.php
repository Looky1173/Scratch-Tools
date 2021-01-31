<?php
/*
$perm = new Permissions($db);

$userRole = $perm->getRoleByUsername($_SESSION['username']);
echo $userRole;
$userPermissions = $perm->getPermissionsByRole($userRole);
print_r($userPermissions);*/
?>


<!--
<div class="sidebar">
    <div class="sidebar-menu">
        <div class="sidebar-content">
            <input type="text" class="form-control" placeholder="Search">
            <div class="mt-10 font-size-12">
                Press <kbd>Shif</kbd> + <kbd>F</kbd> to focus
            </div>
        </div>
        <h5 class="sidebar-title">Settings</h5>
        <div class="sidebar-divider"></div>
        <a href="/dashboard/settings/account" id="sidebar-account" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
            </span>
            My account
        </a>
        <a href="/dashboard/settings/advanced" id="sidebar-advanced" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-cog" aria-hidden="true"></i>
            </span>
            Advanced
        </a>
        <br>
        <h5 class="sidebar-title">My stuff</h5>
        <div class="sidebar-divider"></div>
        <a href="/dashboard/mystuff/collaborations" id="sidebar-collaborations" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            </span>
            Collaborations
        </a>
        <a href="/dashboard/mystuff/shops" id="sidebar-shops" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </span>
            Shops
        </a>
        <br>
        <h5 class="sidebar-title">Site</h5>
        <div class="sidebar-divider"></div>
        <a href="/dashboard/site/maintenance" id="sidebar-maintenance" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </span>
            Maintenance
        </a>
        <a href="/dashboard/site/users" id="sidebar-users" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </span>
            Users
        </a>
        <a href="/dashboard/site/logs" id="sidebar-logs" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-history" aria-hidden="true"></i>
            </span>
            Logs
        </a>
        <a href="/dashboard/site/rbac" id="sidebar-rbac" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-key" aria-hidden="true"></i>
            </span>
            RBAC
        </a>
        <a href="/dashboard/site/featured" id="sidebar-featured" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-flag" aria-hidden="true"></i>
            </span>
            Featured
        </a>
        <a href="/dashboard/site/announcements" id="sidebar-announcements" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fa fa-bullhorn" aria-hidden="true"></i>
            </span>
            Announcements
        </a>
    </div>
</div>

-->

<div class="sidebar">
    <div class="sidebar-menu">
        <div class="sidebar-content">
            <input type="text" class="form-control" placeholder="Search">
            <div class="mt-10 font-size-12">
                Press <kbd>Shift</kbd> + <kbd>F</kbd> to focus
            </div>
        </div>
        <h5 id="sidebar-settings" class="sidebar-title">
            <div class="fake-content w-100"></div>
        </h5>
        <div id="sidebar-settings-divider" class="sidebar-divider"></div>
        <a href="#" id="sidebar-account" class="sidebar-link">
            <div class="fake-content w-200"></div>
        </a>
        <a href="#" id="sidebar-advanced" class="sidebar-link">
            <div class="fake-content" style="width: 15rem;"></div>
        </a>
        <br>
        <h5 id="sidebar-mystuff" class="sidebar-title">
            <div class="fake-content" style="width: 7rem;"></div>
        </h5>
        <div id="sidebar-mystuff-divider" class="sidebar-divider"></div>
        <a href="#" id="sidebar-collaborations" class="sidebar-link">
            <div class="fake-content w-100"></div>
        </a>
        <a href="#" id="sidebar-shops" class="sidebar-link">
            <div class="fake-content" style="width: 8rem;"></div>
        </a>
        <br>
        <h5 id="sidebar-site" class="sidebar-title">
            <div class="fake-content w-100"></div>
        </h5>
        <div id="sidebar-site-divider" class="sidebar-divider"></div>
        <a href="#" id="sidebar-maintenance" class="sidebar-link">
            <div class="fake-content" style="width: 15rem;"></div>
        </a>
        <a href="#" id="sidebar-users" class="sidebar-link">
            <div class="fake-content" style="width: 8rem;"></div>
        </a>
        <a href="#" id="sidebar-logs" class="sidebar-link">
            <div class="fake-content" style="width: 8rem;"></div>
        </a>
        <a href="#" id="sidebar-rbac" class="sidebar-link">
            <div class="fake-content w-100"></div>
        </a>
        <a href="#" id="sidebar-featured" class="sidebar-link">
            <div class="fake-content w-100"></div>
        </a>
        <a href="#" id="sidebar-announcements" class="sidebar-link">
            <div class="fake-content w-200"></div>
        </a>
    </div>
</div>

<script src="/js/dashboard/sidebar.js"></script>