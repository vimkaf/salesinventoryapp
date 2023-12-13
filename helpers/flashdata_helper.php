<?php

/**
 * Set the toast flash data
 * 
 * Example: set_flashdata(['type' => 'error', 'message' => 'Error occured])
 * type key can be error, info, success, warning
 * 
 * @param array $msg
 * @version 1.0.0
 * @author ThaOracle <vimkaf@gmail.com>
 */

if (!function_exists('set_flashdata')) {
    function set_flashdata(array $msg): void
    {
        $_SESSION['flashdata'] = $msg;
    }
}
