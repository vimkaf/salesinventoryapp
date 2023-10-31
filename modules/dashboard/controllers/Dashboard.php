<?php
class Dashboard extends Trongate{
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

    function addproduct(){
        $this->_make_sure_allowed([1,2]);

        echo "You are allowed to add a product";

    }

    function deleteproduct(){
        $this->_make_sure_allowed(1);

        echo "You are allowed to delete a product";

    }

    function products($action){

        $this->module('products');

        return match($action){
            'list' => $this->products->list()
        };

    }


}