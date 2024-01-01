<?php
class Receipts extends Trongate
{
    function receipt()
    {
        $this->view('receipts');
    }

    function _create_sales_receipt(int $saleID, int|float $amount, int|float $balance, int|float $change, int $customerID, int $employeeID, string $method = 'cash', string $date = null)
    {
        $data = [
            'sale_id' => $saleID,
            'receipt_number' => $this->_generate_receipt_number(),
            'date' => $date ?? date('Y-m-d'),
            'amount' => $amount,
            'balance' => $balance,
            'change' => 0,
            'customer_id' => $customerID,
            'employee_id' => $employeeID,
            'payment_method' => $method
        ];

        return $this->model->insert($data);
    }

    /**
     * @param int $receiptID
     */
    function _receipt_record(int $receiptID)
    {
        return $this->model->query_bind("SELECT * FROM receipts WHERE receipt_id = :receiptID", ['receiptID' => $receiptID], 'object');
    }

    /**
     * @param int $saleID
     */
    function _receipt_record_by_sale(int $saleID)
    {
        return $this->model->query_bind("SELECT * FROM receipts WHERE sale_id = :saleID", ['saleID' => $saleID], 'object');

    }

    private function _generate_receipt_number()
    {
        $lastID = $this->model->query("SELECT MAX(receipt_id) as id FROM receipts", 'object');

        $lastID = $lastID[0]->id ?? 0;
        $nextID = $lastID + 1;

        return str_pad($nextID, 5, '0', STR_PAD_LEFT); //000001
    }

    function pos_receipt(int $receiptID)
    {

        $this->module('sales');

        $this->module('warehouse');

        $this->module('customer');

        $this->module('employee');

        $receiptRecord = $this->_receipt_record($receiptID);

        if (empty($receiptRecord)) {
            redirect(previous_url());
        }

        $saleRecord = $this->sales->_sales_record($receiptRecord[0]->sale_id);

        $saleItemsRecord = $this->sales->_sales_items_record($receiptRecord[0]->sale_id);

        $warehouseRecord = $this->warehouse->_warehouse_record($saleRecord[0]->warehouse_id);

        $customerRecord = $this->customer->_customer_record($saleRecord[0]->customer_id);

        $employeeRecord = $this->employee->_employee_record($receiptRecord[0]->employee_id);

        $receiptsRecord = $this->_receipt_record_by_sale($saleRecord[0]->sale_id);


        $totalPayments = array_reduce($receiptsRecord, function ($carry, $receipt) {

            return $carry += $receipt->amount;
        }, 0);



        $data['page_title'] = 'Sales Receipt';
        $data['view_module'] = 'receipts';
        $data['view_file'] = 'pos_receipt';
        $data['receipt'] = $receiptRecord[0];
        $data['total_payments'] = $totalPayments;

        $data['sale'] = $saleRecord[0];
        $data['saleItems'] = $saleItemsRecord;
        $data['warehouse'] = $warehouseRecord[0];
        $data['customer'] = $customerRecord[0];
        $data['employee'] = $employeeRecord[0];
        $data['numberFormat'] = numfmt_create('en_NG', NumberFormatter::CURRENCY);

        $this->view('pos_receipt', $data);

    }
}
