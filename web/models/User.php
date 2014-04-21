<?php 
class User
{
    public $id;
    public $data = array();
    
    public function init()
    {
        session_start();
        if(isset($_SESSION['user'])){
            $this->data = unserialize($_SESSION['user']);
        }
    }
    
    public function login($data)
    {
        $this->data = $data;
        $_SESSION['user'] = serialize($data);
    }
    
    public function logout()
    {
        session_destroy();
    }
}