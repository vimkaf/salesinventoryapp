<?php 
class Login extends Trongate{
    function index(){
        $data['view_file'] = 'login';
        $data['view_module'] = 'login';
        $this->template('login',$data);
    }
    function log_me_in(){
        $this->validation_helper->set_rules('username','username','required|callback_login_check');
        $this->validation_helper->set_rules('password','password','required');

        $result = $this->validation_helper->run();
        
        
        if($result === false){
            redirect('login');
        }


        //$this->login_check($username);

       
    }
    function _hash_string($str){
        $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
            'cost' => 11
        ));
        return $hashed_string;
    }
    function login_check($username){
        $error_msg = "your username and/or password is not currect";
        $user_obj = $this->model->get_one_where('username',$username,'user_login');
        if($user_obj === false){
            return $error_msg;
        }else{
            $password = post('password');
            $stored_password = $user_obj->password;
            //$is_password_valid = $this->_verify_hash($password,$stored_password);
        }
    }
}