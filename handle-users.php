<?php
session_start();

require_once ("includes/autoloader.inc.php");

$request = $_POST["request"];

$response = array("status" => "unprepared");

if($request == "register"){
    $ok = true;
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    //Check if a username was given
    if(!empty($username)){
        $handleUser = new HandleUsers;
        if($handleUser->checkUsernameAvailability($username) == false){
            //Username avaible, continue
            if($ok == true){
                $authentication = new AuthenticateWithScratch;
                $username_check = $authentication->checkValidScratchAccount($username);
                if($username_check == "valid username"){
                    $response = array("status" => "error", "type" => "username-not-registered", "message" => "The provided username is not yet registered on Scratch.");
                    $ok = false; 
                }
                if($username_check == "invalid username"){
                    $response = array("status" => "error", "type" => "username-invalid", "message" => "The provided username is invalid and not registered on Scratch.");
                    $ok = false;
                }
                if($username_check == "username exists"){
                    $ok = true;
                }
                if(!empty($password) && empty($password_repeat) || empty($password) && !empty($password_repeat)){
                    $response = array("status" => "error", "type" => "password-missing", "message" => "You must fill in both password fields if you have chosen to fill in one!");
                    $ok = false;
                }
                if(!empty($password) && !empty($password_repeat)){
                    if($password != $password_repeat){
                        $response = array("status" => "error", "type" => "password-mismatch", "message" => "The entered passwords do not match!");
                        $ok = false;
                    }elseif(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8){
                        $response = array("status" => "error", "type" => "weak-password", "message" => "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.");
                        $ok = false;
                    }
                }
                if($ok == true){
                    //Everything fine, continue
                    $code = $authentication->generateAuthenticationCode(32);
                    $response = array("status" => "success", "message" => $code, "username_check" => $username_check, "username" => $username, "password" => $password, "password-repeat" => $password_repeat, "request" => $request);
                }
                 
            }

        }else{
            //Username taken, throw error
            $response = array("status" => "error", "type" => "username-taken", "message" => "Sorry, this username is not avaible. Please try another!");
            $ok = false;
        }
    }else{
        //Missing username, throw error
        $response = array("status" => "error", "type" => "username-missing", "message" => "You must enter a username!");
        $ok = false;
    }
    //Encode JSON response
    echo json_encode($response);
}elseif($request == "verification"){
    $username = $_POST["username"];
    $verification_code = $_POST["verification_code"];
    $authentication = new AuthenticateWithScratch;
    $return = $authentication->authenticate($username, $verification_code);
    $response = array("username" => $username, "verification_code" => $verification_code, "return" => $return);
    echo json_encode($response);
}elseif($request == "register-final"){
    $register = new HandleUsers;
    $username = $_POST["username"];
    $password = $_POST["password"];
    $permission = 0;
    date_default_timezone_set("UTC");
    $created = date('Y-m-d H:i:s');
    $modified = date('Y-m-d H:i:s');
    $status = 'normal';

    //Register
    if($register->register($username, $password, $permission, $created, $modified, $status) == true){
        if(!empty($password)){
            //Login automatically
            if($register->login($username, $password) == true){
                //Successful login
                echo json_encode(["success" => "true"]);
            }else{
                //Login failed
                echo json_encode(["success" => "false", "message" => "Failed to log in user."]);
            }
        }else{
            //No password was entered, login manually
            echo json_encode($register->loginWithoutPassword($username));
        }
    }else{
        echo json_encode(["success" => "false", "message" => "Failed to create user."]);
    }
}elseif($request == "login"){
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    $verification_code;

    $login = new HandleUsers;
    if($login->checkUsernameAvailability($username) == true){
        $loginReturn = $login->login($username, $password);
        if((!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) && !empty($password)){
            if($loginReturn == "scratch-login"){
                $response = array("status" => "error", "type" => "user-without-password", "message" => "This account does not have a password associated with it."); 
            }else{
                $response = array("status" => "error", "type" => "weak-password", "message" => "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.");
            }
        }else{
            if($loginReturn === true){
                $response = array("status" => "success", "type" => "login", "message" => "Logged in.", "request" => $request, "loginReturn" => $loginReturn);
            }elseif($loginReturn == "scratch-login"){
                $scratch_login = new AuthenticateWithScratch;
                $verification_code = $scratch_login->generateAuthenticationCode(32);
                $response = array("status" => "success", "type" => "scratch-login", "message" => $verification_code, "loginReturn" => $loginReturn);
            }else{
                $response = array("status" => "error", "type" => "login-fail", "message" => "Failed to login in. Please double check your credentials and try again!", "loginReturn" => $loginReturn);
            }
        }
    }else{
        $response = array("status" => "error", "type" => "not-registered", "message" => "This username is not yet registered on Scratch Tools.");
    }
echo json_encode($response); 
}elseif($request == "scratch-login"){
    $username = $_POST['username'];

    $login = new HandleUsers;
    echo json_encode($login->loginWithoutPassword($username));

}elseif($request == "logout"){
    $logout = new HandleUsers;
    if($logout->logout() == true){
        $response = array("status" => "success");
    }else{
        $response = array("status" => "error");
    }
    echo json_encode($response);
}elseif($request == "delete-account"){
    $delete = new HandleUsers;
    if($delete->deleteUser($_SESSION['id']) == true){
        $response = array("status" => "success");
    }else{
        $response = array("status" => "error");
    }
    echo json_encode($response);
}

?>