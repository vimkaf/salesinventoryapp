<?php

use Phinx\Db\Action\Action;

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

    function products($action){

        $id = segment(4);
        $product_name = segment(5);

        $this->module('products');

        switch($action){
            case "list":
                $this->_make_sure_allowed($this->everyone);
                $this->products->list();
                break;

            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->products->add();
                break;
            case "import":
                $this->_make_sure_allowed($this->everyone);
                $this->products->import();
                break;
            case "barcode":
                $this->_make_sure_allowed($this->everyone);
                $this->products->barcode();
                break;
            case "add_stocks":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->add_stock();
                break;
            case "quantity":
                $this->_make_sure_allowed($this->everyone);
                $this->products->quantity();
                break;
            case "add_adjustments":
                $this->_make_sure_allowed($this->everyone);
                $this->products->add_adjustments();
                break;
            case "stock":
                $this->_make_sure_allowed($this->everyone);
                $this->products->stock();
                break;
            case "count":
                $this->_make_sure_allowed($this->everyone);
                $this->products->count();
                break;               
            case "edit":
                $this->_make_sure_allowed($this->everyone);
                $this->products->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->everyone);
                $this->products->delete($id);
                break;
        }
    }
    function sales($action, $id=null){
        
        $this->module('sales');

        switch ($action){
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->add();
                break;
            case "list":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->list();
                break;
        }
    }
    function warehouse($action){
        $id = segment(4);
        $product_name = segment(5);

        $this->module('warehouse');

        switch ($action){
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->warehouse->add();
                break;
            case "list":
                $this->_make_sure_allowed($this->everyone);
                $this->warehouse->list();
                break;
            case "edit":
                $this->_make_sure_allowed($this->everyone);
                $this->warehouse->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->everyone);
                $this->warehouse->delete($id);
                break;
        }
    }
    function customer($action){
        
        $this->module('customer');

        switch ($action){
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->add();
                break;
            case "view":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->view();
                break;
        }
    }
    function employee($action){
        
        $this->module('employee');

        switch ($action){
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->add();
                break;
            case "views":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->views();
                break;
        }
    }

}