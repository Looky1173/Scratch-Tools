// Open external links in a popup modal notice
$(document).ready(function () {
    var tmpLink;
    var target;
    var externalLink;

    $(document).on('click', 'a', function (e) {
        // create temporary anchor
        tmpLink = document.createElement('a');
        tmpLink.href = this.href;

        target = tmpLink.target;

        // check if anchor host matches top window host
        externalLink = (tmpLink.hostname !== top.location.hostname);

        // if this is an external link, show confirmation dialog
        if (externalLink) {
            e.preventDefault();
            halfmoon.toggleModal('external-modal');
            $('#proceed-to-external-site').html('Proceed to <i>' + tmpLink + '</i>');
            //go to link on modal close
            $('#proceed-to-external-site').click(function () {
                console.log(tmpLink + ' ' + target);
                window.open(tmpLink, target);
            });
        }

        // if we're here just return true to allow propagation as normal
        return true;
    });

});