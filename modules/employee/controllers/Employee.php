<?php 
class Employee extends Trongate{
    function add(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $query ="SELECT * FROM trongate_user_levels";
            $roles = $this->model->query($query,'object');
            $data = [
                'roles' => $roles
            ];

            $data['page_title'] = 'Add Employee';
            $data['view_file'] = 'add_employee';
            $data['view_module'] = 'employee';
            
            $this->template('dashboard', $data);
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->add_employee();
        }
    }
    function add_employee(){
        // if(post('role') === "admin"){
        //     $role = 1;
        // }
        // if(post('role') === "manager"){
        //     $role = 2;
        // }
        // if(post('role') === "sales"){
        //     $role = 3;
        // }
        // if(post('role') === "cashier"){
        //     $role = 4;
        // }
        // json($role);
        // exit;
        $data['first_name'] = post('first_name');
        $data['last_name'] = post('last_name');
        $data['email'] = post('email');
        $data['phone_number'] = post('phone_number');
        $data['role'] = post('role');
        $data['member_id'] = post('member_id');
        $data['trongate_user_id'] = post('trongate_user_id');
        $this->model->insert($data,'employees');
        set_flashdata([
            'type' => 'success',
            'message' => 'Employee Have been Added'
        ]);
        redirect('/employee/add');
    }
    function views(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $query = "SELECT * FROM employees";
            $employees = $this->model->query($query,'object');
            $data = [
                'employees' => $employees
            ];

            $data['page_title'] = 'Views Employee';
            $data['view_file'] = 'view_employee';
            $data['view_module'] = 'employee';

            $this->template('dashboard', $data);
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
        }
    }
    function edit($id){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $query ="SELECT * FROM employees WHERE employee_id";
            $employee = $this->model->query($query,'object');

            $query2 ="SELECT * FROM trongate_user_levels";
            $roles = $this->model->query($query2,'object');

            $data = [
                'employee' => $employee,
                'roles' => $roles
            ];

            $data['page_title'] = 'Update Employee';
            $data['view_file'] = 'update_employee';
            $data['view_module'] = 'employee';

            $this->template('dashboard', $data);   
        }
    }
    function delete($id){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $query = "DELETE FROM employees WHERE employee_id ='$id'";
            $this->model->query($query,'object');
            set_flashdata([
                'type' => 'success',
                'message' => 'Employee have been deleted'
            ]);
            redirect('/employee/views');
        }
        
    }
}