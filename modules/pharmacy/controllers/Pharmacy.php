<?php

class Pharmacy extends Trongate
{
    public function index()
    {
        $data['view_file'] = 'dashboard';
        $data['view_module'] = 'pharmacy';
        $data['page_title'] = 'Pharmacy';
        $this->template('pharmacy', $data);
    }

    public function dashboard()
    {

    }
}
