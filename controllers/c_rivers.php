<?php

class rivers_controller extends secure_controller {

    /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
        //put code here to restrict to logged in users
    }

    /*-------------------------------------------------------------------------------------------------
    Accessed via http://localhost/posts/index
    Show a list of the latest posts
    -------------------------------------------------------------------------------------------------*/
    public function index() {
        # Any method that loads a view will commonly start with this
        # First, set the content of the template with a view file
        $this->template->content = View::instance('v_rivers_index');

        $q = "SELECT  river_id, river_name, river_class, descr, gps_coordinates_putin, gps_coordinates_takeout, aw_river_id
        FROM rivers ORDER BY river_name ASC";
        $rivers = DB::instance(DB_NAME)->select_rows($q);
        $this->template->content->river_list = $rivers;

        # Now set the <title> tag
        $this->template->title = "Rivers";

        # Render the view
        echo $this->template;
    } # End of method

    public function edit($id) {
        # Any method that loads a view will commonly start with this
        # First, set the content of the template with a view file
        $this->template->content = View::instance('v_river_edit');

        $q = "SELECT  river_id, river_name, river_class, descr, gps_coordinates_putin, gps_coordinates_takeout, aw_river_id
        FROM rivers WHERE river_id=".$id;
        $river = DB::instance(DB_NAME)->select_row($q);
        $this->template->content->currentriver = $river;

        # Now set the <title> tag
        $this->template->title = "Rivers";

        # Render the view
        echo $this->template;

    }

    public function p_riversave ($id) {
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $_POST = siteutils::clean_html($_POST);

        # Save the river
        $_POST['modified'] = Time::now();
        $_POST['river_id'] = $id;

        $returned_id = DB::instance(DB_NAME)->update('rivers', $_POST, " WHERE river_id = ".$id);

        if(!$returned_id) {

        } else {
            Router::redirect("/rivers/edit/".$id."?updated=true");
        }

    }

    public function delete ($post_id) {
        echo "this is the delete";
    }


} # End of class
