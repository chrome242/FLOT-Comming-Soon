<?php
require_once(AUTHENTICATION."auth.db_con.php");

/**
 * A function to start a secure PHP session. This is pulled off the wikiHow article
 * on the topic. Has no args, no return.
 */
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: /Login/error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

/**
 * A function to check the login params vrs the mysql db.
 * checks for brute force attacks using checkbrute
 *
 * @param str $email the user's email
 * @param str $password the user's password
 * @param obj $mysqli_sec the $mysqli_sec connection object.
 *
 * @return bool true if login is good, false if login is not good.
 */
function login($email, $password, $mysqli_sec) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli_sec->prepare("SELECT id, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli_sec) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli_sec->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

/**
 * A function to securely access the mySQL db and check if there have been more
 * then 10 failed login attepts in the last 2 hours.
 *
 * @param str $user_id the id of the user
 * @param obj $mysqli_sec the mySQLi object
 *
 * @return bool true if there has been a bruteforce violation, false otherwise.
 */
function checkbrute($user_id, $mysqli_sec) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli_sec->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 10 failed logins 
        if ($stmt->num_rows > 10) {
            return true;
        } else {
            return false;
        }
    }
}


/**
 * Checks that the minimal login params are set. This doesn't check for page rights,
 * only login status correctness. Helps to prevent xss
 *
 * @param obj $mysqli_sec the mysql object
 *
 * @return bool true if logged in, false otherwise.
 */
function login_check($mysqli_sec) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        
        if ($stmt = $mysqli_sec->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
      // Not logged in
      return false;
    }
 
  return false;
}

/**
 * Checks that permission params are set. Returns the params if set, otherwise
 * returns false
 *
 * @session the array to check
 * @param obj $mysqli_sec the mysql object
 *
 * @return mixed array if logged in, false otherwise.
 */
function permissions_check($session, $mysqli_sec){
  
  // NUKE //
  echo"This is the internal session check<pre>";
  var_dump($session);
  echo("User id:" . isset($session['user_id']));
  echo("LoginString:" .isset($session['login_string']));
  echo"</pre>";
  // END NUKE //
  
  if (isset($session['user_id'], $session['login_string'])){
    $user_id = $session['user_id'];
    
    // NUKE //
    echo "inside of permssions check if 1";
    // END NUKE
    
    if ($stmt = $mysqli_sec->prepare("SELECT user_groups FROM members 
                                      WHERE id = ? LIMIT 1")) {
      
        // NUKE //
      echo " inside of permssions check if 2";
      // END NUKE
      
      $stmt->bind_param('i', $user_id);
      $stmt->execute();   // Execute the prepared query.
      $stmt->store_result();
      
      
      if ($stmt->num_rows == 1){
       $stmt->bind_result($group);
       $stmt->fetch();
       
       if ($stmt = $mysqli_sec->prepare("SELECT inventory, drinks, extras, food,
                                        add_user, edit_user FROM user_groups 
                                         WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $group);
        $stmt->execute();   // Execute the prepared query.
        $permissions = array();
        $stmt->bind_result($permissions['inventory'], $permissions['drinks'],
                            $permissions['extras'], $permissions['food'],
                            $permissions['add_user'], $permissions['edit_user']);
        $stmt->fetch();
        echo "Have permissions";
        return $permissions;

       } else{
          // session issue / not logged in
          return false;
       }
      } else {
        // session issue / not logged in
        return false;
      }
    } else {
      // session issue / not logged in
      return false;
    }
  } else {
    // session issue / not logged in
    return false;
  }
}


/**
 * A helper function to sanatize the url 
 */
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}


