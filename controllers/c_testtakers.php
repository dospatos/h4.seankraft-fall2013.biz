<?php

class testtakers_controller extends secure_controller {

    /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
    }

    /*-------------------------------------------------------------------------------------------------
    Accessed via http://localhost/tests/index/
    - Show a list of the test takers with a link to edit them, don't show the current user
    -------------------------------------------------------------------------------------------------*/
    public function index() {
        $user_list = siteutils::getUsersWithAccount($this->user->account_id);

        $this->template->content = View::instance('v_testtakers_index');
        $this->template->content->user_list = $user_list;

        # Now set the <title> tag
        $this->template->title = "Test Takers";

        # Render the view
        echo $this->template;


    } # End of index

    //Allow the user to upload a file full of test takers
    public function upload() {

        $this->template->content = View::instance('v_testtakers_upload');

        # Now set the <title> tag
        $this->template->title = "Upload Test Takers";

        # Render the view
        echo $this->template;


    } # End of edit

    //Suck in the file of test takers and create users
    public function p_upload() {
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);



    } # End of edit



} # End of class
