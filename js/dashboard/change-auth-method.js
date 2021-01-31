function getAuthMethodType() {
    $('#change-auth-method').html('<div class="fake-content"></div>');
    request = "getAuthType";
    $.ajax({
        type: "POST",
        url: "/resources/ajax/dashboard/change-auth-method.php",
        data: { "request": request },
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.status == 'success') {
                if (data.auth_type == 'scratch-login') {
                    $('#change-auth-method').html('Change authorization method from scratch login to password');
                    $('<form id="change-auth-method-form></form>"')
                } else if (data.auth_type == 'pwd-login') {
                    $('#change-auth-method').html('Change authorization method from password to scratch login');
                }
                $('#change-auth-method').prop('disabled', false);
            }
        }
    })
}

$(document).ready(function () {
    $('#change-auth-method').click(function () {
        request = "getAuthType";
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/change-auth-method.php",
            data: { "request": request },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    if (data.auth_type == 'scratch-login') {
                        $('#change-auth-method-div').html('<form id="change-auth-method"> <div class="form-group"> <label for="password">Password</label> <input type="password" id="password" class="form-control" placeholder="Password"> </div> <div class="form-group"> <label for="repeat-password">Repeat password</label> <input type="password" id="password_repeat" class="form-control" placeholder="Repeat password"> </div> <input id="submit-change-auth-method" class="btn btn-primary btn-block" type="submit" disabled="disabled" value="Set password"> </form>');
                        $('#submit-change-auth-method').prop('disabled', false);
                    } else if (data.auth_type == 'pwd-login') {
                        request = "changeAuthMethodToScratchLogin";
                        $.ajax({
                            type: "POST",
                            url: "/resources/ajax/dashboard/change-auth-method.php",
                            data: { "request": request },
                            dataType: "json",
                            success: function (data) {
                                console.log(data);
                                if (data.status == 'success') {
                                    getAuthMethodType()
                                    halfmoon.initStickyAlert({
                                        content: 'Successfully changed authentication method from password to scratch login.',
                                        title: 'Authentication method changed',
                                        alertType: 'alert-success',
                                        hasDismissButton: false,
                                        timeShown: 7500
                                    });
                                }
                            }
                        })
                    }
                }
            }
        })
    })
    $(document).on('click', '#submit-change-auth-method', function (event) {
        event.preventDefault();
        request = 'changeAuthMethodToPassword';
        password = $('#password').val();
        password_repeat = $('#password_repeat').val();
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/change-auth-method.php",
            data: { "password": password, "password_repeat": password_repeat, "request": request },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#change-auth-method-div').remove();
                    getAuthMethodType()
                    halfmoon.initStickyAlert({
                        content: 'Successfully changed authentication method from scratch login to password.',
                        title: 'Authentication method changed',
                        alertType: 'alert-success',
                        hasDismissButton: false,
                        timeShown: 7500
                    });
                } else if (data.status == 'fail') {
                    if (data.error_type == 'general') {
                        halfmoon.initStickyAlert({
                            content: 'Your action could not be processed for the following reason: <code class="code">' + data.reason + '</code>.',
                            title: 'Error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                    if (data.error_type == 'password') {
                        halfmoon.initStickyAlert({
                            content: 'Your action could not be processed for the following reason: <code class="code">' + data.reason + '</code><br><br><b>Note:</b> Passwords should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.',
                            title: 'Password error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }
            }
        })
    })
    getAuthMethodType()
})