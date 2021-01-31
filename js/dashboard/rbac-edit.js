$(document).ready(function () {
    $(document).on('click', '.rbac-edit', function () {
        id = $(this).attr('data-id');
        request = "getData";
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/fetch-rbac-data.php",
            data: { "id": id, "request": request },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#update-role-form').remove();
                    $('<form id="update-role-form" class="mw-full"> <!-- Input --> <div class="form-group"> <label for="full-name" class="required">Role name</label> <input id="update-rbac-roleName" type="text" class="form-control" id="full-name" placeholder="A descriptive name of new role" value="' + data.roleName + '" required="required"> </div> <!-- Select permissions --> <div class="form-group"> <label for="languages" class="required">Permissions</label> <select class="form-control" id="update-rbac-permissions" multiple="multiple" required="required" size="5">' + data.string + '</select> </div><input id="cancel-update-role" class="btn" type="button" value="Cancel"> <!-- Submit button --> <input id="submit-update-role" class="btn btn-primary" type="submit" value="Update role"> </form>').insertAfter('#add-role-form');
                } else if (data.status == 'fail') {
                    if (data.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + data.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }


            },
            error: function () {
                $('<b>Failed to get data!</b>').insertAfter('#add-role-form');
            }
        })

    })
    $(document).on('click', '#submit-update-role', function (event) {
        event.preventDefault();
        roleName = $('#update-rbac-roleName').val();
        permissions = $('#update-rbac-permissions').val();
        request = "updateData";
        console.log(permissions);
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/rbac-crud.php",
            data: { "id": id, "roleName": roleName, "permissions": permissions, "request": request },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#update-role-form').remove();
                    loadRBAC();
                    halfmoon.initStickyAlert({
                        content: 'The role <code class="code">' + roleName + '</code> was successfully updated!',
                        title: 'Updated role',
                        alertType: 'alert-success',
                        hasDismissButton: false,
                        timeShown: 7500
                    });
                } else if (data.status == 'fail') {
                    if (data.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + data.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }

            },
            error: function () {
                halfmoon.initStickyAlert({
                    content: 'Failed to update the role <code class="code">' + roleName + '</code>!',
                    title: 'Error',
                    alertType: 'alert-danger',
                    hasDismissButton: false,
                    timeShown: 7500
                });
            }
        })
    })
    $(document).on('click', '#cancel-update-role', function () {
        $('#update-role-form').remove();
    })
})