<?php

class users_controller extends base_controller {

    /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
    }

    /*-------------------------------------------------------------------------------------------------
    Accessed via http://localhost/index/index/
    -------------------------------------------------------------------------------------------------*/
    public function index() {

        # Any method that loads a view will commonly start with this
        # First, set the content of the template with a view file
        $this->template->content = View::instance('v_users_index');

        # Now set the <title> tag
        $this->template->title = "Users";

        //if a user is active get a list of all the users
        if (isset($this->user)) {
            $q = "SELECT U.user_id, U.first_name, U.last_name, U.email, U.avatar, UF.user_id AS following_user_id
            FROM users U LEFT JOIN users_users UF ON UF.user_id_followed = U.user_id AND UF.user_id = ".$this->user->user_id." WHERE U.user_id <> ".$this->user->user_id;

            $users = DB::instance(DB_NAME)->select_rows($q);
            $this->template->content->users_list = $users;
        }

        # Render the view
        echo $this->template;

    } # End of method

    public function profileedit($id = null) {
        siteutils::redirectnonloggedinuser($this->user);
        if ((isset($id)) && ($this->user->user_id == $id)) { //users can only edit their own profile
            $id = DB::instance(DB_NAME)->sanitize($id);
        } else {
            $id = $this->user->user_id;
        }

        $currentuser = siteutils::getuserprofile($id);

        $this->template->content = View::instance('v_users_profile');
        $this->template->content->currentuser = $currentuser;
        echo $this->template;

    }
    /*
     Do the update for the profile
        1. users can only edit their own profile
     */
    public function p_profileedit($id) {
        siteutils::redirectnonloggedinuser($this->user);
        if (!$this->user->user_id == $id) { //users can only edit their own profile
            $id = DB::instance(DB_NAME)->sanitize($id);
        } else {
            $id = $this->user->user_id;
        }

        //see if there is an image to update
        $avatar_file_name = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['size'] > 0) {
            //use the upload library to save the file and resize it
            $upload_dir = "/uploads/avatars/";
            $avatar_file_name = Upload::upload($_FILES, $upload_dir, array("jpg", "jpeg", "gif", "png"), $id);
            if ($avatar_file_name) {
                $img = new Image();
                $img->open_image($avatar_file_name);
                $img->resize(600, 600, "crop");
                $img->save_image($avatar_file_name);
                $_POST["avatar"] = $avatar_file_name;
            }
        }

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = siteutils::clean_html(DB::instance(DB_NAME)->sanitize($_POST));

        # update the database
        $_POST['modified'] = Time::now();
        $returned_id = DB::instance(DB_NAME)->update('users', $_POST, 'where user_id ='.$id);

        if ($returned_id) {
            Router::redirect("/users/profileedit/".$id."?updated=true");
        } else {}

    }


    /*
     * Provide a read only view of the profile
     */
    public function profileview($id = null) {
        siteutils::redirectnonloggedinuser($this->user);
        if ((isset($id))) { //if ID is null show the user their own profile
            $id = DB::instance(DB_NAME)->sanitize($id);
        } else {
            router::redirect("/users/profileedit");
        }

        $currentuser = siteutils::getuserprofile($id);
        $this->template->content = View::instance('v_profile_view');
        $this->template->content->currentuser = $currentuser;

        $this->template->content->following = siteutils::isuserbeingfollowed($id, $this->user->user_id);

        echo $this->template;

    }

    /*
     * Let the user login
     */
    public function login($error = NULL , $new_user = false) {
        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";
        $this->template->content->error = $error;
        $this->template->content->new_user = isset($_GET['new_user']) ? $_GET['new_user'] : '';
        # Render template
        echo $this->template;
    }

    /*
     * Do the login for the user, update the last_login
     */
    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token, user_id
        FROM users
        WHERE email = '".$_POST['email']."'
        AND password = '".$_POST['password']."'";

        $return_row = DB::instance(DB_NAME)->select_row($q);
        $token = $return_row["token"];

        # If we didn't get a token back, it means login failed
        if(!$token) {

            # Send them back to the login page
            Router::redirect("/users/login/Username_or_password_wrong");


        } else {# But if we did, login succeeded!
            //update the user's last login
            $user_id = $return_row["user_id"];
            $user_update = Array("user_id"=>$user_id, "last_login"=>Time::Now());
            DB::instance(DB_NAME)->update("users", $user_update, "WHERE user_id = ".$user_id);

            //Store this token in a cookie using setcookie()
            setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the main page
            Router::redirect("/");

        }

    }

    /*
     * Allow a user to signup for the site
     */
    public function signup() {
        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title   = "Sign Up";

        $this->template->content->first_name = "";
        $this->template->content->last_name = "";
        $this->template->content->email = "";

        # Render template
        echo $this->template;
    }

    public function p_signup() {
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        //Find out if the email is already taken because this is the username
        $q = "SELECT user_id FROM users WHERE email = '".str_replace(" ","", $_POST["email"])."'";
        $existing_user_id = DB::instance(DB_NAME)->select_field($q);

        if (!$existing_user_id) {
            # More data we want stored with the user
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            # Encrypt the password
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

            # Create an encrypted token via their email address and a random string
            $token = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
            $_POST['token'] = $token;

            # Insert this user into the database
            $user_id = DB::instance(DB_NAME)->insert('users', $_POST);
            //Store this token in a cookie now so that they appear as logged in, also so we can create the user to create the avatar
            setcookie("token", $token, strtotime('+1 year'), '/');

            //wake up the user in order to create an avatar for them
            $newuser = new User();
            $newuser->authenticate();
            $newuser->create_initial_avatar($user_id);

            # For now, just confirm they've signed up -
            # You should eventually make a proper View for this
            Router::redirect("/users/");
        } else {
            $this->signup(true);
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";
            $this->template->content->duplicate_username = true;

            $this->template->content->first_name = $_POST["first_name"];
            $this->template->content->last_name = $_POST["last_name"];
            $this->template->content->email = $_POST["email"];

        }
    }

    public function logout() {
        siteutils::redirectnonloggedinuser($this->user);
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


} # End of class
