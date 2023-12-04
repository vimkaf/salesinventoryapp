<?php 
class Sales extends Trongate{
    //add sales
    function add(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_add_sales();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->save_sales();
        }
    }
    function get_add_sales(){
        $sql1 = "SELECT * FROM products";
        $products = $this->model->query($sql1,'object');

        $sql2 = "SELECT * FROM customers";
        $customers = $this->model->query($sql2,'object');
        $sql3 = "SELECT * FROM warehouses";
        $warehouses = $this->model->query($sql3,'object');

        $data = [
            'products' => $products,
            'customers' => $customers,
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'Add Sales';
        $data['view_file'] = 'add_sales';
        $data['view_module'] = 'sales';

        $this->template('dashboard', $data);
    }
    function save_sales(){
        $data['product_id'] = post('product_id');
        $data['quantity_sold'] = post('quantity_sold');
        $data['date_of_sale'] = post('date_of_sale');
        $data['total_price'] = post('price');
        $data['customer_id'] = post('customer_id');
        $data['warehouse_id'] = post('warehouse_id');

        $data['price'] = post('price');
        $data['status'] = post('status');
        $data['employee_id'] = $_SESSION['employee']->employee_id;

        $this->model->insert($data,'sales');
        set_flashdata([
            'type' => 'success',
            'message' => 'Sales have been added'
            ]);
        redirect('/sales/add');
    }
    //list sales
    function list(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_list();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            
        }
    }
    function get_list(){
        
        $sql ="SELECT * FROM sales LEFT JOIN products ON products.product_id = sales.sale_id" ;

        $sales = $this->model->query($sql,'object');
        //another queary for left join

        /*$ customers LEFT JOIN warehouses ON customers.customer_id = warehouses.warehouse_id";*/

        $data = [
            'sales' => $sales
        ];
        $data['page_title'] = ' Sales';
        $data['view_file'] = 'lists';
        $data['view_module'] = 'sales';
        
        $this->template('dashboard', $data);
    }
    
    

}