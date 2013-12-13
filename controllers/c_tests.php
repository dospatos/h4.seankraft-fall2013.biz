<?php

class tests_controller extends secure_controller {

    /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
    }

    /*-------------------------------------------------------------------------------------------------
    Accessed via http://localhost/tests/index/
    - Show the user a list of tests for the account
    -------------------------------------------------------------------------------------------------*/
    public function index() {
        $this->template->content = View::instance('v_tests_index');
        //Get the list of tests
        $q = "SELECT test_id,test_name,test_descr, test_category, created_on_dt, test_year FROM tests WHERE account_id = ".$this->user->account_id;
        $test_list = DB::instance(DB_NAME)->select_rows($q);
        $this->template->content->test_list = $test_list;

        # Now set the <title> tag
        $this->template->title = "Tests";

        # Render the view
        echo $this->template;

    } # End of index

    //Display enough fields to allow the user to create a test
    public function create() {
        $this->template->content = View::instance('v_tests_create');
        # Now set the <title> tag
        $this->template->title = "Create Test";

        $this->template->content->test_name = "";
        $this->template->content->test_descr = "";
        $this->template->content->test_category = "";

        # Render the view
        echo $this->template;

    } # End of create

    public function p_create() {

        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $errors = array();
        $data = ob_get_clean();
        //check that the test does not yet exist
        $existing_test_id = $this->getExistingTestId(trim($_POST["test_name"]));

        if ($existing_test_id) {$errors[] = "The test named, ".$test_name.", already exists";}

        if (count($errors)==0) {//no errors - go ahead
            # Insert this test into the database
            $_POST["test_year"] = date("Y"); //the current year
            $_POST["account_id"] = $this->user->account_id;
            $_POST["created_by_user_id"] = $this->user->user_id;
            $_POST["created_on_dt"] = Time::now();
            $_POST["last_updated_dt"] = Time::now();
            $_POST["passing_grade"] = 100;
            $_POST["minutes_to_complete"] = 0;

            $test_id = DB::instance(DB_NAME)->insert('tests', $_POST);

            Router::redirect("/tests");

        } else {//there were errors
            $this->template->content = View::instance('v_tests_create');
            $this->template->title   = "Create Test";
            $this->template->content->errors = $errors;

            $this->template->content->test_name = $_POST["test_name"];
            $this->template->content->test_descr = $_POST["test_descr"];
            $this->template->content->test_category = $_POST["test_category"];

            echo $this->template;

        }

    } # End of p_create

    //display an editable test with its answers and materials
    public function edit($test_id) {

        $this->template->content = View::instance('v_tests_edit');
        # Now set the <title> tag
        $this->template->title = "Edit Test";

        $return_row = $this->getExistingTest($test_id);

        if ($return_row) {
            $this->template->content->test_id = $return_row["test_id"];
            $this->template->content->test_name = $return_row["test_name"];
            $this->template->content->test_descr = $return_row["test_descr"];
            $this->template->content->test_category = $return_row["test_category"];
            $this->template->content->test_year = $return_row["test_year"];
            $this->template->content->passing_grade=$return_row["passing_grade"];
            $this->template->content->created_on_dt =$return_row["created_on_dt"];
            $this->template->content->minutes_to_complete = $return_row["minutes_to_complete"];

            //setup the questions
            $this->setupTestQuestionsForDisplay($this->template, $test_id);

            //setup the assignments
            $this->template->content->test_assign_status = siteutils::getTestAssignStatus($test_id);
        } else {
            Router::redirect("/error/generic");
        }

        # Render the view
        echo $this->template;
    } # End of edit

    //set the assignments for a test
    public function p_assign($test_id) {
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        //echo var_dump($_POST);
        $errors = array();
        //For any assignment to this test that is in assigned state - delete it
        $q = "DELETE FROM test_assign_user WHERE test_assign_status_id = 1 AND test_id=.".$test_id;
        DB::instance(DB_NAME)->query($q);

        //Find the passed in checkboxes (these are selected by the user)
        foreach($_POST as $key => $value) {
            if (strpos($key, 'chk_') === 0) {//we have a checkbox
                if (is_numeric($value)) {//this value should be the user_id
                    //Get the status of any existing assignment
                    $user_assign_status = siteutils::getTestAssignStatus($test_id, $value);
                    $test_assign_status_id = $user_assign_status[0]["test_assign_status_id"];

                    if (!isset($test_assign_status_id)) {//there is no assignment
                        //insert a new assignment
                        $due_on_date = "txt_due_".$value;
                        $due_on_date = $_POST[$due_on_date];
                        $due_on_date = strtotime($due_on_date);
                        $assign_test = ["assigned_by_user_id" => $this->user->user_id,
                            "assigned_on_dt" => Time::now(),
                            "due_on_dt" => $due_on_date,
                            "test_assign_status_id" => "1",
                            "test_id" => $test_id,
                            "user_id" => $value
                        ];

                        $test_assign_id = DB::instance(DB_NAME)->insert('test_assign_user', $assign_test);
                    }
                } else {
                    $errors[] = "Invalid values posted";
                }
            }
        }
        Router::redirect("/tests/edit/".$test_id);

    }// end p_assign

    //Get the assignment record with some details about the test and display it to the user
    public function assignment($test_assign_id) {
        $errors = array();
        $test_assign_id =  DB::instance(DB_NAME)->sanitize($test_assign_id);

        //Setup the view
        $this->template->content = View::instance('v_test_assign_details');

        if (!is_numeric($test_assign_id)) {
            $errors[] = "Invalid assignment";
        }
        if (count($errors) == 0) {
            $assign_details = siteutils::getTestAssignmentDetails($test_assign_id);
            $this->template->content->assign_details = $assign_details;
        }

        # Now set the <title> tag
        $this->template->title = "Test Assignment";
        $this->template->content->errors = $errors;

        # Render the view
        echo $this->template;

    }//end of assignment

    //Get the test and allow the user to answer the questions
    public function take($test_assign_id, $test_instance_id = null, $question_id = null) {
        $errors = array();
        $test_assign_id =  DB::instance(DB_NAME)->sanitize($test_assign_id);
        $test_instance_id = DB::instance(DB_NAME)->sanitize($test_instance_id);
        $question_id = DB::instance(DB_NAME)->sanitize($question_id);
        if (!is_numeric($test_assign_id)) {$errors[] = "Invalid assignment";}
        if ($test_instance_id != null && !is_numeric($test_instance_id)) {$errors[] = "Invalid test";}
        if ($question_id != null && !is_numeric($question_id)) {$errors[] = "Invalid question";}

        //If there is no test instance for this assignment we need to create one

        //Setup the view
        $this->template->content = View::instance('v_test_take_question');

        if (count($errors) == 0) {
            $assign_details = siteutils::getQuestionDetails($test_instance_id, $question_id);
            $this->template->content->assign_details = $assign_details;
        }

        # Now set the <title> tag
        $this->template->title = "Test Assignment";
        $this->template->content->errors = $errors;

        # Render the view
        echo $this->template;

    }//end of take

    //Make the changes required to the test and re-direct to the edit screen again
    public function p_edit($test_id) {
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $errors = array();
        $data = ob_get_clean();
        //check if the test exists
        $test_name = trim($_POST["test_name"]);
        $existing_test_id = $this->getExistingTestId(trim($test_name));
        //echo '|'.$existing_test_id.'|';
        if (($existing_test_id != null) && ($existing_test_id != $test_id)) {$errors[] = "The test named, ".$test_name.", already exists";}

        if (count($errors)==0) {//no errors - go ahead
            # update the test
            $_POST["last_updated_dt"] = Time::now();
            DB::instance(DB_NAME)->update('tests', $_POST, " WHERE test_id =".$test_id);

            Router::redirect("/tests/edit/".$test_id);

        } else {//there were errors
            $this->template->content = View::instance('v_tests_edit');
            $this->template->title   = "Edit Test";
            $this->template->content->errors = $errors;

            $this->template->content->test_id = $_POST["test_id"];
            $this->template->content->test_name = $_POST["test_name"];
            $this->template->content->test_descr = $_POST["test_descr"];
            $this->template->content->test_category = $_POST["test_category"];
            $this->template->content->test_year = $_POST["test_year"];
            $this->template->content->passing_grade=$_POST["passing_grade"];
            $this->template->content->minutes_to_complete = $_POST["minutes_to_complete"];

            $this->setupTestQuestionsForDisplay($this->template, $test_id);
            echo $this->template;

        }

    } # End of p_edit



    //Get the ID for an existing test with the given name
    private function getExistingTestId($test_name) {
        $q = "SELECT test_id FROM tests WHERE deleted = 0 AND test_name = '".$test_name."' AND account_id = ".$this->user->account_id;
        $existing_test_id = DB::instance(DB_NAME)->select_field($q);
        return $existing_test_id;
    }

    //Get the details for a specific test
    private function getExistingTest($test_id) {
        $q = "SELECT test_id, account_id, copied_from_test_id, test_name, test_descr, public,
        test_year, created_by_user_id, created_on_dt, last_updated_dt, minutes_to_complete
        , passing_grade, deleted, deleted_date, test_category FROM tests WHERE deleted = 0 AND test_id = ".$test_id;
        return DB::instance(DB_NAME)->select_row($q);
    }

    private function setupTestQuestionsForDisplay($template_instance, $test_id) {
        //setup the questions
        $q = "SELECT question_id, question_order, test_id, created_by_user_id, question_text, question_type_id, question_image
            , created, updated, all_or_none, deleted FROM questions WHERE test_id = ".$test_id;

        $question_list = DB::instance(DB_NAME)->select_rows($q);

        $template_instance->content->question_list = $question_list;
        $template_instance->content->question_types = questions_controller::getQuestionTypes();
    }



} # End of class
