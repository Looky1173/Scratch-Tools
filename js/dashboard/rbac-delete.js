$(document).ready(function () {
    $(document).on('click', '.rbac-delete', function () {
        id = $(this).attr('data-id');
        request = "deleteData";
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/rbac-crud.php",
            data: { "id": id, "request": request },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'fail') {
                    if (data.reason == 'users_exist_with_role') {
                        halfmoon.initStickyAlert({
                            content: 'Failed to delete role because one or more users are currently assigned to it!',
                            title: 'Error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                    if (data.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + data.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                } else if (data.status == 'success') {
                    loadRBAC();
                    halfmoon.initStickyAlert({
                        content: 'The role was successfully deleted!',
                        title: 'Deleted role',
                        alertType: 'alert-success',
                        hasDismissButton: false,
                        timeShown: 7500
                    });
                }

            },
            error: function () {
                halfmoon.initStickyAlert({
                    content: 'Failed to delete role!',
                    title: 'Error',
                    alertType: 'alert-danger',
                    hasDismissButton: false,
                    timeShown: 7500
                });
            }
        })

    })
})