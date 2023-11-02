<?php
class Dashboard extends Trongate{

    protected array $adminOnly = [1];
    protected array $everyone = [1,2,3,4,5];
    protected array $adminAndManger = [1,2,3];

    protected array $managerOnly = [2];

    function __construct(){

        parent::__construct('dashboard');

        $this->module('trongate_tokens');

        $userID = $this->trongate_tokens->_get_user_id();

        if($userID === false){
            set_flashdata([
                'type' => 'error',
                'message' => 'Login is required'
            ]);
            redirect('/login');
        }

    }

    function index(){
        $this->module('trongate_security');

        $token = $this->trongate_security->_make_sure_allowed('dashboard');

        $data['view_module'] = "dashboard";
        $data['view_file'] = "dashboard";
        $data['page_title'] = 'Home';


        $this->template('dashboard', $data);
    }

    function logout(){
        $this->module('trongate_tokens');

        $this->trongate_tokens->_destroy();

        redirect('/login');
    }

    function _make_sure_allowed(int|array $userLevels = null){
        $this->module('trongate_tokens');

        $token = $this->trongate_tokens->_attempt_get_valid_token($userLevels);

        if($token === false){
            set_flashdata([
                'type' => 'warning',
                'message' => 'You are not allowed to peform that action'
            ]);

            redirect('/dashboard');
        }
        else{
            return $token;
        }
    }

    function products($action, $id = null){

        $this->module('products');

        switch($action){
            case "list":
                $this->products->list();
                break;

            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->products->add();
                break;


        }
        

    }


}