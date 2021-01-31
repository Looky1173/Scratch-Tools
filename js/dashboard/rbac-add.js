$(document).ready(function(){
    $('#submit-add-role').click(function(event){
        event.preventDefault();
        id = $(this).attr('data-id');
        roleName = $('#add-role-roleName').val();
        permissions = $('#add-role-permissions').val();
        request = "addData";
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/rbac-crud.php",
            data: {"id": id, "roleName": roleName, "permissions": permissions, "request": request},
            dataType: "json",
            success: function(data){
                console.log(data);
                if(data.status == 'success'){
                    $('#add-role-form').remove();
                $('#add-role').prop('disabled', false);
                loadRBAC();
                halfmoon.initStickyAlert({
                    content: 'The role <code class="code">' + roleName + '</code> was successfully created',
                    title: 'Role added',
                    alertType: 'alert-success',
                    hasDismissButton: false,
                    timeShown: 7500
                  });
                }else if (data.status == 'fail'){
                    if(data.error_type == 'auth'){
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
            error: function(){
                halfmoon.initStickyAlert({
                    content: 'Failed to add the role <code class="code">' + roleName + '</code>!',
                    title: 'Error',
                    alertType: 'alert-danger',
                    hasDismissButton: false,
                    timeShown: 7500
                  });
            }
        })
        
    })
    $('#add-role').click(function(){
        $('#add-role').prop('disabled', true);
        $('#add-role-form').removeClass('d-none');
    })
    $('#cancel-add-role').click(function(){
        $('#add-role').prop('disabled', false);
        $('#add-role-form').addClass('d-none');
    })
})