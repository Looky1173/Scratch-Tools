function loadImage(user, id) {
    $.ajax({
        type: "GET",
        url: "https://api.allorigins.win/raw?url=https://api.scratch.mit.edu/users/" + user,
        dataType: "json",
        success: function (response) {
            image = response.profile.images['90x90'];
            console.log(image);
            $('tr[data-id="' + id + '"]').children('td').children('div.profile-picture').append('<img data-id="' + id + '" src="' + image + '" width="50px" height="50px">');
            $('img[data-id="' + id + '"]').on('load', function () {
                $('img[data-id="' + id + '"]').addClass('rounded');
                $('img[data-id="' + id + '"]').parent('div').removeClass();
                $('img[data-id="' + id + '"]').parent('div').children('script').remove();
            });
        },
        error: function () {
            $('tr[data-id="' + id + '"]').children('td').children('div.profile-picture').replaceWith('<i class="text-danger font-size-24 fa fa-times-circle"></i>');
        }
    })
}

$(document).ready(function () {
    order = 'none';
    order_by = '';
    page = 1;
    timer = null;
    id = null;
    user = null;
    value = null;
    loadData(1);
    $(document).on('click', '.page-link', function () {
        page = $(this).data('page_number');
        loadData(page);
    });
    $('#filter-limit').keyup(function () {
        loadData(1);
    })
    $('#users-head').keyup(function () {
        loadData(1);
    })
    $('#login-method').change(function () {
        loadData(1);
    });
    $('#status').change(function () {
        loadData(1);
    });
    $('input[type="date"]').change(function () {
        loadData(1);
    });
    $('.order').click(function () {
        order_indicator = $(this).children('.order-indicator').data('order-indicator');
        $('.order-indicator').html('');
        $('.order-indicator').data('order-indicator', 'none');
        switch (order_indicator) {
            case 'none':
                $(this).children('.order-indicator').html('<b class="text-success">ASC</b>');
                $(this).children('.order-indicator').data('order-indicator', 'asc');
                order = 'asc';
                break;
            case 'asc':
                $(this).children('.order-indicator').html('<b class="text-danger">DESC</b>');
                $(this).children('.order-indicator').data('order-indicator', 'desc');
                order = 'desc';
                break;
            case 'desc':
                $(this).children('.order-indicator').html('');
                $(this).children('.order-indicator').data('order-indicator', 'none');
                order = 'none';
                order_by = '';
                break;
            default:
                $(this).children('.order-indicator').html('');
                $(this).children('.order-indicator').data('order-indicator', 'none');
                order = 'none';
                order_by = '';
                break;
        }
        order_by = $(this).data('order');
        loadData(page);
    })
    function loadData(page) {
        limit = $('#filter-limit').val();
        $('#users-pagination').html('<li class="page-item"><div class="fake-content w-300"></div></li>');
        preloader = '';
        for (i = 1; i <= limit; i++) {
            preloader += '<tr><th><div class="fake-content w-50"></div><td><div class="fake-content w-50 h-50"></div><td><div class="fake-content w-150"></div><td><div class="fake-content w-100"></div><td><div class=fake-content></div><td><div class=fake-content></div><td><div class="fake-content w-100"></div><td><div class="fake-content w-200"></div>';
        }
        console.log(preloader);
        $('#users').html(preloader);
        $('#total-shown').replaceWith('<div id="total-shown" class="fake-content w-25 d-inline-block m-0"></div>');
        $('#total-data').replaceWith('<div id="total-data" class="fake-content w-25 d-inline-block m-0"></div>');

        id = $('#filter-id').val();
        username = $('#filter-username').val();
        role = $('#filter-role').val();
        login_method = $('#filter-login-method').val();
        created_start = $('#filter-created-start').val();
        modified_start = $('#filter-modified-start').val();
        created_end = $('#filter-created-end').val();
        modified_end = $('#filter-modified-end').val();
        status = $('#filter-status').val();

        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/users.php",
            data: { 'page': page, 'limit': limit, 'filters': { 'id': id, 'username': username, 'role': role, 'login_method': login_method, 'created': { 'start': created_start, 'end': created_end }, 'modified': { 'start': modified_start, 'end': modified_end } }, 'order': { 'order': order, 'order-by': order_by }, 'status': status, 'request': 'load_data' },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#no-data-returned').remove();
                    $('#users-pagination').html(data.pagination);
                    $('#users').html(data.users);
                    $('#total-shown').replaceWith('<b id="total-shown">' + data.total_shown + '</b>');
                    $('#total-data').replaceWith('<b id="total-data">' + data.total + '</b>');
                } else if (data.status == 'fail') {
                    if (data.error_type == 'data') {
                        if (data.reason == 'no_data_returned') {
                            $('#no-data-returned').remove();
                            $('#users').html('');
                            $('#users-pagination').html('');
                            $('<div id="no-data-returned" class="d-flex justify-content-center"><h1 class="font-size-20">No data returned</h1></div>').insertAfter('#table-users');
                        }
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
                }

            },
        })
    }

    $(document).on('click', '.users-edit', function () {
        id = $(this).parent('div').parent('td').parent('tr').data('id');
        user = $(this).parent('div').parent('td').parent('tr').children('td.username').data('username');
        $('#edit-user-save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/users.php",
            data: { 'id': id, 'username': user, 'request': 'init_edit_user' },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    halfmoon.toggleModal('edit-user-modal');
                    $('#edit-user-main').html('You are currently editing the user <b>' + user + '</b> with the id <b>' + id + '</b>.<br>' + response.select);
                } else if (response.status == 'fail') {
                    if (response.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + response.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }
            }
        })

    });
    $(document).on('change', '#edit-user-role', function () {
        value = $('#edit-user-role').val();
        $('#edit-user-save').prop('disabled', false);
    })
    $(document).on('click', '#edit-user-save', function () {
        $.ajax({
            type: 'POST',
            url: '/resources/ajax/dashboard/users.php',
            data: { 'id': id, 'role': value, 'request': 'edit_user' },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    loadData(1);
                    halfmoon.initStickyAlert({
                        content: 'The role of the user <b>' + user + '</b> was successfully updated!',
                        title: 'Success',
                        alertType: 'alert-success',
                        hasDismissButton: false,
                        timeShown: 7500
                    });
                } else if (response.status == 'fail') {
                    if (response.error_type == 'unknown') {
                        halfmoon.initStickyAlert({
                            content: 'An unknown error has occured!',
                            title: 'Error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                    if (response.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + response.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }
            }
        })
    })
    $(document).on('click', '.users-delete', function () {
        id = $(this).parent('div').parent('td').parent('tr').data('id');
        user = $(this).parent('div').parent('td').parent('tr').children('td.username').data('username');
        halfmoon.toggleModal('delete-user-modal');
        delete_user_countdown = 5;
        clearTimeout(timer);
        $('#delete-user-username').html(user);
        $('#delete-user-confirm').html('Confirm');
        $('#delete-user-confirm').prop('disabled', true);
        deleteUserCountdown();
        function deleteUserCountdown() {
            if (delete_user_countdown > 0) {
                $('#delete-user-confirm').html('Confirm (' + delete_user_countdown + 's)');
                timer = setTimeout(function () {
                    delete_user_countdown--;
                    deleteUserCountdown();
                }, 1000)
            } else {
                $('#delete-user-confirm').html('Confirm');
                $('#delete-user-confirm').prop('disabled', false);
            }
        }
    });
    $(document).on('click', '#delete-user-confirm', function () {
        $.ajax({
            type: "POST",
            url: "/resources/ajax/dashboard/users.php",
            data: { 'id': id, 'request': 'delete_data' },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    loadData(1);
                    halfmoon.initStickyAlert({
                        content: 'The user <b>' + user + '</b> was successfully deleted!',
                        title: 'Success',
                        alertType: 'alert-success',
                        hasDismissButton: false,
                        timeShown: 7500
                    });
                } else if (response.status == 'fail') {
                    if (response.error_type == 'unknown') {
                        if (response.reason == 'no_data_returned') {
                            halfmoon.initStickyAlert({
                                content: '<code class="code">' + response.reason + '</code>',
                                title: 'Error',
                                alertType: 'alert-danger',
                                hasDismissButton: false,
                                timeShown: 7500
                            });
                        }
                    }
                    if (response.error_type == 'auth') {
                        halfmoon.initStickyAlert({
                            content: '<code class="code">' + response.reason + '</code>',
                            title: 'Authorization error',
                            alertType: 'alert-danger',
                            hasDismissButton: false,
                            timeShown: 7500
                        });
                    }
                }
            }
        })
    })
})