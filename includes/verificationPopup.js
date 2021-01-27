function verificationPopup(myURL, title, myWidth, myHeight) {
    var left = (screen.width - myWidth) / 2;
    var top = (screen.height - myHeight) / 4;
    var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
    var pollTimer = window.setInterval(function() {
    if (myWindow.closed !== false) { // !== is required for compatibility with Opera
        window.clearInterval(pollTimer);
        alert("Closed")
    }
    },200);
}
