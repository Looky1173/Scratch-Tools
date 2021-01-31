$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "/resources/ajax/dashboard/fetch-sidebar.php",
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.access_account_settings == true || data.access_account_advanced == true) {
                $('#sidebar-settings').html('Settings');
            }else{
                $('#sidebar-settings').remove();
                $('#sidebar-settings-divider').remove();
            }
            if (data.access_collaborations == true || data.access_shops == true) {
                $('#sidebar-mystuff').html('My stuff');
            }else{
                $('#sidebar-mystuff').remove();
                $('#sidebar-mystuff-divider').remove();
            }
            if (data.access_maintenance == true || data.access_users == true || data.access_logs == true || data.access_rbac == true || data.access_featured == true || data.access_announcements == true) {
                $('#sidebar-site').html('Site');
            }else{
                $('#sidebar-site').remove();
                $('#sidebar-site-divider').remove();
            }

            if(data.access_account_settings == true){
                $('#sidebar-account').replaceWith('<a href="/dashboard/settings/account" id="sidebar-account" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-user-circle" aria-hidden="true"></i> </span> My account </a>');
            }else{
                $('#sidebar-account').remove();
            }
            if(data.access_account_advanced == true){
                $('#sidebar-advanced').replaceWith('<a href="/dashboard/settings/advanced" id="sidebar-advanced" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-cog" aria-hidden="true"></i> </span> Advanced </a>');
            }else{
                $('#sidebar-advanced').remove();
            }
            if(data.access_collaborations == true){
                $('#sidebar-collaborations').replaceWith('<a href="/dashboard/mystuff/collaborations" id="sidebar-collaborations" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-folder-open" aria-hidden="true"></i> </span> Collaborations </a>');
            }else{
                $('#sidebar-collaborations').remove();
            }
            if(data.access_shops == true){
                $('#sidebar-shops').replaceWith('<a href="/dashboard/mystuff/shops" id="sidebar-shops" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-shopping-cart" aria-hidden="true"></i> </span> Shops </a>');
            }else{
                $('#sidebar-shops').remove();
            }
            if(data.access_maintenance == true){
                $('#sidebar-maintenance').replaceWith('<a href="/dashboard/site/maintenance" id="sidebar-maintenance" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-exclamation-triangle" aria-hidden="true"></i> </span> Maintenance </a>');
            }else{
                $('#sidebar-maintenance').remove();
            }
            if(data.access_users == true){
                $('#sidebar-users').replaceWith('<a href="/dashboard/site/users" id="sidebar-users" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-users" aria-hidden="true"></i> </span> Users </a>');
            }else{
                $('#sidebar-users').remove();
            }
            if(data.access_logs == true){
                $('#sidebar-logs').replaceWith('<a href="/dashboard/site/logs" id="sidebar-logs" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-history" aria-hidden="true"></i> </span> Logs </a>');
            }else{
                $('#sidebar-logs').remove();
            }
            if(data.access_rbac == true){
                $('#sidebar-rbac').replaceWith('<a href="/dashboard/site/rbac" id="sidebar-rbac" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-key" aria-hidden="true"></i> </span> RBAC </a>');
            }else{
                $('#sidebar-rbac').remove();
            }
            if(data.access_featured == true){
                $('#sidebar-featured').replaceWith('<a href="/dashboard/site/featured" id="sidebar-featured" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-flag" aria-hidden="true"></i> </span> Featured </a>');
            }else{
                $('#sidebar-featured').remove();
            }
            if(data.access_announcements == true){
                $('#sidebar-announcements').replaceWith('<a href="/dashboard/site/announcements" id="sidebar-announcements" class="sidebar-link sidebar-link-with-icon"> <span class="sidebar-icon"> <i class="fas fa-bullhorn" aria-hidden="true"></i> </span> Announcements </a>');
            }else{
                $('#sidebar-announcements').remove();
            }

        },
        error: function () {
            $('.sidebar-menu').replaceWith('<div class="text-center font-size-24"><b>Failed to fetch and build sidebar!</b></div>');
        }
    })
})