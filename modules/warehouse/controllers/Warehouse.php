<?php
class Warehouse extends Trongate
{

    function _warehouse_record(int $warehouseID)
    {
        $query = "SELECT * FROM warehouses WHERE warehouse_id = :warehouseID";
        return $this->model->query_bind($query, ['warehouseID' => $warehouseID], 'object');
    }

    function employees_warehouses()
    {
        $employee = $_SESSION['employee'];

        if (is_null($employee->warehouse_id)) {

            return $this->model->query("SELECT * FROM warehouses", "object");
        }

        return $this->model->get_many_where('warehouse_id', $employee->warehouse_id, 'warehouses');
    }
    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $data['page_title'] = 'Add Warehouse';
            $data['view_file'] = 'add_warehouse';
            $data['view_module'] = 'warehouse';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->add_warehouse();
        }
    }
    function add_warehouse()
    {
        $data['warehouse_code'] = post('warehouse_code');
        $data['warehouse_name'] = post('warehouse_name');
        $data['warehouse_location'] = post('warehouse_location');
        $data['warehouse_address'] = post('warehouse_address');
        $this->model->insert($data, 'warehouses');
        set_flashdata([
            'type' => 'success',
            'message' => 'Warehouse Have been added'
        ]);
        redirect("warehouse/list"); 
    }
    function list()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->list_warehouse();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }
    function list_warehouse()
    {
        $query = "SELECT * FROM warehouses";
        $warehouses = $this->model->query($query, 'object');
        $data = [
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'list Warehouse';
        $data['view_file'] = 'list_warehouse';
        $data['view_module'] = 'warehouse';

        $this->template('dashboard', $data);
    }
    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $query = "SELECT * FROM warehouses WHERE warehouse_id = $id";
            $warehouse = $this->model->query($query, 'object');
            $data = [
                'warehouse' => $warehouse
            ];
            $data['page_title'] = 'Edit Warehouse';
            $data['view_file'] = 'edit_warehouse';
            $data['view_module'] = 'warehouse';

            $this->template('dashboard', $data);
        }
    }
    function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_update_warehouse();
        }
    }
    function _update_warehouse()
    {
        $id = post('warehouse_id');
        $data['warehouse_code'] = post('warehouse_code');
        $data['warehouse_name'] = post('warehouse_name');
        $data['warehouse_location'] = post('warehouse_location');
        $data['warehouse_address'] = post('warehouse_address');
        $this->model->update_where('warehouse_id', $id, $data, 'warehouses');
        set_flashdata([
            'type' => 'success',
            'message' => 'Warehouse Have been Edited'
        ]);
        redirect('/warehouse/list');
    }
    function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id = (int) $id;
            $query = "DELETE FROM warehouses WHERE warehouse_id ='$id'";
            $this->model->query($query, 'object');
            set_flashdata([
                'type' => 'success',
                'message' => 'Warehouse Have been Deleted'
            ]);
            redirect('/warehouse/list');
        }
    }
}
