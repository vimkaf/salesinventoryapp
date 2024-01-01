<?php
class Employee extends Trongate
{
    protected $roles = [
        'admin',
        'manager',
        'sales',
        'cashier'
    ];

    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {

            $query = "SELECT * FROM trongate_user_levels";

            $roles = $this->model->query($query, 'object');

            $this->module('warehouse');

            $data = [
                'roles' => $roles,
                'warehouses' => $this->warehouse->employees_warehouses()
            ];

            $data['page_title'] = 'Add Employee';
            $data['view_file'] = 'add_employee';
            $data['view_module'] = 'employee';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->add_employee();
        }
    }
    function add_employee()
    {


        //create trongate user 
        $this->module('trongate_users');

        $trongate_user_id = $this->trongate_users->_create_user(post('role'));

        //create employee
        $data['first_name'] = post('first_name');
        $data['last_name'] = post('last_name');
        $data['email'] = post('email');
        $data['phone_number'] = post('phone_number');
        $key = post('role') - 1;
        $data['role'] = $this->roles[$key];
        $data['member_id'] = 0;
        $data['trongate_user_id'] = $trongate_user_id;
        $data['warehouse_id'] = post('warehouse');
        $employeeID = $this->model->insert($data, 'employees');

        //create user_login

        $this->module('login');

        $this->login->_create_user_login(
            $employeeID,
            post('role'),
            post('phone_number')
        );

        set_flashdata([
            'type' => 'success',
            'message' => 'Employee Have been Added'
        ]);

        redirect('dashboard/employee/views');

    }

    function _employee_record(int $employeeID)
    {
        $query = "SELECT * FROM employees WHERE employee_id = :employeeID";
        return $this->model->query_bind($query, ['employeeID' => $employeeID], 'object');
    }
    function views()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {

            $this->module('warehouse');

            $employee_warehouses = $this->warehouse->employees_warehouses();

            $warehouseIDs = array_map(fn($warehouse) => $warehouse->warehouse_id, $employee_warehouses);

            $warehouseIDs = implode(",", $warehouseIDs);

            $employeeID = $_SESSION['employee']->employee_id;

            $query = "SELECT * FROM employees WHERE warehouse_id IN ({$warehouseIDs}) AND employee_id != $employeeID";

            $employees = $this->model->query($query, 'object');

            $data = [
                'employees' => $employees
            ];

            $data['page_title'] = 'Views Employee';
            $data['view_file'] = 'view_employee';
            $data['view_module'] = 'employee';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }
    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $query = "SELECT * FROM employees WHERE employee_id = :employee_id";
            $query_data = ['employee_id' => $id];
            $employee = $this->model->query_bind($query, $query_data, 'object');

            $query2 = "SELECT * FROM trongate_user_levels";
            $roles = $this->model->query($query2, 'object');

            $this->module('warehouse');


            $data = [
                'employee' => $employee,
                'roles' => $roles,
                'warehouses' => $this->warehouse->employees_warehouses()
            ];

            $data['page_title'] = 'Update Employee';
            $data['view_file'] = 'update_employee';
            $data['view_module'] = 'employee';

            $this->template('dashboard', $data);
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_update_employee((int) $id);
        }
    }

    function _update_employee(int $id)
    {

        $data['first_name'] = post('first_name');
        $data['last_name'] = post('last_name');
        $data['email'] = post('email');
        $data['phone_number'] = post('phone_number');
        $key = post('role') - 1;
        $data['role'] = $this->roles[$key];
        $data['warehouse_id'] = post('warehouse');
        $data['employee_id'] = $id;

        $query = "UPDATE employees SET first_name = :first_name, last_name = :last_name, email = :email,
        phone_number = :phone_number, role = :role, warehouse_id = :warehouse_id WHERE employee_id = :employee_id";

        $this->model->query_bind($query, $data);

        set_flashdata([
            'type' => 'success',
            'message' => 'Employee Record updated'
        ]);

        redirect('dashboard/employee/views');

    }

    function reset_password(int $id)
    {

        $employee = $this->model->get_one_where('employee_id', $id, 'employees');

        $this->module('login');

        $offset = strlen($employee->phone_number) - 4;
        $len = strlen($employee->phone_number);

        $password = substr($employee->phone_number, $offset, $len);

        $this->login->_reset_password($employee->employee_id, $password);


        set_flashdata([
            'type' => 'success',
            'message' => 'Employee password has been reset'
        ]);

        redirect('dashboard/employee/views');



    }

    function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $query = "DELETE FROM employees WHERE employee_id ='$id'";
            $this->model->query($query, 'object');
            set_flashdata([
                'type' => 'success',
                'message' => 'Employee have been deleted'
            ]);

            redirect('dashboard/employee/views');
        }

    }
}