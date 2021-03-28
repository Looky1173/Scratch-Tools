function lookup(user) {
    if (user != '') {
        window.location.href = '/search/users/' + user;
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