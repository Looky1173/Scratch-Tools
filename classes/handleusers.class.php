<?php

class HandleUsers extends Db
{

    public function register($username, $password, $permission, $created, $modified, $status)
    {
        if ($this->checkUsernameAvailability($username) == false) {
            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $password = "";
            }
            $sql = "INSERT INTO accounts(username, password, permission, created, modified, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $password, $permission, $created, $modified, $status]);
            return true;
        } else {
            echo "USERNAME TAKEN!";
        }
    }
    public function login($username, $password)
    {
        $sql = "SELECT * FROM accounts WHERE username=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        //Return row as an array
        $returned_row = $stmt->fetch();
        //Check if row is actually returned
        if (is_array($returned_row)) {
            // Verify hashed password against entered password
            if (empty($returned_row['password'])) {
                return "scratch-login";
            } elseif (password_verify($password, $returned_row['password'])) {
                // Define session on successful login
                $_SESSION['id'] = $returned_row['id'];
                $_SESSION['username'] = $returned_row['username'];
                return true;
            } else {
                // Define failure
                return false;
            }
        } else {
            return "not found";
        }
    }
    public function checkLoginType($username)
    {
        $sql = "SELECT * FROM accounts WHERE username=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        //Return row as an array
        $returned_row = $stmt->fetch();
        //Check if row is actually returned
        if (is_array($returned_row)) {
            // Check whether Scratch or a password is used to log in
            if (empty($returned_row['password'])) {
                //Scratch is used to log in
                return "scratch-login";
            } else {
                //A password is used to log in
                return "pwd-login";
            }
        } else {
            return "not found";
        }
    }
    public function loginWithoutPassword($username)
    {
        if ($this->checkUsernameAvailability($username) == true) {
            $info = $this->getUserInformation($username, "");
            $_SESSION['id'] = $info["id"];
            $_SESSION['username'] = $info["username"];
            return array("success" => "true", "id" => $info["id"], "username" => $info["username"]);
        } else {
            // Define failure
            return array("success" => "false", "message" => "Failed to log in user.");
        }
    }
    public function isLoggedIn()
    {
        if (isset($_SESSION['id'])) {
            return true;
        } else {
            return false;
        }
    }
    public function logout()
    {
        // Destroy and unset active session
        session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        return true;
    }
    public function deleteUser($id)
    {
        $this->logout();
        $sql = "DELETE FROM accounts WHERE id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return true;
    }
    public function updateUser($username, $password, $permission, $created, $modified, $status, $id)
    {
        if (!empty($username)) {
            $userinfo = $this->getUserInformation($username, "");
        } else {
            if (!empty($id)) {
                $userinfo = $this->getUserInformation("", $id);
            } else {
                return "error";
            }
        }
        if (empty($username)) {
            $username = $userinfo["username"];
        }
        if (empty($id)) {
            $id = $userinfo["id"];
        }
        if (empty($permission)) {
            $permission = $userinfo["permission"];
        }
        if (empty($created)) {
            $created = $userinfo["created"];
        }
        if (empty($modified)) {
            $modified = $userinfo["modified"];
        }
        if (empty($status)) {
            $status = $userinfo["status"];
        }
        if (empty($password)) {
            return "missing password";
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE accounts SET username=?, password=?, permission=?, created=?, modified=?, status=? WHERE id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $password, $permission, $created, $modified, $status, $id]);
        return true;
    }
    public function getUserInformation($username, $id)
    {
        if (!empty($username) && empty($id)) {
            $sql = "SELECT * FROM accounts WHERE username=?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username]);
        } elseif (empty($username) && !empty($id)) {
            $sql = "SELECT * FROM accounts WHERE id=?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
        } else {
            return "error: two params specified";
        }
        //Return row as an array
        $returned_row = $stmt->fetch();
        //Check if row is actually returned
        if (is_array($returned_row)) {
            return array("id" => $returned_row['id'], "username" => $returned_row['username'], "created" => $returned_row['created'], "modified" => $returned_row['modified'], "permission" => $returned_row['permission'], "status" => $returned_row['status']);
        } else {
            return "not found";
        }
    }
    /*
The following function checks the avaibility of usernames.
It returns true if a username is taken and it returns false if not.
*/
    public function checkUsernameAvailability($username)
    {
        $sql = "SELECT * FROM accounts WHERE username=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        $check =  $stmt->fetch();
        if ($check) {
            //Username taken
            return true;
        } else {
            //Username avaible
            return false;
        }
    }
}
