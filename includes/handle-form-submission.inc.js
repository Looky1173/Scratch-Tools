$(document).ready(function () {
  $('#submit-login').prop("disabled", false);
  $('#submit-register').prop("disabled", false);
  $('#submit-forgot-password').prop("disabled", false);
  $('#logout').prop("disabled", false);
  $('#delete-account').prop("disabled", false);
  $("#submit-register").click(function (event) {
    event.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();
    var password_repeat = $("#password_repeat").val();
    var request = "register";
    $('#submit-register').prop("disabled", true);
    $('input').removeClass(['is-invalid']);
    $('.invalid-feedback').remove();
    $.ajax({
      type: "POST",
      url: "handle-users.php",
      data: {
        "username": username,
        "password": password,
        "password_repeat": password_repeat,
        "request": request
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          $('#submit-register').prop("disabled", false);
          //Possible errors
          if (response.type === "username-missing" || response.type === "username-taken" || response.type === "username-invalid" || response.type === "username-not-registered") {
            //The username is missing
            $("#username").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="username"]');
          }
          if (response.type === "password-mismatch" || response.type === "weak-password" || response.type === "password-missing") {
            $("#password").addClass("is-invalid");
            $("#password_repeat").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="password"]');
          }
        }
        if (response.status === "success") {
          //The form validation was successful
          username = response.username;
          password = response.password;
          password_repeat = response.password_repeat;
          $('#register-form').fadeOut(1000, function () {
            $('#register-form').remove();
            $('<div id="verification-div"  style="display: none;"><p class="text-justify">To verify your identity, please login to your Scratch account, go to the verification project, comment the code below, and come back here!</p><p>Your verification code: <strong>' + response.message + '</strong></p><button id="verification-popup-button" class="btn btn-primary btn-block" type="button" disabled="disabled">Open verification project</button></div>').insertAfter('.modal-title');
            $('#verification-div').fadeIn(1000, function () {
              $('#verification-popup-button').prop("disabled", false);
              $('#verification-popup-button').click(function () {
                $('#verification-popup-button').prop("disabled", true);
                var myURL = "https://scratch.mit.edu/projects/440802985/#footer";
                var title = "Scratch Verification Popup";
                var myWidth = 800;
                var myHeight = 600;
                var left = (screen.width - myWidth) / 2;
                var top = (screen.height - myHeight) / 4;
                var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
                var pollTimer = window.setInterval(function () {
                  if (myWindow.closed !== false) { // !== is required for compatibility with Opera
                    window.clearInterval(pollTimer);
                    $("#verification-popup-button").removeClass();
                    $("#verification-popup-button").addClass("btn btn-primary btn-block");
                    $('#verification-popup-button').html("Verifying...");
                    request = "verification";
                    $.ajax({
                      type: "POST",
                      url: "handle-users.php",
                      data: {
                        "username": username,
                        "password": password,
                        "password_repeat": password_repeat,
                        "verification_code": response.message,
                        "request": request
                      },
                      dataType: "json",
                      success: function (response) {
                        console.log(response);
                        if (response.return === "true") {
                          //Register user
                          $('#verification-popup-button').fadeOut(500, function () {
                            $('#page-wrapper').fadeOut(2000, function () {
                              $('#page-wrapper').remove();
                              $('body').append('<div id="page-wrapper" class="page wrapper" style="display: none;"><div class="text-center"><p class="font-size-24">Welcome, ' + response.username + '!</p><p class="font-size-12">Getting everything ready...</p></div></div>');
                              window.setTimeout(function () {
                                $('#page-wrapper').fadeIn(1000, function () {
                                  request = "register-final";
                                  $.ajax({
                                    type: "POST",
                                    url: "handle-users.php",
                                    data: {
                                      "username": username,
                                      "password": password,
                                      "request": request
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                      console.log("The response is: " + response);
                                      if (response.success === "true") {
                                        window.location.replace("http://localhost/st");
                                      } else {
                                        alert("ERROR");
                                      }
                                    },
                                    error: function () {
                                      alert("UNKNOWN ERROR");
                                    }
                                  })
                                });
                              }, 1000);

                            });

                          });
                        } else {
                          //Throw error
                          $("#verification-popup-button").removeClass();
                          $("#verification-popup-button").addClass("btn btn-danger btn-block");
                          $('#verification-popup-button').html("Verification failed! Click here to retry.");
                          $('#verification-popup-button').prop("disabled", false);

                        }

                      }
                    })
                  }
                }, 200);
              });
            })

          });
        }
      },
      error: function () {
        alert("UNKNOWN ERROR");
      }
    });
  });
  $('#submit-login').click(function (event) {
    event.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();
    var request = "login";
    $('#submit-login').prop("disabled", true);
    $('input').removeClass(['is-invalid']);
    $('.invalid-feedback').remove();
    request = "login";
    $.ajax({
      type: "POST",
      url: "handle-users.php",
      data: {
        "username": username,
        "password": password,
        "request": request
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          $('#submit-login').prop("disabled", false);
          if (response.type === "not-registered") {
            $("#username").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="username"]');
          }
          if (response.type === "weak-password" || response.type === "user-without-password") {
            $("#password").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="username"]');
          }
          if (response.type === "login-fail") {
            $("#username").addClass("is-invalid");
            $("#password").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="username"]');
          }
        }
        if (response.status === "success") {
          if (response.type === "scratch-login") {
            $('#login-form').fadeOut(1000, function () {
              $('#login-form').remove();
              $('<div id="verification-div"  style="display: none;"><p class="text-justify">To verify your identity, please login to your Scratch account, go to the verification project, comment the code below, and come back here!</p><p>Your verification code: <strong>' + response.message + '</strong></p><button id="verification-popup-button" class="btn btn-primary btn-block" type="button" disabled="disabled">Open verification project</button></div>').insertAfter('.modal-title');
              $('#verification-div').fadeIn(1000, function () {
                $('#verification-popup-button').prop("disabled", false);
                $('#verification-popup-button').click(function () {
                  $('#verification-popup-button').prop("disabled", true);
                  var myURL = "https://scratch.mit.edu/projects/440802985/#footer";
                  var title = "Scratch Verification Popup";
                  var myWidth = 800;
                  var myHeight = 600;
                  var left = (screen.width - myWidth) / 2;
                  var top = (screen.height - myHeight) / 4;
                  var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
                  var pollTimer = window.setInterval(function () {
                    if (myWindow.closed !== false) { // !== is required for compatibility with Opera
                      window.clearInterval(pollTimer);
                      $("#verification-popup-button").removeClass();
                      $("#verification-popup-button").addClass("btn btn-primary btn-block");
                      $('#verification-popup-button').html("Verifying...");
                      request = "verification";
                      $.ajax({
                        type: "POST",
                        url: "handle-users.php",
                        data: {
                          "username": username,
                          "verification_code": response.message,
                          "request": request
                        },
                        dataType: "json",
                        success: function (response) {
                          console.log(response);
                          if (response.return === "true") {
                            //Login user
                            $('#verification-popup-button').fadeOut(500, function () {
                              request = "scratch-login";
                              $.ajax({
                                type: "POST",
                                url: "handle-users.php",
                                data: {
                                  "username": username,
                                  "request": request
                                },
                                dataType: "json",
                                success: function (response) {
                                  console.log(response);
                                  if (response.success === "true") {
                                    window.location.replace("http://localhost/st");
                                  }
                                },
                                error: function () {
                                  alert("Error");
                                }
                              })
                            });
                          } else {
                            //Throw error
                            $("#verification-popup-button").removeClass();
                            $("#verification-popup-button").addClass("btn btn-danger btn-block");
                            $('#verification-popup-button').html("Verification failed! Click here to retry.");
                            $('#verification-popup-button').prop("disabled", false);

                          }

                        }
                      })
                    }
                  }, 200);
                });
              })
            });
          }
          if (response.type === "login") {
            window.location.replace("http://localhost/st");
          }
        }
      },
      error: function () {
        alert("Error");
      }
    });
  });
  $('#submit-forgot-password').click(function (event) {
    event.preventDefault();
    var username = $("#username").val();
    $('#submit-forgot-password').prop("disabled", true);
    $('input').removeClass(['is-invalid']);
    $('.invalid-feedback').remove();
    request = "forgot-password";
    $.ajax({
      type: "POST",
      url: "handle-users.php",
      data: {
        "username": username,
        "request": request
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "error") {
          //Possible errors
        }
        if (response.status === "success") {
          //
        }
      },
      error: function(){
        alert("UNKNOWN ERROR");
      }
    });
  });
  $('#logout').click(function () {
    $('#logout').prop("disabled", true);
    $('#delete-account').prop("disabled", true);
    request = "logout";
    $.ajax({
      type: "POST",
      url: "handle-users.php",
      data: {
        "request": request
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "error") {
          alert("An error has occured while trying to log you out. Please refresh the page and try again!")
        } else if (response.status === "success") {
          window.location.replace("http://localhost/st");
        }
      },
      error: function(){
        alert("UNKNOWN ERROR");
      }
    });
  });
  $('#delete-account').click(function () {
    $('#delete-account').prop("disabled", true);
    $('#logout').prop("disabled", true);
    request = "delete-account";
    $.ajax({
      type: "POST",
      url: "handle-users.php",
      data: {
        "request": request
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "error") {
          alert("An error has occured while trying to delete your account. Please refresh the page and try again!")
        } else if (response.status === "success") {
          window.location.replace("http://localhost/st");
        }
      },
      error: function(){
        alert("UNKNOWN ERROR");
      }
    });
  });
});