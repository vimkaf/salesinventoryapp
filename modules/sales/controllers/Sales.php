<?php
class Sales extends Trongate
{

    function dashboard()
    {
        $this->module('warehouse');
        $this->module('customer');

        $sql1 = "SELECT * FROM products";
        $products = $this->model->query($sql1, 'object');

        $data['customers'] = $this->customer->_get();
        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['products'] = $products;

        $data['page_title'] = 'Dashboard';
        $data['view_file'] = 'pos';
        $data['view_module'] = 'sales';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");
        $data['view_fragments'] = ['script', 'style'];

        $this->template('pos', $data);
    }

    function return_sale()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->_return_sale()) {
                set_flashdata([
                    'type' => 'success',
                    'message' => 'Return completed'
                ]);
            } else {
                set_flashdata([
                    'type' => 'error',
                    'message' => 'An unknown error occured when trying to complete the sale return'
                ]);
            }
        }

        if (isset($_GET['sale_number'])) {

            $saleRecord = $data['saleRecord'] = $this->model->get_one_where('sale_number', $_GET['sale_number'], 'sales');

            if ($saleRecord !== false && $saleRecord->returned) {
                set_flashdata([
                    'type' => 'error',
                    'message' => 'Sale has been returned'
                ]);

                redirect('dashboard/sales/returnsale');
            }

            if ($saleRecord !== false) {
                $data['customer'] = $this->model->get_one_where('customer_id', $saleRecord->customer_id, 'customers');
                $data['warehouse'] = $this->model->get_one_where('warehouse_id', $saleRecord->warehouse_id, 'warehouses');
                $sql = "SELECT * FROM sale_products LEFT JOIN products ON sale_products.product_id = products.product_id WHERE sale_id = $saleRecord->sale_id";
                $data['sale_products'] = $this->model->query($sql, 'object');
            }

        }

        $data['page_title'] = 'Return Sales';
        $data['view_file'] = 'return_sales';
        $data['view_module'] = 'sales';
        $data['view_scripts'] = base_url(uri: "assets/dist/plugins/block-ui/jquery.blockUI.js");
        $data['view_fragments'] = ['return_sale_script', 'style'];

        $template = match ($_SESSION['employee']->role) {
            'cashier' => 'cashier',
            'sales' => 'sales',
            'pos' => 'pos',
            'admin' => 'dashboard'
        };

        $this->template($template, $data);
    }

    private function _return_sale(): bool
    {
        $this->module('inventory');

        $sale = $this->model->get_one_where('sale_id', post('sale_id'), 'sales');
        $products = post('product');

        $returnSaleData = [];
        foreach ($products as $key => $productID) {
            $returnSaleData[] = [
                'employee_id' => $_SESSION['employee']->employee_id,
                'sale_id' => $sale->sale_id,
                'product_id' => $productID,
                'quantity_sold' => post('quantity_sold')[$key],
                'quantity_returned' => post('quantity_returned')[$key],
                'sale_price' => post('price')[$key],
                'return_price' => post('price')[$key],
                'date_time_returned' => date("Y-m-d H:i:s")
            ];
        }

        //start a transaction
        $this->model->query("START TRANSACTION");

        try {
            //insert the return sale data
            $this->model->insert_batch('returned_products', $returnSaleData);

            //update the inventory for each product
            foreach ($products as $key => $productID) {
                $newQty = post('quantity_sold')[$key] - post('quantity_returned')[$key];
                $this->inventory->_add_to_inventory(
                    quantity: (int) $newQty,
                    product_id: $productID,
                    warehouse_id: $sale->warehouse_id,
                    remarks: "Return for sale #{$sale->sale_id}",
                    purchase_order_number: $sale->sale_id
                );
            }

            //update the sale record
            $this->model->update_where('sale_id', $sale->sale_id, [
                'returned' => 1,
                'returned_amount' => post('netTotal')
            ]);

        } catch (Exception $e) {
            $this->model->query("ROLLBACK");

            return false;
        }

        //Commit the transaction
        $this->model->query("COMMIT");
        return true;
    }

    function pos()
    {

    }

    function _add_customer()
    {

        header("Content-Type: application/json", true);

        header_remove('X-Powered-By');

        $this->module('customer');

        $customerID = (int) $this->customer->_create();

        if (is_int($customerID)) {

            http_response_code(200);


            $data = [
                'status' => true,
                'message' => 'Customer created successfully',
                'data' => [
                    'id' => $customerID
                ]
            ];

            echo json_encode($data);

            exit();

        }

        http_response_code(403);

        $data = [
            'status' => false,
            'message' => 'Could not create customer'
        ];

        echo json_encode($data);

        exit();



    }

    function _checkinventory()
    {
        header("Content-Type: application/json", true);
        header_remove('X-Powered-By');

        $warehouse = (int) filter_input(INPUT_GET, 'warehouse', FILTER_SANITIZE_NUMBER_INT);
        $product = (int) filter_input(INPUT_GET, 'product', FILTER_SANITIZE_NUMBER_INT);
        $quantity = (int) filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM inventory WHERE product_id = :productID AND warehouse_id = :warehouseID";
        $inventory = $this->model->query_bind($query, [
            'productID' => $product,
            'warehouseID' => $warehouse
        ], 'object');

        if (!isset($inventory[0])) {

            http_response_code(404);

            $data = [
                'status' => false,
                'message' => 'The product has no stock in the inventory. Add the product stock to inventory before sale',
                'data' => []
            ];

            echo json_encode($data);

            exit();


        }

        if ($quantity > $inventory[0]->quantity_on_hand) {

            http_response_code(403);

            $data = [
                'status' => false,
                'message' => 'Low quantity',
                'data' => [
                    'quantity_on_hand' => $inventory[0]->quantity_on_hand
                ]
            ];

            echo json_encode($data);

            exit();

        }


        http_response_code(200);

        $data = [
            'status' => true,
            'message' => 'Quantity Available',
            'data' => [
                'quantity_on_hand' => $inventory[0]->quantity_on_hand
            ]
        ];

        echo json_encode($data);
    }

    function _fetch_sale_items()
    {
        header("Content-Type: application/json", true);
        header_remove('X-Powered-By');

        $saleID = (int) filter_input(INPUT_GET, 'saleid', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM sale_products s LEFT JOIN products p ON s.product_id = p.product_id  WHERE sale_id = :saleID";

        $saleItems = $this->model->query_bind($query, [
            'saleID' => $saleID
        ], 'object');

        if (!isset($saleItems[0])) {

            http_response_code(404);

            $data = [
                'status' => false,
                'message' => 'Could not fetch items for the sale, try again',
                'data' => []
            ];

            echo json_encode($data);

            exit();


        }

        http_response_code(200);

        $sale = $this->model->query_bind("SELECT * FROM sales WHERE sale_id = :saleid", ['saleid' => $saleID], 'object');

        $data = [
            'status' => true,
            'message' => 'Items fetched',
            'data' => [
                'items' => $saleItems,
                'sale' => $sale[0]
            ]
        ];

        echo json_encode($data);

        exit();

    }

    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_add_sales();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->save_sales();
        }
    }
    function get_add_sales()
    {
        $sql1 = "SELECT * FROM products";
        $products = $this->model->query($sql1, 'object');

        $sql2 = "SELECT * FROM customers";
        $customers = $this->model->query($sql2, 'object');

        $this->module('warehouse');

        $warehouses = $this->warehouse->employees_warehouses();

        $data = [
            'products' => $products,
            'customers' => $customers,
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'Add Sales';
        $data['view_file'] = 'add_sales';
        $data['view_module'] = 'sales';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");
        $data['view_fragments'] = ['script', 'style'];



        $this->template('dashboard', $data);
        // $this->view('script', $data);
    }
    function save_sales()
    {

        $employeeID = $_SESSION['employee']->employee_id;
        $customerID = post('customer');
        $wareHouseID = post('warehouse');

        $products = post('product');
        $quantities = post('quantity');

        $discount = post('discount');
        $tax = post('tax');

        $amountPaid = post('amount_paid');
        $amountPaid = str_replace(",", "", $amountPaid);

        $paymentMethod = post('method');

        $saveAction = post('save_action');

        $productIDs = implode(",", $products);
        $query = "SELECT * FROM products WHERE product_id IN ($productIDs)";
        $productsRecord = $this->model->query($query, "object");

        $totalPrice = 0;



        array_map(function ($product, $qty) use (&$totalPrice) {
            $totalPrice += $product->product_price * $qty;
        }, $productsRecord, $quantities);

        $grandTotal = ($totalPrice + $tax) - $discount;

        $status = $amountPaid < $grandTotal ? 'partial' : 'full';

        $this->module('warehouse');

        $warehouseRecord = $this->warehouse->_warehouse_record($wareHouseID);

        $saleData = [
            'sale_number' => $this->_generate_sale_number($warehouseRecord[0]->warehouse_code),
            'date_of_sale' => date('Y-m-d'),
            'total_price' => $totalPrice, //product price * qty
            'customer_id' => $customerID,
            'warehouse_id' => $wareHouseID,
            'status' => $status,
            'employee_id' => $employeeID,
            'amount_paid' => $amountPaid,
            'discount' => $discount,
            'tax' => $tax,
            'grand_total' => $grandTotal
        ];


        $saleID = (int) $this->model->insert($saleData, "sales");


        if (!is_int($saleID)) {
            set_flashdata([
                'type' => 'error',
                'message' => 'Could not save the sale'
            ]);

            redirect('dashboard/sales/add');
        }

        $saleItems = [];

        for ($i = 0; $i < count($productsRecord); $i++) {
            $saleItems[] = [
                'sale_id' => $saleID,
                'product_id' => $productsRecord[$i]->product_id,
                'quantity_sold' => $quantities[$i],
                'price' => $productsRecord[$i]->product_price
            ];
        }

        $rowsInserted = $this->model->insert_batch("sale_products", $saleItems);

        if ($rowsInserted !== count($productsRecord)) {
            //remove the sales record
            $this->model->query_bind("DELETE FROM sales WHERE sale_id = :saleID", ['saleID' => $saleID]);

            set_flashdata([
                'type' => 'error',
                'message' => 'Could not save the sale items'
            ]);

            redirect('dashboard/sales/add');
        }

        $this->module('receipts');

        $change = 0;


        if ($amountPaid > $grandTotal) {
            $balance = 0;
            $change = $amountPaid - $grandTotal;
        } else {
            $balance = $grandTotal - $amountPaid;
        }

        $receiptID = (int) $this->receipts->_create_sales_receipt(
            $saleID,
            $amountPaid,
            $balance,
            $change,
            $customerID,
            $_SESSION['employee']->employee_id,
            $paymentMethod
        );

        if (!is_int($receiptID)) {

            //remove sales record
            $this->model->query_bind("DELETE FROM sales WHERE sale_id = :saleID", ['saleID' => $saleID]);

            //remove sales items record
            $this->model->query_bind("DELETE FROM sale_products WHERE sale_id = :saleID", ['saleID' => $saleID]);

            set_flashdata([
                'type' => 'error',
                'message' => 'Could not create receipt for the sales'
            ]);

            redirect('dashboard/sales/add');
        }

        $this->module('inventory');

        $this->inventory->_update_inventory_sale(
            $productsRecord,
            $quantities,
            $wareHouseID,
            $saleID
        );

        if ($_SESSION['employee']->role === "sales" && $saveAction === 'print') {
            redirect('dashboard/receipts/pos_receipt/' . $receiptID);
        }

        if ($_SESSION['employee']->role === "sales" && $saveAction === 'save') {
            redirect(previous_url());
        }

        redirect('dashboard/sales/receipt/' . $receiptID);
    }

    private function _generate_sale_number(string $warehouseCode)
    {

        $lastID = $this->model->query("SELECT MAX(sale_id) as id FROM sales", 'object');

        $lastID = $lastID[0]->id ?? 0;
        $nextID = $lastID + 1;

        return strtoupper($warehouseCode) . str_pad($nextID, 5, '0', STR_PAD_LEFT); //WC000001

    }

    function _sales_record(int $saleID)
    {
        $query = "SELECT * FROM sales WHERE sale_id = :saleID";
        return $this->model->query_bind($query, ['saleID' => $saleID], 'object');
    }

    function _sales_items_record(int $saleID)
    {
        $query = "SELECT * FROM sale_products sp LEFT JOIN products p ON sp.product_id = p.product_id WHERE sale_id = :saleID";
        return $this->model->query_bind($query, ['saleID' => $saleID], 'object');
    }

    //list sales
    function list()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->_sales();
        }
    }

    function _sales()
    {
        $this->module('warehouse');

        $warehouses = $this->warehouse->employees_warehouses();

        $warehouseIDs = array_map(fn($warehouse) => $warehouse->warehouse_id, $warehouses);

        $warehouseIDs = implode(",", $warehouseIDs);

        $today = date('Y-m-d');

        $sql = "SELECT s.sale_id,s.sale_number, s.date_of_sale, s.total_price, 
        s.grand_total,s.status,s.returned_amount,s.returned,
        w.warehouse_name,
        c.first_name AS customer_first_name,
        c.last_name AS customer_last_name, e.first_name AS employee_first_name,
        e.last_name AS employee_last_name,
        SUM(r.amount) AS total_amount_paid
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.customer_id
        LEFT JOIN warehouses w ON s.warehouse_id = w.warehouse_id
        LEFT JOIN employees e ON s.employee_id = e.employee_id
        LEFT JOIN receipts r ON s.sale_id = r.sale_id
        WHERE s.date_of_sale = '$today' AND s.warehouse_id IN ({$warehouseIDs})
        GROUP BY s.sale_id,sale_number, date_of_sale, grand_total,total_price,status,warehouse_name
        ORDER BY s.sale_id DESC";

        $data['warehouses'] = $warehouses;
        $data['sales'] = $this->model->query($sql, 'object');
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);
        $data['page_title'] = 'Today Sales';
        $data['view_file'] = 'lists';
        $data['view_module'] = 'sales';
        $data['view_fragments'] = 'sales_script';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");


        $this->template('dashboard', $data);

    }

    function filter_sales()
    {
        $warehouse = out($_GET['warehouse']);
        $salenumber = out($_GET['salenumber']);
        $receiptnumber = out($_GET['receipt_number']);
        $from_date = out($_GET['from_date']);
        $to_date = out($_GET['to_date']);

        $conditions = [];
        $query_data = [];

        if (!empty($warehouse)) {
            $conditions['w.warehouse_id'] = ':warehouse';
        }

        if (!empty($salenumber)) {
            $conditions['s.sale_number'] = ':salenumber';
        }

        if (!empty($from_date) && !empty($to_date)) {
            $conditions['s.date_of_sale'] = " BETWEEN '{$from_date}' AND '{$to_date}' ";
        }

        if (!empty($receiptnumber)) {

            $query = "SELECT * FROM receipts WHERE receipt_number = :receiptNumber";

            $receipt = $this->model->query_bind($query, ['receiptNumber' => $receiptnumber], 'object');

            if (isset($receipt[0])) {

                $_GET['receiptid'] = $receipt[0]->receipt_id;

                $conditions['r.receipt_id'] = ':receiptid';

            } else {
                set_flashdata([
                    'type' => 'error',
                    'message' => 'Receipt number is invalid'
                ]);
            }

        }

        $query = "SELECT s.sale_id,s.sale_number, s.date_of_sale, s.total_price, s.grand_total,s.status,
        s.returned_amount,s.returned,
        w.warehouse_name,
        c.first_name AS customer_first_name,
        c.last_name AS customer_last_name, e.first_name AS employee_first_name,
        e.last_name AS employee_last_name,
        SUM(r.amount) AS total_amount_paid
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.customer_id
        LEFT JOIN warehouses w ON s.warehouse_id = w.warehouse_id
        LEFT JOIN employees e ON s.employee_id = e.employee_id
        LEFT JOIN receipts r ON s.sale_id = r.sale_id
        ";

        $query = trim($query, ' \r\n');

        if (!empty($conditions)) {

            $query .= " WHERE ";

            foreach ($conditions as $key => $val) {
                if (str_starts_with($val, ':')) {
                    $query_key = str_replace(":", '', $val);
                    $query_data[$query_key] = $_GET[$query_key];
                    $query .= " $key = $val ";
                } else {
                    $query .= " $key $val ";
                }

                $query .= next($conditions) !== false ? " AND " : '';
            }
        }

        $query .= " GROUP BY s.sale_id,sale_number, date_of_sale, grand_total,total_price,status,warehouse_name ";

        $query .= " ORDER BY s.sale_id DESC ";

        $this->module('warehouse');

        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['sales'] = $this->model->query_bind($query, $query_data, 'object');
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);
        $data['page_title'] = 'Filtered Sales Record';
        $data['view_file'] = 'lists';
        $data['view_module'] = 'sales';
        $data['view_fragments'] = 'sales_script';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");

        $this->template('dashboard', $data);

    }


    function receipt(int $receiptID)
    {

        $this->module('receipts');

        $this->module('warehouse');

        $this->module('customer');

        $this->module('employee');



        $receiptRecord = $this->receipts->_receipt_record($receiptID);

        if (empty($receiptRecord)) {
            set_flashdata([
                'type' => 'error',
                'message' => 'Cannot find the receipt'
            ]);

            redirect(previous_url());
        }

        $saleRecord = $this->_sales_record($receiptRecord[0]->sale_id);

        $saleItemsRecord = $this->_sales_items_record($receiptRecord[0]->sale_id);

        $warehouseRecord = $this->warehouse->_warehouse_record($saleRecord[0]->warehouse_id);

        $customerRecord = $this->customer->_customer_record($saleRecord[0]->customer_id);

        $employeeRecord = $this->employee->_employee_record($saleRecord[0]->employee_id);

        $receiptsRecord = $this->receipts->_receipt_record_by_sale($saleRecord[0]->sale_id);

        $totalPayments = array_reduce($receiptsRecord, function ($carry, $receipt) {

            return $carry += $receipt->amount;
        }, 0);



        $data['page_title'] = 'Sales Receipt';
        $data['view_module'] = 'sales';
        $data['view_file'] = 'sale_receipt';
        $data['receipt'] = $receiptRecord[0];
        $data['total_payments'] = $totalPayments;
        $data['sale'] = $saleRecord[0];
        $data['saleItems'] = $saleItemsRecord;
        $data['warehouse'] = $warehouseRecord[0];
        $data['customer'] = $customerRecord[0];
        $data['employee'] = $employeeRecord[0];
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);

        $this->template('dashboard', $data);

    }

    function receipts(int $saleID)
    {
        $salesRecord = $this->_sales_record($saleID);

        $saleItems = $this->_sales_items_record($saleID);

        $this->module('receipts');

        $receipts = $this->receipts->_receipt_record_by_sale($saleID);

        $this->module('customer');

        $customer = $this->customer->_customer_record($salesRecord[0]->customer_id);

        $data['sale'] = $salesRecord[0];
        $data['saleItems'] = $saleItems[0];
        $data['customer'] = $customer[0];
        $data['receipts'] = $receipts;
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);
        $data['page_title'] = 'Receipt';
        $data['view_file'] = 'receipts';
        $data['view_module'] = 'sales';
        $data['total_amount'] = 0;
        $data['total_balance'] = 0;

        $this->template('dashboard', $data);
    }

    function add_payment()
    {
        $saleID = post('sale_id', true);

        $saleRecord = $this->_sales_record($saleID)[0];

        $amount = post('amount', true);
        $amount = str_replace(",", "", $amount);
        $date = post('date', true);
        $method = post('method', true);

        $this->module('receipts');

        $receiptRecords = $this->receipts->_receipt_record_by_sale($saleID);

        $totalAmountPaid = array_reduce($receiptRecords, function ($carry, $receipt) {
            return $carry += $receipt->amount;
        }, 0);

        $balance = $saleRecord->grand_total - $totalAmountPaid;



        if ($amount > $balance) {

            set_flashdata([
                'type' => 'error',
                'message' => 'Amount is more than the balance'
            ]);

            redirect('dashboard/sales/receipts/' . $saleID);

        }

        $newBalance = $saleRecord->grand_total - ($amount + $totalAmountPaid);

        // int $saleID, int|float $amount, int|float $balance, int|float $change, int $customerID, int $employeeID, string $method = 'cash'

        $this->receipts->_create_sales_receipt(
            $saleID,
            $amount,
            $newBalance,
            0,
            $saleRecord->customer_id,
            $_SESSION['employee']->employee_id,
            $method,
            $date
        );

        if ($newBalance <= 0) {
            $query = "UPDATE sales SET status = 'full' WHERE sale_id = :saleID";
            $this->model->query_bind($query, ['saleID' => $saleID]);
        }

        set_flashdata([
            'type' => 'success',
            'message' => 'Payment has been added for that receipt'
        ]);

        return redirect('dashboard/sales/receipts/' . $saleID);
    }

    function pos_report()
    {

        $today = date('Y-m-d');

        $employeeID = $_SESSION['employee']->employee_id;

        $sql = "
        SELECT s.sale_id,s.sale_number, s.date_of_sale, s.total_price, s.grand_total,s.status,
        w.warehouse_name,
        c.first_name AS customer_first_name,
        c.last_name AS customer_last_name, e.first_name AS employee_first_name,
        e.last_name AS employee_last_name,
        r.receipt_id,
        SUM(r.amount) AS total_amount_paid
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.customer_id
        LEFT JOIN warehouses w ON s.warehouse_id = w.warehouse_id
        LEFT JOIN employees e ON s.employee_id = e.employee_id
        LEFT JOIN receipts r ON s.sale_id = r.sale_id
        WHERE s.date_of_sale = '$today' AND s.employee_id = $employeeID
        GROUP BY s.sale_id,sale_number, receipt_id, date_of_sale, grand_total,total_price,status,warehouse_name
        ORDER BY s.sale_id DESC
        ";

        // json($sql, true);

        $salesRecord = $this->model->query($sql, 'object');


        $data['sales'] = $salesRecord;
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);
        $data['page_title'] = 'Today Sales';
        $data['view_file'] = 'pos_report';
        $data['view_module'] = 'sales';
        $data['view_fragments'] = 'sales_script';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");


        $this->template('pos', $data);

    }

    function _filter_pos_report()
    {

        $today = date('Y-m-d');

        $employeeID = $_SESSION['employee']->employee_id;

        $salenumber = out($_GET['salenumber']);
        $receiptnumber = out($_GET['receipt_number']);
        $from_date = out($_GET['from_date']);
        $to_date = out($_GET['to_date']);

        $conditions = [];
        $query_data = [];

        if (!empty($salenumber)) {
            $conditions['s.sale_number'] = ':salenumber';
        }

        if (!empty($from_date) && !empty($to_date)) {
            $conditions['s.date_of_sale'] = " BETWEEN '{$from_date}' AND '{$to_date}' AND s.employee_id = $employeeID ";
        }

        if (!empty($receiptnumber)) {

            $query = "SELECT * FROM receipts WHERE receipt_number = :receiptNumber";

            $receipt = $this->model->query_bind($query, ['receiptNumber' => $receiptnumber], 'object');

            if (isset($receipt[0])) {

                $_GET['receiptid'] = $receipt[0]->receipt_id;

                $conditions['r.receipt_id'] = ':receiptid';

            } else {
                set_flashdata([
                    'type' => 'error',
                    'message' => 'Receipt number is invalid'
                ]);
            }

        }


        $query = "
        SELECT s.sale_id,s.sale_number, s.date_of_sale, s.total_price, s.grand_total,s.status,
        w.warehouse_name,
        c.first_name AS customer_first_name,
        c.last_name AS customer_last_name, e.first_name AS employee_first_name,
        e.last_name AS employee_last_name,
        r.receipt_id,
        SUM(r.amount) AS total_amount_paid
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.customer_id
        LEFT JOIN warehouses w ON s.warehouse_id = w.warehouse_id
        LEFT JOIN employees e ON s.employee_id = e.employee_id
        LEFT JOIN receipts r ON s.sale_id = r.sale_id
        ";

        $query = trim($query, ' \r\n');

        if (!empty($conditions)) {

            $query .= " WHERE ";

            foreach ($conditions as $key => $val) {
                if (str_starts_with($val, ':')) {
                    $query_key = str_replace(":", '', $val);
                    $query_data[$query_key] = $_GET[$query_key];
                    $query .= " $key = $val ";
                } else {

                    $query .= " $key $val ";
                }

                $query .= next($conditions) !== false ? " AND " : '';
            }
        }

        $query .= " GROUP BY r.amount,s.sale_id,sale_number,receipt_id, date_of_sale, grand_total,total_price,status,warehouse_name ";

        $query .= " ORDER BY s.sale_id DESC ";

        // json($query, true);


        $salesRecord = $this->model->query_bind($query, $query_data, 'object');

        $data['sales'] = $salesRecord;
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);
        $data['page_title'] = 'Filtered Sales Record';
        $data['view_file'] = 'pos_report';
        $data['view_module'] = 'sales';
        $data['view_fragments'] = 'sales_script';
        $data['view_scripts'] = base_url("assets/dist/plugins/block-ui/jquery.blockUI.js");


        $this->template('pos', $data);
    }
}
