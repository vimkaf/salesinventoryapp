<?php

class Products extends Trongate{

    function _make_sure_allowed(int|array $userLevels = null){
        $this->module('trongate_tokens');

        $token = $this->trongate_tokens->_attempt_get_valid_token($userLevels);

        if($token === false){
            set_flashdata([
                'type' => 'warning',
                'message' => 'You are not allowed to peform that action'
            ]);

            redirect('/dashboard');
        }
        else{
            return $token;
        }
    }

    function add(){
        $this->view('add_product');
    }

    function list(){
        $this->_make_sure_allowed(2);

        echo "Products list should appeare here";
    }
    function list_product(){
        $this->view('list_products');
    }
    function import_product(){
        $this->view('import_products');
    }
    function count_stock(){
        $this->view('count_stocks');
    }
    function stock_count(){
        $this->view('stock_counts');
    }
}