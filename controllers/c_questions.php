<?php

class questions_controller extends secure_controller {

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



    } # End of index

    public function edit($test_id) {

        $this->template->content = View::instance('v_questions_edit');
        //Get the list of tests
        $q = "SELECT question_id, question_order, test_id, created_by_user_id, question_text, question_type_id, question_image
            , created, updated, all_or_none, deleted FROM questions WHERE test_id = ".$test_id;

        $question_list = DB::instance(DB_NAME)->select_rows($q);
        $this->template->content->question_list = $question_list;
        $this->template->content->test_id = $test_id;

        $this->template->content->question_types = $this->getQuestionTypes();

        # Now set the <title> tag
        $this->template->title = "Test Questions";

        # Render the view
        echo $this->template;


    } # End of edit

    //Get a single question and pass it back json style
    public function get($question_id) {
        $q = "SELECT question_id, question_order, test_id, created_by_user_id, question_text, question_type_id, question_image
            , created, updated, all_or_none, deleted FROM questions WHERE question_id = ".$question_id;

        $question = DB::instance(DB_NAME)->select_row($q);
        echo json_encode($question);
    }

    //Add a question and refresh the page
    public function p_create($test_id) {
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $errors = array();
        $data = ob_get_clean();
        //check that the question text is not blank
        if (!isset($_POST["question_text"])) {
            $errors[] = "Question text is not filled out - ";
        }

        if (count($errors)==0) {//no errors - go ahead
            # Insert this test into the database
            $question_order = $this->getNextQuestionOrder($test_id);
            $_POST["created"] = Time::now();
            $_POST["created_by_user_id"] = $this->user->user_id;
            $_POST["updated"] = Time::now();
            $_POST["test_id"] = $test_id;
            $_POST["question_order"] = $question_order;

            $question_id = DB::instance(DB_NAME)->insert('questions', $_POST);

            //send back the ID
            echo json_encode(array($question_id));
        } else {//there were errors
            echo json_encode(null);
        }
    } //end of question/p_create


    private function getQuestionTypes() {
        $q = "SELECT question_type_id,question_type_descr FROM question_types";
        return DB::instance(DB_NAME)->select_rows($q);
    }

    private function getNextQuestionOrder($test_id) {
        $q = "SELECT MAX(question_order) + 1 FROM questions WHERE test_id=".$test_id;
        return DB::instance(DB_NAME)->select_field($q);
    }


} # End of class
