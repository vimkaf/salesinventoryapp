<?php
class Login extends Trongate
{
    function index()
    {
        $data['view_file'] = 'login';
        $data['view_module'] = 'login';
        $this->template('login', $data);
    }

    function check()
    {
        $this->validation_helper->set_rules('username', 'username', 'required|callback_login_check');
        $this->validation_helper->set_rules('password', 'password', 'required');

        $result = $this->validation_helper->run();


        if ($result === false) {
            redirect('login');
        }


        $username = post('username');

        $employee = $this->_login_user($username);

        $_SESSION['employee'] = $employee;

        redirect('dashboard');
    }

    function _hash_string($str)
    {
        $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
            'cost' => 11
        ));
        return $hashed_string;
    }

    function login_check($username)
    {
        $error_msg = "your username and/or password combination is invalid";

        $user_obj = $this->model->get_one_where('username', $username, 'user_login');
        if ($user_obj === false) {
            return $error_msg;
        }


        $password = post('password');
        $stored_password = $user_obj->password;
        $is_password_valid = $this->_verify_hash($password, $stored_password);

        if (!$is_password_valid) {
            return $error_msg;
        }

        return true;
    }

    function _login_user(string $username)
    {

        $user = $this->model->get_one_where('username', $username, 'user_login');

        $employee = $this->model->get_one_where('employee_id', $user->employee_id, 'employees');

        $trongate_user_id = $employee->trongate_user_id;

        $this->module('trongate_tokens');

        $this->trongate_tokens->_generate_token([
            'user_id' => $trongate_user_id
        ]);

        return $employee;
    }

    function _verify_hash($plain_text_str, $hashed_string)
    {
        $result = password_verify($plain_text_str, $hashed_string);
        return $result; //TRUE or FALSE
    }
}
