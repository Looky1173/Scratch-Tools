function lookup(user) {
    if (user != '') {
        window.location.href = '/user/' + user;
    }
}

$(document).ready(function () {

    $('#lookup').click(function (e) {
        e.preventDefault();
        username = $('#search-username').val();
        lookup(username);
    })
    $('#lookup-s').click(function (e) {
        e.preventDefault();
        username = $('#search-username-s').val();
        lookup(username);
    })

})