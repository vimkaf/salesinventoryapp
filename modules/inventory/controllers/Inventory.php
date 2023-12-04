<?php

class Inventory extends Trongate{

    
    function _add_to_inventory($quantity, $product_id, $warehouse_id, $reorder_level, $purchase_order_number){

        $query = "SELECT * FROM inventory WHERE product_id = $product_id AND warehouse_id = $warehouse_id";
        
        $inventory = $this->model->query($query, "object");
        
        $inventoryID = null;

    
        if(count($inventory) === 1){

            $id = $inventoryID = $inventory[0]->inventory_id;

            $new_quantity = $quantity + $inventory[0]->quantity_on_hand;

            try{
                $this->model->update_where('inventory_id', $id, ['quantity_on_hand' => $new_quantity]);
            }
            catch(\PDOException $e){
                return false;
            }
        }


        if(count($inventory) === 0){

            try{
                $inventoryID = $this->model->insert([
                    'quantity_on_hand' => $quantity,
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'reorder_level' => $reorder_level
                ]);
            }
            catch(\PDOException $e){
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


    function _add_inventory_transaction($inventory_id, $quantity, $reference_id, $type, $remarks = ''){

        $employee = $_SESSION['employee'];

        try{
            
            $data = [
                'inventory_id' => $inventory_id,
                'transaction_type' => $type,
                'quantity' => $quantity,
                'transaction_date' => date('Y-m-d'),
                'employee_id' => $employee->employee_id,
                'remarks' => $remarks,
            ];

            if(!empty($reference_id)){
                $data['reference_id'] = $reference_id;
            }

            $this->model->insert($data, "inventory_transactions");
        }
        catch(\PDOException $e){
            return false;
        }
    }


}