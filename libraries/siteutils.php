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
        $q = "SELECT user_id, first_name, last_name, email, location, profile_text, avatar
        FROM users
        WHERE user_id  = " . $id;

        return DB::instance(DB_NAME)->select_row($q);
    }

    //returns true if the followed user is being followed by the other user
    public static function isuserbeingfollowed($followed_user_id, $user_id) {
        //figure out if we're already following the user
        $q = "SELECT 'Y' AS following FROM users_users WHERE user_id_followed=".$followed_user_id." AND user_id=".$user_id;
        $following = DB::instance(DB_NAME)->select_field($q);
        if ($following) {
            return true;
        }
        return false;
    }

    //For use on pages that don't need all functions secured, and hence to not inherit secure_controller
    public static function redirectnonloggedinuser($sessionuserobject) {
        if (!$sessionuserobject) {
            Router::redirect("/users/login/Not_logged_in");
        }
    }

    //Look through a post and save any hash tags that we don't have already
    public static function saveriverhashtags($post_text) {
        preg_match_all("/(#\w+)/", $post_text, $matches);
        $hashtags = false;
        $new_river_ids = "";
        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);

            foreach($hashtags as $tag) {
                //check if the river is in the database
                $tag =  str_ireplace("#", "", $tag);
                $q = "SELECT river_id FROM rivers WHERE river_name='".$tag."'";
                $river_id = DB::instance(DB_NAME)->select_field($q);

                if (!$river_id) {//add it if it's not in the DB
                    $river_id = DB::instance(DB_NAME)->insert("rivers", Array("river_name"=>$tag, "created"=>Time::Now(),"descr"=>"Created by a post"));
                    $new_river_ids = $new_river_ids.$river_id."_";
                }
            }
        }
        return $matches;
    }

    //look through the text and see if any tags match rivers we have in the database, update the text with links
    public static function linkriverhashtags($post_text) {
        preg_match_all("/(#\w+)/", $post_text, $matches);

        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);

            foreach($hashtags as $tag) {
                //check if the river is in the database
                $search_tag =  str_ireplace("#", "", $tag);
                $q = "SELECT river_id FROM rivers WHERE river_name='".$search_tag."'";
                $river_id = DB::instance(DB_NAME)->select_field($q);
                if (isset($river_id)) {
                    $link_text = "<a href='/rivers/edit/".$river_id."'>".$tag."</a>";

                    $post_text = str_replace($tag,$link_text,$post_text);
                }
            }
        }
        return $post_text;
    }

}

?>