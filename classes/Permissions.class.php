<?php

class Permissions
{

    // Define database connection variable
    private $conn;

    public function __construct($db)
    {
        // Database connection
        $this->conn = $db;
    }

    public function getRoleByUsername($username)
    {
        // This function gets the role of a user
        $sql = "SELECT * FROM accounts WHERE username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        //Return row as an array
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            // Return the role of the user
            return $returned_row['role'];
        } else {
            // User not found or user does not have a role
            return false;
        }
    }
    public function getRoleNameById($role_id)
    {
        // This function gets the role of a user
        $sql = "SELECT * FROM roles WHERE role_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role_id]);
        //Return row as an array
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            // Return the role of the user
            return $returned_row['role_name'];
        } else {
            // User not found or user does not have a role
            return false;
        }
    }
    public function getRoleIdByName($role_name)
    {
        // This function gets the role of a user
        $sql = "SELECT * FROM roles WHERE role_name=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role_name]);
        //Return row as an array
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            // Return the role of the user
            return $returned_row['role_id'];
        } else {
            // User not found or user does not have a role
            return false;
        }
    }
    public function getPermissionsByRole($role)
    {
        // This function gets all the permissions associated with a role
        $sql = "SELECT permission_id FROM roles_permissions WHERE role_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role]);
        // Fetch column as an array
        $returned_row = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (is_array($returned_row)) {
            return $returned_row;
        } else {
            return false;
        }
    }
    public function getPermissionById($perm_id)
    {
        $sql = "SELECT * FROM permissions WHERE permission_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$perm_id]);
        // Fetch row as an array
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            return $returned_row['permission_desc'];
        } else {
            return false;
        }
    }
    public function getPermissionByDesc($perm_desc)
    {
        $sql = "SELECT * FROM permissions WHERE permission_desc=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$perm_desc]);
        // Fetch row as an array
        $returned_row = $stmt->fetch();
        if (is_array($returned_row)) {
            return $returned_row['permission_id'];
        } else {
            return false;
        }
    }
    public function validatePermission($username, $perm_ids)
    {
        // This method checks whether a user has sufficient permissions

        // Gets the role of the user
        $role = $this->getRoleByUsername($username);
        // Gets the permissions of the user based on his/her role
        $haystack = $this->getPermissionsByRole($role);
        // Compares the actual permissions with the expected permissions
        foreach($perm_ids as $value){
            if(in_array($value, $haystack) !== true){
                // The user does not have sufficient permissions
                return false;
            }
        }
        // The user has sufficient permissions
        return true;
    }
}
