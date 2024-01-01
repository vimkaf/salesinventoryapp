<?php

use Phinx\Db\Action\Action;

class Dashboard extends Trongate
{

    /**
     * 1 => Admin
     * 2 => Manager
     * 3 => Sales
     * 4 => Cashier
     **/

    protected array $adminOnly = [1];

    protected array $everyone = [1, 2, 3, 4, 5];

    protected array $adminAndManger = [1, 2];

    protected array $adminManagerSales = [1, 2, 3];

    protected array $adminAndSales = [1, 3];

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


        $product = $this->model->query('SELECT COUNT(product_id) AS count FROM products', 'object')[0];

        $todayDate = date("Y-m-d");

        $this->module('warehouse');

        $warehouses = $this->warehouse->employees_warehouses();

        $warehouseIDs = array_map(fn($warehouse) => $warehouse->warehouse_id, $warehouses);

        $warehouseIDs = implode(",", $warehouseIDs);

        $todaySales = $this->model->query("SELECT SUM(grand_total) AS total FROM sales WHERE date_of_sale = '$todayDate' AND warehouse_id IN ($warehouseIDs) ", 'object')[0];

        $employees = $this->model->query("SELECT COUNT(employee_id) AS count FROM employees WHERE warehouse_id IN ($warehouseIDs)", 'object')[0];

        $data['productCount'] = $product->count ?? 0;
        $data['todaySale'] = $todaySales->total ?? 0;
        $data['employeeCount'] = $employees->count ?? 0;

        $query = "
        SELECT
            *
        FROM
            inventory
            LEFT JOIN products ON inventory.product_id = products.product_id
            LEFT JOIN warehouses ON inventory.warehouse_id = warehouses.warehouse_id
        WHERE
            inventory.warehouse_id IN ($warehouseIDs)
            AND 
            quantity_on_hand <= reorder_level
        ";

        $lowinventory = $this->model->query($query, "object");

        $data['lowinventory'] = $lowinventory;

        $data['view_module'] = "dashboard";
        $data['view_file'] = "dashboard";
        $data['page_title'] = 'Home';
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);



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

            $url = !empty(previous_url()) ? previous_url() : 'dashboard';

            redirect($url);
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
            case "stocks":
            default:
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->stocks();
                break;
            case "filter_stocks":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->filter_stocks();
                break;
            case "add_stocks":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->add_stock();
                break;
            case "adjustments":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->adjustments();
                break;
            case "add_adjustments":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->add_adjustments();
                break;

            case "filter_adjustments":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->filter_adjustments();
                break;
            case "stock_count":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->stock_count();
                break;
            case "download_stock_count":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->download_stock_count($id);
                break;
            case "delete_stock_count":
                $this->_make_sure_allowed($this->adminOnly);
                $this->inventory->delete_stock_count($id);
                break;
            case "count_stock":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->inventory->count_stock();
                break;
        }
    }
    function sales($action, $id = null)
    {
        $id = segment(4);

        $this->module('sales');

        switch ($action) {
            case "pos":
                $this->_make_sure_allowed($this->salesOnly);
                $this->sales->dashboard();
                break;
            case "pos_report":
                $this->_make_sure_allowed($this->salesOnly);
                $this->sales->pos_report();
                break;

            case "filter_pos_report":
                $this->_make_sure_allowed($this->salesOnly);
                $this->sales->_filter_pos_report();
                break;
            case "add":
                $this->_make_sure_allowed($this->adminManagerSales);
                $this->sales->add();
                break;
            case "add_customer":
                $this->_make_sure_allowed($this->adminAndSales);
                $this->sales->_add_customer();
                break;
            case "add_payment":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->add_payment();
                break;
            case "list":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->list();
                break;
            case "items":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->_fetch_sale_items();
                break;
            case "filter_sales":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->filter_sales();
                break;

            case "receipts":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->receipts($id);
                break;

            case "checkinventory":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->_checkinventory();
                break;
            case "receipt":
                $this->_make_sure_allowed($this->everyone);
                $this->sales->receipt($id);
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
                $this->_make_sure_allowed($this->adminAndManger);
                $this->employee->add();
                break;
            case "views":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->employee->views();
                break;
            case "edit":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->employee->edit($id);
                break;
            case "delete":
                $this->_make_sure_allowed($this->adminOnly);
                $this->employee->delete($id);
                break;
            case "reset_password":
                $this->_make_sure_allowed($this->adminAndManger);
                $this->employee->reset_password($id);
                break;
        }
    }

    function receipts($action)
    {

        $id = segment(4);

        $this->module('receipts');

        switch ($action) {

            case "pos_receipt":
                $this->_make_sure_allowed($this->everyone);
                $this->receipts->pos_receipt($id);
                break;

            default:
                # code...
                break;
        }

    }

    function settings($action)
    {

        $this->module('settings');

        switch ($action) {
            case "site":
                $this->settings->site_settings();
                $this->_make_sure_allowed($this->adminOnly);

        }
    }
}
