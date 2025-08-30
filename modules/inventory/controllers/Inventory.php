<?php

use League\Csv\Writer;

class Inventory extends Trongate
{

    function __construct()
    {
        $this->module('warehouse');
    }


    function add_stock()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_stocks();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->save_stock();
        }
    }
    function get_stocks()
    {

        $query = "SELECT * FROM products";
        $products = $this->model->query($query, 'object');

        $this->module('warehouse');
        $warehouses = $this->warehouse->employees_warehouses();

        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'Add Stock';
        $data['view_file'] = 'add_stocks';
        $data['view_module'] = 'inventory';

        $this->template('dashboard', $data);
    }

    function save_stock()
    {

        $purchase_order_number = post('purchase_order_number');

        $purchase_order = false;

        if (!empty($purchase_order_number)) {
            $purchase_order = $this->model->get_one_where("purchase_order_number", $purchase_order_number, "purchase_orders");
        }


        $quanity_to_stock = $purchase_order === false ? abs(post('quantity')) : $purchase_order->quantity_ordered;

        $stock_added = $this->_add_to_inventory(
            $quanity_to_stock,
            post('product_id'),
            post('warehouse_id'),
            post('reorderlevel'),
            $purchase_order_number
        );

        if ($stock_added) {

            set_flashdata([
                'type' => 'success',
                'message' => 'Product stock added to warehouse inventory'
            ]);

            redirect('dashboard/inventory/add_stocks');
        }

        set_flashdata([
            'type' => 'error',
            'message' => 'Stock was not added to product warehouse'
        ]);

        redirect('dashboard/inventory/add_stocks');
    }


    function _add_to_inventory($quantity, $product_id, $warehouse_id, $reorder_level = null, $purchase_order_number = null, $remarks = null)
    {

        $query = "SELECT * FROM inventory WHERE product_id = $product_id AND warehouse_id = $warehouse_id";

        $inventory = $this->model->query($query, "object");

        $inventoryID = null;


        if (count($inventory) === 1) {

            $id = $inventoryID = $inventory[0]->inventory_id;

            $new_quantity = $quantity + $inventory[0]->quantity_on_hand;

            try {
                $this->model->update_where('inventory_id', $id, ['quantity_on_hand' => $new_quantity], 'inventory');
            } catch (\PDOException $e) {
                return false;
            }
        }


        if (count($inventory) === 0) {

            try {
                $inventoryID = $this->model->insert([
                    'quantity_on_hand' => $quantity,
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'reorder_level' => $reorder_level ?? 10
                ], 'inventory');
            } catch (\PDOException $e) {

                return false;
            }
        }


        $this->_add_inventory_transaction(
            inventory_id: $inventoryID,
            quantity: $quantity,
            reference_id: $purchase_order_number,
            type: 'ADD',
            remarks: $remarks ?? 'Product added to stock',
            previous_quantity: $inventory[0]->quantity_on_hand ?? 0
        );

        return true;
    }


    function _add_inventory_transaction($inventory_id, $quantity, $reference_id, $type, $remarks = '', $previous_quantity = 0)
    {

        $employee = $_SESSION['employee'];

        try {

            $data = [
                'inventory_id' => $inventory_id,
                'transaction_type' => $type,
                'quantity' => $quantity,
                'previous_quantity' => $previous_quantity,
                'transaction_date' => date('Y-m-d'),
                'employee_id' => $employee->employee_id,
                'remarks' => $remarks,
            ];

            if (!empty($reference_id)) {
                $data['reference_id'] = $reference_id;
            }

            $this->model->insert($data, "inventory_transactions");
        } catch (\PDOException $e) {
            return false;
        }
    }

    //Quantity Adjustments
    function adjustments()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_adjustments();
        }
    }

    function stocks()
    {
        $warehouses = $this->warehouse->employees_warehouses();


        $warehouseIDs = array_map(function ($warehouse) {
            return $warehouse->warehouse_id;

        }, $warehouses);

        $warehouseIDs = implode(",", $warehouseIDs);
        $query = "
        SELECT * FROM inventory inv
        LEFT JOIN warehouses w ON inv.warehouse_id = w.warehouse_id
        LEFT JOIN products p ON inv.product_id = p.product_id
        WHERE w.warehouse_id IN ({$warehouseIDs})
        ORDER BY inv.inventory_id DESC
        LIMIT 100
        ";

        $inventories = $this->model->query($query, 'object');

        $data['inventories'] = $inventories;
        $data['warehouses'] = $warehouses;
        $data['products'] = $this->model->query("SELECT * FROM products", 'object');
        $data['page_title'] = 'Stocks';
        $data['view_file'] = 'stocks';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    function filter_stocks()
    {
        $warehouse = out($_GET['warehouse']);
        $product = out($_GET['product']);


        $conditions = [];
        $query_data = [];

        if (!empty($warehouse)) {
            $conditions['w.warehouse_id'] = ':warehouse';
        }

        if (!empty($product)) {
            $conditions['p.product_id'] = ':product';
        }


        $query = "
        SELECT * FROM inventory inv
        LEFT JOIN warehouses w ON inv.warehouse_id = w.warehouse_id
        LEFT JOIN products p ON inv.product_id = p.product_id
        ";

        $query = trim($query, ' \r\n');

        if (!empty($conditions)) {

            $query .= " WHERE ";

            foreach ($conditions as $key => $val) {

                $query_key = str_replace(":", '', $val);

                $query_data[$query_key] = $_GET[$query_key];

                $query .= " $key = $val ";

                $query .= next($conditions) !== false ? " AND " : '';
            }
        }

        $query .= "ORDER BY inv.inventory_id DESC ";

        $inventories = $this->model->query_bind($query, $query_data, 'object');

        $data['inventories'] = $inventories;
        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['products'] = $this->model->query("SELECT * FROM products", 'object');
        $data['page_title'] = 'Stocks';
        $data['view_file'] = 'stocks';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    function get_adjustments()
    {
        $query = "
        SELECT * FROM inventory_transactions it
        LEFT JOIN employees emp ON it.employee_id = emp.employee_id
        LEFT JOIN inventory inv ON it.inventory_id = inv.inventory_id
        LEFT JOIN warehouses w ON inv.warehouse_id = w.warehouse_id
        LEFT JOIN products p ON inv.product_id = p.product_id
        ORDER BY it.transaction_id DESC
        LIMIT 100
        ";

        $adjustments = $this->model->query($query, 'object');

        $data['adjustments'] = $adjustments;
        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['products'] = $this->model->query("SELECT * FROM products", 'object');
        $data['page_title'] = 'Quantity Adjustment';
        $data['view_file'] = 'quantity_adjustments';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    function filter_adjustments()
    {
        $warehouse = out($_GET['warehouse']);
        $product = out($_GET['product']);
        $date = out($_GET['date']);

        $date = explode("-", $date);

        $conditions = [];
        $query_data = [];


        if (!empty($warehouse)) {
            $conditions['w.warehouse_id'] = ':warehouse';
        }

        if (!empty($product)) {
            $conditions['p.product_id'] = ':product';
        }

        if (count($date) === 2) {
            //@TODO: Bind the values of the from_date and to_date
            $from_date = date('Y-m-d', strtotime($date[0]));
            $to_date = date('Y-m-d', strtotime($date[1]));
            $conditions['it.transaction_date'] = "BETWEEN '{$from_date}' AND '{$to_date}' ";
        }


        $query = "
        SELECT * FROM inventory_transactions it
        LEFT JOIN employees emp ON it.employee_id = emp.employee_id
        LEFT JOIN inventory inv ON it.inventory_id = inv.inventory_id
        LEFT JOIN warehouses w ON inv.warehouse_id = w.warehouse_id
        LEFT JOIN products p ON inv.product_id = p.product_id
       
        ";

        $query = trim($query, ' \r\n');

        if (!empty($conditions)) {


            $query .= " WHERE ";

            //w.warehouse_id => :warehouse
            //it.transaction_date => "BETWEEN :from_date and :to_date"
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

        $query .= "ORDER BY it.transaction_id DESC ";

        $adjustments = $this->model->query_bind($query, $query_data, 'object');

        $data['adjustments'] = $adjustments;
        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['products'] = $this->model->query("SELECT * FROM products", 'object');
        $data['page_title'] = 'Quantity Adjustment';
        $data['view_file'] = 'quantity_adjustments';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    //Add Adjustments
    function add_adjustments()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_add_adjustment();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->save_adjustment();
        }
    }

    function get_add_adjustment()
    {
        $query = "SELECT * FROM products";
        $products = $this->model->query($query, 'object');

        $warehouses = $this->warehouse->employees_warehouses();
        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];
        $data['page_title'] = 'Quantity Adjustment';
        $data['view_file'] = 'add_adjustments';
        $data['view_module'] = 'inventory';

        $this->template('dashboard', $data);
    }


    function save_adjustment()
    {
        $action = post('action');
        $warehouse_id = post('warehouse_id');
        $product_id = post('product_id');
        $quantity = abs(post('quantity'));

        $query = "SELECT * FROM inventory WHERE product_id = $product_id AND warehouse_id = $warehouse_id";
        $result = $this->model->query($query, 'object');

        $old_quantity = $result[0]->quantity_on_hand;
        $new_add_quantity = $old_quantity + $quantity;
        $new_remove_quantity = $old_quantity - $quantity;
        $inventory_id = $result[0]->inventory_id;

        if ($action === 'add') {

            $query2 = "UPDATE inventory SET quantity_on_hand = $new_add_quantity WHERE inventory_id = $inventory_id";
            $result2 = $this->model->query($query2, 'object');

            //inserting to the transaction table
            $this->_add_inventory_transaction(
                $inventory_id,
                abs(post('quantity')),
                '',
                'ADD',
                post('remark'),
                $old_quantity
            );


            set_flashdata([
                'type' => 'success',
                'message' => 'Adjustment have been done'
            ]);
        }

        if ($action === 'remove') {

            $query3 = "UPDATE inventory SET quantity_on_hand = $new_remove_quantity WHERE inventory_id = $inventory_id";
            $result3 = $this->model->query($query3, 'object');

            //inserting to the transaction table
            $this->_add_inventory_transaction(
                $inventory_id,
                abs(post('quantity')),
                '',
                'REMOVE',
                post('remark'),
                $old_quantity
            );

            set_flashdata([
                'type' => 'success',
                'message' => 'Adjustment have been done'
            ]);
        }

        redirect('dashboard/inventory/add_adjustments');
    }

    //count stocks
    function count_stock()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_count_stock();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_prepare_stock_count();
        }
    }
    function get_count_stock()
    {
        $data['warehouses'] = $this->warehouse->employees_warehouses();
        $data['page_title'] = 'Count Stock';
        $data['view_file'] = 'count_stocks';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    protected function _prepare_stock_count()
    {
        $warehouse = post('warehouse');
        $date = post('date');
        $reference = post('reference');

        //check the warehouses if it is all or a single warehouse
        $warehouseStock = null;

        if ($warehouse === "*") {
            $warehouseStock = $this->model->query('SELECT * FROM warehouses', 'object');
        } else {
            $query = 'SELECT * FROM warehouses WHERE warehouse_id =  :warehouse_id';
            $warehouseStock = $this->model->query_bind($query, ['warehouse_id' => $warehouse], 'object');
        }

        $wareHouseInventory = null;

        $warehouseStockIDs = [];

        foreach ($warehouseStock as $warehouse) {
            $warehouseStockIDs[] = $warehouse->warehouse_id;
        }

        $warehouseStockIDs = implode(',', $warehouseStockIDs);

        $query = "SELECT * FROM inventory inv LEFT JOIN warehouses w ON inv.warehouse_id = w.warehouse_id LEFT JOIN products p ON inv.product_id = p.product_id WHERE inv.warehouse_id IN ($warehouseStockIDs)";

        $wareHouseInventory = $this->model->query($query, 'object');

        $data = [
            "title" => 'Stock Count on ' . date("M d,Y H:i a"),
            'date' => $date,
            'reference' => $reference,
            'warehouse_id' => $warehouseStockIDs,
            'stock_count' => json_encode($wareHouseInventory),
            'employee_id' => $_SESSION['employee']->employee_id

        ];
        $this->model->insert($data, "stock_count");

        set_flashdata([
            'type' => 'success',
            'message' => 'Stock count recorded'
        ]);

        redirect('dashboard/inventory/stock_count');
    }

    //stock counts
    function stock_count()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_stock_count();
        }
    }

    public function stock_sheet($date = null)
    {
        $date = $_GET['date'] ?? date("Y-m-d");
        $prevDate = date('Y-m-d', strtotime("$date -1 day"));

        //get all the products
        $products = $this->model->query("SELECT * FROM products", 'object');

        $stockSheet = [];

        foreach ($products as $product) {
            //check whether the product is in stock
            $productInventory = $this->model->query("SELECT inventory_id, quantity_on_hand FROM inventory WHERE product_id = {$product->product_id} AND warehouse_id = 1", 'object');
            if (count($productInventory) == 0) {
                continue;
            }

            $productInventory = $productInventory[0];

            //stock in
            $inventoryTransactions = $this->model->query("SELECT * FROM inventory_transactions WHERE inventory_id = {$productInventory->inventory_id} AND transaction_date = '$date'", 'object');

            $stockInTransactions = array_filter($inventoryTransactions, fn($transaction) => $transaction->transaction_type === 'ADD');
            $stockOutTransactions = array_filter($inventoryTransactions, fn($transaction) => $transaction->transaction_type === 'REMOVE');

            $stockIn = array_reduce($stockInTransactions, fn($carry, $transaction) => $carry += $transaction->quantity, 0);
            $stockOut = array_reduce($stockOutTransactions, fn($carry, $transaction) => $carry += $transaction->quantity, 0);

            $lastTransaction = $this->model->query("SELECT * FROM inventory_transactions WHERE inventory_id = {$productInventory->inventory_id} AND transaction_date = '$prevDate' ORDER BY transaction_id DESC LIMIT 1", 'object');
            $lastTransaction = $lastTransaction[0] ?? '';

            $openingStock = match ($lastTransaction->transaction_type ?? '') {
                'ADD' => $lastTransaction->quantity + $lastTransaction->previous_quantity,
                'REMOVE' => $lastTransaction->previous_quantity - $lastTransaction->quantity,
                default => 0
            };

            $stockSheet[] = [
                'code' => $product->product_code,
                'product' => "{$product->product_name}",
                'openingStock' => $openingStock,
                'stockIn' => $stockIn,
                'stockOut' => $stockOut,
                'closingStock' => $productInventory->quantity_on_hand,
                'productUnit' => $product->unit
            ];

        }

        $data['stock_sheet'] = $stockSheet;
        $data['page_title'] = 'Stock Count';
        $data['view_file'] = 'stock_sheet';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);

    }

    function get_stock_count()
    {
        $warehouses = $this->warehouse->employees_warehouses();


        $warehouseIDs = array_map(fn($warehouse) => $warehouse->warehouse_id, $warehouses);

        $warehouseIDs = implode(",", $warehouseIDs);

        $query = "SELECT id, title, reference, date, sc.warehouse_id AS sc_wid, employee_id, w.warehouse_name, w.warehouse_id
        FROM stock_count sc
        LEFT JOIN warehouses w ON sc.warehouse_id = w.warehouse_id
        WHERE sc.warehouse_id IN ({$warehouseIDs})
        ORDER BY id DESC";

        $data['stock_counts'] = $this->model->query($query, 'object');
        $data['page_title'] = 'Stock Count';
        $data['view_file'] = 'stock_counts';
        $data['view_module'] = 'inventory';
        $this->template('dashboard', $data);
    }

    function download_stock_count(int $id)
    {

        $query = "SELECT * FROM stock_count WHERE id = :id";

        $record = $this->model->query_bind($query, ['id' => $id], 'object');
        $record = $record[0];

        $stockCounts = json_decode($record->stock_count);

        $csv = Writer::createFromString();

        $csv->insertOne([
            'Code',
            'Product',
            'Quantity'
        ]);

        $records = [];

        foreach ($stockCounts as $stock) {
            $records[] = [
                $stock->product_code,
                $stock->product_name,
                "{$stock->quantity_on_hand} ({$stock->unit})"
            ];
        }

        $csv->insertAll($records);

        $filename = "stock_count_{$record->reference}_" . str_replace("-", "_", $record->date) . ".csv";
        $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        // Write CSV to file
        file_put_contents($filePath, $csv->toString());

        // Send headers and output file for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        // Optionally delete the file after download
        unlink($filePath);
        exit;

    }

    function delete_stock_count(int $id)
    {
        $query = "DELETE FROM stock_count WHERE id = :id";

        $this->model->query_bind($query, ['id' => $id], 'object');

        set_flashdata([
            'type' => 'success',
            'message' => 'Stock count removed'
        ]);

        redirect('dashboard/inventory/stock_count');
    }

    function _update_inventory_sale(array $products, array $quantities, int $warehouseID, int $saleID)
    {

        foreach ($products as $key => $product) {
            $data = [];

            $query = "SELECT * FROM inventory WHERE product_id = :productID AND warehouse_id = :warehouseID";

            $inventoryConditions = [
                'productID' => $product->product_id,
                'warehouseID' => $warehouseID
            ];

            $inventory = $this->model->query_bind($query, $inventoryConditions, 'object');


            $query = "UPDATE inventory SET quantity_on_hand = quantity_on_hand  -  :quantity
            WHERE product_id = :productID AND warehouse_id = :warehouseID";

            $data = [
                'quantity' => $quantities[$key],
                'productID' => $product->product_id,
                'warehouseID' => $warehouseID
            ];

            $this->model->query_bind($query, $data);

            $this->_add_inventory_transaction(
                $inventory[0]->inventory_id,
                $quantities[$key],
                $saleID,
                'REMOVE',
                'Sale of products #' . $saleID,
                $inventory[0]->quantity_on_hand

            );
        }
    }
}
