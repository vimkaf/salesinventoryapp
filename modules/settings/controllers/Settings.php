<?php
class Settings extends Trongate
{
    function site_settings()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->_show_site_settings();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->_save_site_settings();
        }


    }

    function _show_site_settings()
    {

        $data['settings'] = $this->model->query("SELECT * FROM settings", 'object');

        $data['view_module'] = "settings";
        $data['view_file'] = "site_settings";
        $data['page_title'] = 'Site Settings';


        $this->template('dashboard', $data);
    }

    function _save_site_settings()
    {

        $postData = $_POST;

        $data = [];

        foreach ($postData as $key => $val) {

            $query = "UPDATE settings SET setting_value = :val WHERE setting_name = :key";


            $this->model->query_bind($query, ['val' => $val, 'key' => $key]);


        }

        set_flashdata([
            'type' => 'success',
            'message' => 'Settings updated'
        ]);

        redirect('dashboard/settings/site');


    }
}