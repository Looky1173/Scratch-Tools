$(document).ready(function () {

  //Declare variable for verification codes
  var verification_code;

  var animations;
  var fadeAnimationDuration = 500;
  var registerFadeAnimationDuration = 1000;
  if (localStorage.getItem('animations')) {
    animations = localStorage.getItem('animations');
  } else {
    animations = 'on';
  }
  localStorage.setItem('animations', animations);
  if (animations == 'on') {
    $('#animations').prop("checked", true);
    fadeAnimationDuration = 500;
    registerFadeAnimationDuration = 1000;
  } else if (animations == 'off') {
    $('#animations').prop("checked", false);
    fadeAnimationDuration = 0;
    registerFadeAnimationDuration = 0;
  }

  function copyVerificationCode(verificaton_code){
    alert("Copied code: " + verification_code);
  }
  
  $('#animations').prop("disabled", false);
  $('#submit-login').prop("disabled", false);
  $('#submit-register').prop("disabled", false);
  $('#submit-forgot-password').prop("disabled", false);
  $('#logout').prop("disabled", false);
  $('#delete-account').prop("disabled", false);
  $('#animations').click(function () {
    var animationsSwitch = $('#animations').is(':checked');
    if (animationsSwitch === true) {
      animations = 'on';
      fadeAnimationDuration = 500;
      registerFadeAnimationDuration = 1000;
    } else if (animationsSwitch === false) {
      animations = 'off';
      fadeAnimationDuration = 0;
      registerFadeAnimationDuration = 0;
    }
    localStorage.setItem('animations', animations);
  });
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
          $('#register-form').fadeOut(fadeAnimationDuration, function () {
            $('#register-form').remove();
            verification_code = response.verification_code;
            $('<div id="verification-div"  style="display: none;"><p class="text-justify">To verify your identity, please login to your Scratch account, go to the verification project, comment the code below, and come back here!</p><p>Your verification code: <strong>' + verification_code + '</strong><button id="copy" class="btn ml-5" type="button">Copy</button></p><button id="verification-popup-button" class="btn btn-primary btn-block" type="button" disabled="disabled">Open verification project</button></div>').insertAfter('.modal-title');
            $('#verification-div').fadeIn(fadeAnimationDuration, function () {
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
                        "verification_code": response.verification_code,
                        "request": request
                      },
                      dataType: "json",
                      success: function (response) {
                        console.log(response);
                        if (response.return === "true") {
                          //Register user
                          $('#verification-popup-button').fadeOut(fadeAnimationDuration, function () {
                            $('#page-wrapper').fadeOut(registerFadeAnimationDuration, function () {
                              $('#page-wrapper').remove();
                              $('body').append('<div id="page-wrapper" class="page wrapper" style="display: none;"><div class="text-center"><p class="font-size-24">Welcome, ' + response.username + '!</p><p class="font-size-12">Getting everything ready...</p></div></div>');
                              window.setTimeout(function () {
                                $('#page-wrapper').fadeIn(registerFadeAnimationDuration, function () {
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
                                        window.location.replace("index");
                                      } else {
                                        alert("ERROR");
                                      }
                                    },
                                    error: function () {
                                      alert("UNKNOWN ERROR");
                                    }
                                  })
                                });
                              }, registerFadeAnimationDuration);

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
            $('#login-form').fadeOut(fadeAnimationDuration, function () {
              $('#login-form').remove();
              verification_code = response.verification_code;
              $('<div id="verification-div"  style="display: none;"><p class="text-justify">To verify your identity, please login to your Scratch account, go to the verification project, comment the code below, and come back here!</p><p>Your verification code: <strong>' + verification_code + '</strong><button id="copy" class="btn ml-5" type="button">Copy</button></p><button id="verification-popup-button" class="btn btn-primary btn-block" type="button" disabled="disabled">Open verification project</button></div>').insertAfter('.modal-title');
              $('#verification-div').fadeIn(fadeAnimationDuration, function () {
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
                          "verification_code": response.verification_code,
                          "request": request
                        },
                        dataType: "json",
                        success: function (response) {
                          console.log(response);
                          if (response.return === "true") {
                            //Login user
                            $('#verification-popup-button').fadeOut(fadeAnimationDuration, function () {
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
                                    window.location.replace("index");
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
            window.location.replace("index");
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
        console.log(response)
        if (response.status === "error") {
          //Possible errors
          $('#submit-forgot-password').prop("disabled", false);
          if (response.type === "scratch-login" || response.type === "unknown-failure" || response.type === "invalid-username") {
            $("#username").addClass("is-invalid");
            $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="username"]');
          }
        }
        if (response.status === "success") {
          //Success, continue
          $('#forgot-password-form').fadeOut(fadeAnimationDuration, function () {
            $('#forgot-password-form').remove();
            verification_code = response.verification_code;
            $('<div id="verification-div"  style="display: none;"><p class="text-justify">To verify your identity, please login to your Scratch account, go to the verification project, comment the code below, and come back here!</p><p>Your verification code: <strong>' + verification_code + '</strong><button id="copy" class="btn ml-5" type="button">Copy</button></p><button id="verification-popup-button" class="btn btn-primary btn-block" type="button" disabled="disabled">Open verification project</button></div>').insertAfter('.modal-title');
            $('#verification-div').fadeIn(fadeAnimationDuration, function () {
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
                        "verification_code": response.verification_code,
                        "request": request
                      },
                      dataType: "json",
                      success: function (response) {
                        console.log(response);
                        if (response.return === "true") {
                          //Login user
                          $('#verification-popup-button').fadeOut(fadeAnimationDuration, function () {
                            $('#verification-popup-button').remove();
                            $('#verification-div').fadeOut(fadeAnimationDuration, function () {
                              $('#verification-div').remove();
                              $('<div id="change-pwd-div"  style="display: none;"><p class="text-justify">You can change your password below:</p><form id="change-pwd"> <div class="form-group"> <label for="password">Password</label> <input type="password" id="password" class="form-control" placeholder="Password"> </div> <div class="form-group"> <label for="repeat-password">Repeat password</label> <input type="password" id="password_repeat" class="form-control" placeholder="Repeat password"> </div> <input id="submit-change-pwd" class="btn btn-primary btn-block" type="submit" disabled="disabled" value="Change password"> </form></div>').insertAfter('.modal-title');
                              $('#change-pwd-div').fadeIn(fadeAnimationDuration, function () {
                                $('#submit-change-pwd').prop("disabled", false);
                                $('#submit-change-pwd').click(function (event) {
                                  event.preventDefault();
                                  $('input').removeClass(['is-invalid']);
                                  $('.invalid-feedback').remove();
                                  var password = $("#password").val();
                                  var password_repeat = $("#password_repeat").val();
                                  $('#submit-change-pwd').prop("disabled", true);
                                  request = "change-password";
                                  //alert('Username: ' + username + ' Password: ' + password + ' Password Repeat: ' + password_repeat)
                                  $.ajax({
                                    type: "POST",
                                    url: "handle-users.php",
                                    data: {
                                      "username": username,
                                      "password": password,
                                      "password-repeat": password_repeat,
                                      "request": request
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                      console.log(response);
                                      //Possible errors
                                      $('#submit-change-pwd').prop("disabled", false);
                                      if (response.status === "error") {
                                        if (response.type === "invalid-username") {
                                          alert(response.message);
                                        }
                                        if (response.type === "weak-password" || response.type === "password-mismatch") {
                                          $("#password").addClass("is-invalid");
                                          $("#password_repeat").addClass("is-invalid");
                                          $('<div class="invalid-feedback"><ul><li>' + response.message + '</li></ul></div>').insertAfter('label[for="password"]');
                                        }
                                      }
                                      //Success
                                      if(response.status === "success"){
                                        if(response.type === "pwd-changed"){
                                          $('#change-pwd-div').fadeOut(fadeAnimationDuration, function(){
                                            $('#change-pwd-div').remove();
                                            $('<div id="success-alert-changed-pwd" style="display: none;" class="alert alert-success" role="alert"> <h4 class="alert-heading">Password changed</h4> Your password was changed successfully! You may now <a href="login" class="alert-link">login</a> with your new password.</div>').insertAfter('.modal-title');
                                            $('#success-alert-changed-pwd').fadeIn(fadeAnimationDuration);
                                          })
                                        }
                                      }
                                    },
                                    error: function () {
                                      alert("UNKNOWN ERROR");
                                    }
                                  })
                                })
                              });
                            });

                            /*request = "scratch-login";
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
                                  window.location.replace("index");
                                }
                              },
                              error: function () {
                                alert("Error");
                              }
                            })*/
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
          window.location.replace("index");
        }
      },
      error: function () {
        alert("UNKNOWN ERROR");
      }
    });
  });
  $('#delete-account').click(function () {
    $('#delete-account').prop("disabled", true);
    $('#logout').prop("disabled", true);
    var confirmAccountDeletion = confirm("Are you sure you want to delete your account? This cannot be undone, and you will lose any data associayed with your account.");
    if (!confirmAccountDeletion) {
      $('#delete-account').prop("disabled", false);
      $('#logout').prop("disabled", false);
      return;
    }
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
          window.location.replace("index");
        }
      },
      error: function () {
        alert("UNKNOWN ERROR");
      }
    });
  });
  $(document).on("click", "#copy", function(){
    navigator.clipboard.writeText(verification_code).then(function() {
      //Clipboard successfully set
      $('#copy').prop("disabled", true);
      $('#copy').html("Copied!");
      window.setTimeout(function(){
        $('#copy').prop("disabled", false);
        $('#copy').html("Copy");
      }, 1000)
    }, function() {
      //Clipboard write failed
      alert("Failed to copy verification code. Check permissions!")
    });
  })
});
