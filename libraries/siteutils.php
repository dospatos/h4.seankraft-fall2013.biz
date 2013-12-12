<?php

class siteutils {
    /*-------------------------------------------------------------------------------------------------
    Class contains any utils that need to be globally available
    -------------------------------------------------------------------------------------------------*/

    //Remove HTML tags from text
    public static function clean_html($data) {

        if(is_array($data)){

            foreach($data as $k => $v){
                if(is_array($v)){
                    $data[$k] = strip_tags($v);
                } else {
                    $data[$k] = strip_tags($v);
                }
            }

        } else {
            $data = strip_tags($data);
        }

        return $data;
    }

    //Get the data for the user
    public static function getuserprofile($id) {
        $q = "SELECT U.user_id, U.first_name, U.last_name, U.email
        , J.job_title, A.account_name
            FROM users U
            INNER JOIN jobs J ON J.job_id = U.job_id
            INNER JOIN accounts A ON A.account_id = U.account_id
            WHERE U.user_id = ".$id;
        return DB::instance(DB_NAME)->select_row($q);
    }

    //For use on pages that don't need all functions secured, and hence to not inherit secure_controller
    public static function redirectnonloggedinuser($sessionuserobject) {
        if (!$sessionuserobject) {
            Router::redirect("/users/login/Not_logged_in");
        }
    }

    public static function Truncate($string, $length, $stopanywhere=false) {
        //truncates a string to a certain char length, stopping on a word if not specified otherwise.
        if (strlen($string) > $length) {
            //limit hit!
            $string = substr($string,0,($length -3));
            if ($stopanywhere) {
                //stop anywhere
                $string .= '...';
            } else{
                //stop on a word.
                $string = substr($string,0,strrpos($string,' ')).'...';
            }
        }
        return $string;
    }

    //Return all the users with the given account
    public static function getUsersWithAccount($account_id) {
        $q = "SELECT U1.user_id, U1.created, U1.modified, U1.last_login, U1.time_zone
        , U1.first_name, U1.last_name, U1.email, U1.job_id, U1.account_id, U1.is_admin
        FROM users U1 WHERE U1.account_id = ".$account_id;
        $users_list = DB::instance(DB_NAME)->select_rows($q);

        return $users_list;
    }

    //Return the job_id - adding a new title if required
    public static function getJobId($job_title, $account_id) {
        $q = "SELECT job_id FROM jobs WHERE job_title = '".trim($job_title)."' AND account_id = ".$account_id;
        $job_id = DB::instance(DB_NAME)->select_field($q);
        if(!$job_id) {//add the job
            $job_data = array();
            $job_data['account_id'] =$account_id;
            $job_data['department_name'] ='';
            $job_data['job_title'] =$job_title;
            $job_id = DB::instance(DB_NAME)->insert('jobs', $job_data);
        }
        return $job_id;
    }

    public static function createUser($account_id,$job_id,$first_name,$last_name,$email,$password,$is_admin,$token=null ) {
        $user_data = array();
        # More data we want stored with the user
        $user_data['created']  = Time::now();
        $user_data['modified'] = Time::now();
        $user_data['account_id'] = $account_id;
        $user_data['is_admin'] = $is_admin;
        $user_data['job_id'] = $job_id;
        $user_data['email'] = $email;
        $user_data['first_name'] = $first_name;
        $user_data['last_name'] = $last_name;

        # Encrypt the password
        $user_data['password'] = sha1(PASSWORD_SALT.$password);

        # Create an encrypted token via their email address and a random string
        if ($token == null) {
            $token = sha1(TOKEN_SALT.$email.Utils::generate_random_string());
        }
        $user_data['token'] = $token;

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $user_data);

    }


}

?>