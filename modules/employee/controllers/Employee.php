<?php 
class Employee extends Trongate{
    function add(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
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
            $data['page_title'] = 'Views Employee';
            $data['view_file'] = 'view_employee';
            $data['view_module'] = 'employee';

            $query = "SELECT * FROM employees";
            $employees = $this->model->query($query,'object');
            $data = [
                'employees' => $employees
            ];
            
            $this->template('dashboard', $data);
        }

    }
}