<?php

class Inventory extends Trongate
{


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

        $query = "SELECT * FROM warehouses";
        $warehouses = $this->model->query($query, 'object');

        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'Add Stock';
        $data['view_file'] = 'add_stocks';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }

    function save_stock()
    {

        $purchase_order_number = post('purchase_order_number');

        $purchase_order = false;

        if (!empty($purchase_order_number)) {
            $purchase_order = $this->model->get_one_where("purchase_order_number", $purchase_order_number, "purchase_orders");
        }


        $quanity_to_stock = $purchase_order === false  ? abs(post('quantity')) : $purchase_order->quantity_ordered;

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
                'message' => 'Stock added to product warehouse'
            ]);

            redirect('/products/add_stock');
        }

        set_flashdata([
            'type' => 'error',
            'message' => 'Stock was not added to product warehouse'
        ]);

        redirect('/products/add_stock');
    }


    function _add_to_inventory($quantity, $product_id, $warehouse_id, $reorder_level, $purchase_order_number)
    {

        $query = "SELECT * FROM inventory WHERE product_id = $product_id AND warehouse_id = $warehouse_id";

        $inventory = $this->model->query($query, "object");

        $inventoryID = null;


        if (count($inventory) === 1) {

            $id = $inventoryID = $inventory[0]->inventory_id;

            $new_quantity = $quantity + $inventory[0]->quantity_on_hand;

            try {
                $this->model->update_where('inventory_id', $id, ['quantity_on_hand' => $new_quantity]);
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
                    'reorder_level' => $reorder_level
                ]);
            } catch (\PDOException $e) {
                return false;
            }
        }


        $this->_add_inventory_transaction(
            $inventoryID,
            $quantity,
            $purchase_order_number,
            'ADD'

        );

        return true;
    }


    function _add_inventory_transaction($inventory_id, $quantity, $reference_id, $type, $remarks = '')
    {

        $employee = $_SESSION['employee'];

        try {

            $data = [
                'inventory_id' => $inventory_id,
                'transaction_type' => $type,
                'quantity' => $quantity,
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
    function quantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_quantity();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            //insert 
        }
    }

    function get_quantity()
    {
        $data['page_title'] = 'Quantity Adjustment';
        $data['view_file'] = 'quantity_adjustments';
        $data['view_module'] = 'products';
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

        $query2 = "SELECT * FROM warehouses";
        $warehouses = $this->model->query($query2, 'object');
        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];
        $data['page_title'] = 'Add Adjustment';
        $data['view_file'] = 'add_adjustments';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }


    function save_adjustment()
    {
        $action = post('action');
        $warehouse_id = post('warehouse_id');
        $product_id = post('product_id');
        $quantity = post('quantity');
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
            $data['inventory_id'] = $inventory_id;
            $data['transaction_type'] = $action;
            $data['quantity'] = post('quantity');
            $data['transaction_date'] = date('y-m-d');
            $data['employee_id'] = $_SESSION['employee']->employee_id;
            $data['remarks'] = post('remark');
            $data['reference_id'] = "";
            $this->model->insert($data, 'inventory_transactions');
            set_flashdata([
                'type' => 'success',
                'message' => 'Adjustment have been done'
            ]);

            redirect('products/add_adjustments');
        }
        if ($action === 'remove') {
            $query3 = "UPDATE inventory SET quantity_on_hand = $new_remove_quantity WHERE inventory_id = $inventory_id";
            $result3 = $this->model->query($query3, 'object');
            //inserting to the transaction table
            $data['inventory_id'] = $inventory_id;
            $data['transaction_type'] = $action;
            $data['quantity'] = post('quantity');
            $data['transaction_date'] = date('y-m-d');
            $data['employee_id'] = $_SESSION['employee']->employee_id;
            $data['remarks'] = post('remark');
            $data['reference_id'] = "";
            $this->model->insert($data, 'inventory_transactions');
            set_flashdata([
                'type' => 'success',
                'message' => 'Adjustment have been done'
            ]);

            redirect('products/add_adjustments');
        }
    }

    //count stocks
    function count()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_count_stock();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            //insert
        }
    }
    function get_count_stock()
    {
        $data['page_title'] = 'Count Stock';
        $data['view_file'] = 'count_stocks';
        $data['view_module'] = 'products';
        $this->template('dashboard', $data);
    }

    //stock counts
    function stock()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->get_stock_count();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->save_stock_count();
        }
    }

    function get_stock_count()
    {
        $data['page_title'] = 'Stock Count';
        $data['view_file'] = 'stock_counts';
        $data['view_module'] = 'products';
        $this->template('dashboard', $data);
    }

    function save_stock_count()
    {
        $data['warehouse'] = post('warehouse');
        $data['date'] = post('date');
        $date['reference'] = post('reference');
        $date['type'] = post('type');
        $this->model->insert($data, 'table');
        redirect('products/stock');
    }
}
