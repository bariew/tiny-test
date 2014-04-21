<?php
/**
 * User class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * model for creating and storing user data into session
 * @package models
 */
class User
{
    /**
     * @var array user data
     */
    public $data = array();
    /**
     * starts and restores session data
     */
    public function init()
    {
        session_start();
        if(isset($_SESSION['user'])){
            $this->data = unserialize($_SESSION['user']);
        }
    }
    /**
     * stores data into session
     * @param array $data user data (e.g. name, email etc)
     */
    public function login($data)
    {
        $this->data = $data;
        $_SESSION['user'] = serialize($data);
    }
    /**
     * destroys user session
     */
    public function logout()
    {
        $this->data = array();
        session_destroy();
    }
}