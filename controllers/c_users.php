<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function signup($error = null) {

        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Pass data to the view
            $this->template->content->error = $error;

        # Render template
            echo $this->template;

    }

    public function p_signup() {

        # Validate email is not already in the database
        $q = "SELECT email
            FROM users
            WHERE email = '".$_POST['email']."'";

        $newEmail = DB::instance(DB_NAME)->select_field($q);

        if ($newEmail != null) {
            Router::redirect("/users/signup/error");
        }

        #If  email is not in database, create account and log in user
        else {
            # More data we want stored with the user
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            # Encrypt the password  
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

            # Create an encrypted token via their email address and a random string
            $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 
            $token = $_POST['token'];

            # Insert this user into the database 
            $user_id = DB::instance(DB_NAME)->insert("users", $_POST);

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the main page - or whever you want them to go
            Router::redirect("/");
        }

    }

    public function login($error = NULL) {

        # Set up the view
        $this->template->content = View::instance("v_users_login");
        $this->template->title   = "Log In";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render the view
        echo $this->template;

    }

    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
            FROM users 
            WHERE email = '".$_POST['email']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);

        # Login failed
        if(!$token) {
            # Note the addition of the parameter "error"
            Router::redirect("/users/login/error");

        # But if we did, login succeeded! 
        } else {

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the home page
            Router::redirect("/");
        }
    }

    public function preferences() {

        # If user is blank, they're not logged in; redirect them to the login page
        if(!$this->user) {
            Router::redirect('/users/login');
        }

        # If they weren't redirected away, continue:

        # Set up the view
        $this->template->content = View::instance("v_users_preferences");
        $this->template->title   = "Preferences";

        # Query
        $q = 'SELECT * FROM preferences WHERE preferences.user_id = '.$this->user->user_id;

        # Run the query, store the results in the variable $preferenceList
        $preferenceList = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the view
        $this->template->content->preferences = $preferenceList;

        # Render the view
        echo $this->template;
    }

    public function p_preferences_delete() {

        # Delete trip idea from database
        $condition = "WHERE preference_id = ".$_POST['preference_id'];
        DB::instance(DB_NAME)->delete('preferences', $condition);

        # Reload preferences to show that trip idea has been deleted
        Router::redirect("/users/preferences");
    }

    public function save_preferences_via_ajax () {
      //  echo $_POST['airport'];

        # Store additional data with the preference
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();
        $_POST['user_id'] = $this->user->user_id;

        # Set empty strings to NULL
        if ($_POST['month'] == '') {
            $_POST['month'] = NULL;
        }

        if ($_POST['year'] == '') {
            $_POST['year'] = 'NULL';
        }

        if ($_POST['region'] == '') {
            $_POST['region'] = NULL;
        }

        if ($_POST['max_price'] == '') {
            $_POST['max_price'] = 'NULL';
        }

        # Insert this prefrence into the database
        # (Using SQL instead of core framework's built in functions to allow insertion of NULL values)
        $sql = 'INSERT INTO preferences (user_id, created, modified, airport, month, year, region, max_price) 
            VALUES ('.$_POST['user_id'].', '.$_POST['created'].', '.$_POST['modified'].', "'.$_POST['airport'].'", "'
            .$_POST['month'].'", '.$_POST['year'].', "'.$_POST['region'].'", '.$_POST['max_price'].')';
        DB::instance(DB_NAME)->select_rows($sql);

        echo "success";

    }

    public function logout() {

        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    }


} # end of the class
