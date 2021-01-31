function loadRBAC() {
    $('#rbac-data').html('<tr><th><div class="fake-content"></th><td><div class="fake-content"></td><td><div class="fake-content"></td><td><div class="fake-content"></td></tr><tr><th><div class="fake-content"></th><td><div class="fake-content"></td><td><div class="fake-content"></td><td><div class="fake-content"></td></tr><tr><th><div class="fake-content"></th><td><div class="fake-content"></td><td><div class="fake-content"></td><td><div class="fake-content"></td></tr><tr><th><div class="fake-content"></th><td><div class="fake-content"></td><td><div class="fake-content"></td><td><div class="fake-content"></td></tr>');
    $.ajax({
        type: "POST",
        url: "/resources/ajax/dashboard/fetch-rbac-records.php",
        dataType: "json",
        success: function (data) {
            console.log(data);
            if(data.status == 'success'){
                $('#rbac-data').html(data.rbac_data);
            }else if(data.status = 'fail'){
                if(data.error_type == 'auth'){
                    $('#rbac-data').html('<p><code class="code">' + data.reason + '</code>');
                }
                
            }
            
        }
    })
}

$(document).ready(function () {
    loadRBAC();
})