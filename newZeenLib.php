<!-- 
newZeenLib.php

This file contains a library of functions used throughout the website
-->
<?php
/**
 *  emptyField - Checks if user tried to create account with an empty field in 
 *               the account creation form
 * 
 *              Returns false if no empty fields
 *              Returns true if a field is empty
 */
function emptyField($email, $user, $pass, $passRepeat, $first, $last, $address){
    $result = false;
    if(empty($email) || empty($user) || empty($pass) || empty($passRepeat) || empty($first) || empty($last) || empty($address)){
        $result = true;
    }
    return $result;
}
/**
 *  emptyLoginField - Checks if user left a login field blank
 * 
 *                    Returns false if all fields were filled
 *                    Returns true if a field was left blank
 */
function emptyLoginField($username, $password){
    $result = false;
    if (empty($username) || empty($password)){
        $result = true;
    }
    return $result;
}

/**
 *  invalidEmail - Checks if entered email is a valid email address
 * 
 *                 Returns false if email is valid
 *                 Returns true if the email entered is an invalid email address  
 */
function invalidEmail($email){
    $result = false;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    return $result;
}

/**
 *  invalidUsername - Checks if username contains only letters and numbers using regex
 * 
 *              Returns false if the username contains only letters and numbers
 *              Returns true if username contains characters outside of letters and numbers
 */
function invalidUsername($user){
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user)){
        $result = true;
    }
    return $result;
}

/**
 *  loginUser - Logs the user into the website
 * 
 *              Returns user to login screen with an error message if incorrect login
 *              Brings user to home page if log in was successful
 */
function loginUser($conn, $user, $password){
    
    $userExist = userExists($conn, $user, $user);
    if ($userExist === false){
        header("location: login.php?error=incorrectlogin");
        exit();
    }
    $pass = $userExist["password"];
    if($pass !== $password){
        header("location: login.php?error=incorrectlogin");
        exit();
    }
    else if ($pass == $password){
        session_start();
        $_SESSION["user_id"] = $userExist["user_id"];
        $_SESSION["fName"] = $userExist["first_name"];
        $_SESSION["username"] = $userExist["username"];
        header("location: index.php");
        exit();
    }
}

/**
 *  passwordInvalid - Checks if the entered password meets strength requirements using regex
 * 
 *                    Returns true if password doesn't contain at least 8 characters, 
 *                      1 uppercase letter, 1 lowercase letter, and one special character
 *                    Returns false if password meets requirements 
 */

function passwordInvalid($pass){
$result = false;

    $specialChar = preg_match('@[^\w]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    $lower = preg_match('@[a-z]@', $pass);
    $upper = preg_match('@[A-Z]@', $pass);

    if (!$upper || !$lower || !$number || !$specialChar || strlen($pass) < 8){
        $result = true;
    }
    return $result;
}

/**
 *  passwordMatch - Checks if the user entered the same password in each password field
 * 
 *                  Returns false if the passwords are matching
 *                  Returns true if the passwords do not match
 */
function passwordMatch($pass, $passRepeat){
    $result = false;
    if ($pass !== $passRepeat){
        $result = true;
    }
    return $result;
}

/**
 *  userExists - Checks if the username or email address is already tied to a user account
 *               Uses a prepared statement to query the database for associated row if username and email exist.
 *               This function is also used to get information to validate the user logging in
 *
 *               Returns false if the username and email do not exist in the database
 *               Returns true if the username or email already exist in the database
 */
function userExists($conn, $user, $email){
    $sql = "SELECT * FROM user WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: createAccount.php");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user, $email);
    mysqli_stmt_execute($stmt);

    //Pull user information from database
    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
    }

    mysqli_stmt_close($stmt);
    return $result;
}