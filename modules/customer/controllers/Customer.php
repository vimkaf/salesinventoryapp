<?php
class Customer extends Trongate
{

    function _get()
    {
        return $this->model->query("SELECT * FROM customers", 'object');
    }
    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $data['page_title'] = 'Add customer';
            $data['view_file'] = 'add_customer';
            $data['view_module'] = 'customer';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->add_customer();
        }
    }

    function _create()
    {

        $data['first_name'] = post('first_name');
        $data['last_name'] = post('last_name');
        $data['email'] = post('email');
        $data['phone_number'] = post('phone_number');
        $data['address'] = post('address');

        return $this->model->insert($data, 'customers');

    }

    function add_customer()
    {

        $customerID = $this->_create();

        set_flashdata([
            'type' => 'success',
            'message' => 'Customer have been Added'
        ]);

        redirect('dashboard/customer/add');
    }

    function list()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $query = "SELECT * FROM customers";
            $customers = $this->model->query($query, 'object');

            $data = [
                'customers' => $customers
            ];

            $data['page_title'] = 'View customer';
            $data['view_file'] = 'view_customer';
            $data['view_module'] = 'customer';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }


    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id = (int) $id;
            $query = "SELECT * FROM customers WHERE customer_id ='$id'";
            $customer = $this->model->query($query, 'object');

            $data = [
                'customer' => $customer
            ];

            $data['page_title'] = 'Update customer';
            $data['view_file'] = 'update_customer';
            $data['view_module'] = 'customer';

            $this->template('dashboard', $data);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->update();
        }
    }
    function update()
    {
        $id = post('customer_id');
        $data['first_name'] = post('first_name');
        $data['last_name'] = post('last_name');
        $data['email'] = post('email');
        $data['phone_number'] = post('phone_number');
        $data['address'] = post('address');

        $this->model->update_where('customer_id', $id, $data, 'customers');

        set_flashdata([
            'type' => 'success',
            'message' => 'Customer has been updated successfully'
        ]);
        redirect('dashboard/customer/view');
    }

    function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $query = "DELETE FROM customers WHERE customer_id ='$id'";
            $this->model->query($query, 'object');
            set_flashdata([
                'type' => 'success',
                'message' => 'Customer have been deleted'
            ]);
            redirect('dashboard/customer/view');
        }
    }

    function _customer_record(int $customerID)
    {
        $query = "SELECT * FROM customers WHERE customer_id = :customerID";
        return $this->model->query_bind($query, ['customerID' => $customerID], 'object');
    }
}