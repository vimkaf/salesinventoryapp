<?php

use Phinx\Db\Action\Action;

class Dashboard extends Trongate
{

    /**
     * 1 => Admin
     * 2 => Manager
     * 3 => Sales
     * 4 => Cashier
     */
    protected array $adminOnly = [1];

    protected array $everyone = [1, 2, 3, 4, 5];

    protected array $adminAndManger = [1, 2];

    protected array $salesOnly = [3];

    protected array $managerOnly = [2];

    function __construct()
    {

        parent::__construct('dashboard');

        $this->module('trongate_tokens');

        $userID = $this->trongate_tokens->_get_user_id();

        if ($userID === false) {
            set_flashdata([
                'type' => 'error',
                'message' => 'Login is required'
            ]);
            redirect('login');
        }
    }

    function index()
    {
        $this->module('trongate_security');

        $token = $this->trongate_security->_make_sure_allowed('dashboard');

        $data['view_module'] = "dashboard";
        $data['view_file'] = "dashboard";
        $data['page_title'] = 'Home';


        $this->template('dashboard', $data);
    }

    function logout()
    {
        $this->module('trongate_tokens');

        $this->trongate_tokens->_destroy();

        redirect('login');
    }

    function _make_sure_allowed(int|array $userLevels = null)
    {
        $this->module('trongate_tokens');

        $token = $this->trongate_tokens->_attempt_get_valid_token($userLevels);

        if ($token === false) {
            set_flashdata([
                'type' => 'warning',
                'message' => 'You are not allowed to peform that action'
            ]);

            redirect('dashboard');
        } else {
            return $token;
        }
    }

    function products($action)
    {

        $id = segment(4);

        $this->module('products');

        switch ($action) {
            case "list":
            default:
                $this->_make_sure_allowed($this->everyone);
                $this->products->_list();
                break;

            case "add":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->_add();
                break;
            case "import":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->_import();
                break;
            case "barcode":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->barcode();
                break;
            case "edit":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->delete($id);
                break;

            case "categories":
                $this->_make_sure_allowed($this->everyone);
                $this->products->categories($id);
                break;
            case "add_category":
                $this->_make_sure_allowed($this->everyone);
                $this->products->add_category();
                break;
            case "edit_category":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->edit_category($id);
                break;
            case "delete_category":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->products->delete_category($id);
                break;
        }
    }

    function inventory($action)
    {

        $id = segment(4);

        $this->module('inventory');

        switch ($action) {
            case "add_stocks":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->add_stock();
                break;
            case "quantity":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->quantity();
                break;
            case "add_adjustments":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->add_adjustments();
                break;
            case "stock":
                $this->_make_sure_allowed($this->everyone);
                $this->inventory->stock();
                break;
            case "count":
                $this->_make_sure_allowed($this->everyone);
                $this->inventory->count();
                break;
        }
    }
    function sales($action, $id = null)
    {

        $this->module('sales');

        switch ($action) {
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
    function warehouse($action)
    {
        $id = segment(4);
        $product_name = segment(5);

        $this->module('warehouse');

        switch ($action) {
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
    function customer($action)
    {
        $id = segment(4);

        $this->module('customer');

        switch ($action) {
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->add();
                break;
            case "view":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->list();
                break;
            case "edit":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->everyone);
                $this->customer->delete($id);
                break;
        }
    }
    function employee($action)
    {
        $id = segment(4);

        $this->module('employee');

        switch ($action) {
            case "add":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->add();
                break;
            case "views":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->views();
                break;
            case "edit":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->everyone);
                $this->employee->delete($id);
                break;
        }
    }
}
