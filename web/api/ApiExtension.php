<?php 
/**
 * ApiAextension class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * Model for remote tinypass api requests
 * @package api
 */
class ApiExtension
{
    /**
     * @var array tinypass init config
     */
    public $config = array();
    /**
     * @var string tinypass api base url
     */
    public $baseUrl = 'https://api.dev.swishu.com/';
    /**
     * @var array tinypass api response
     */
    public $response = false;
    /**
     * @var string tinypass api error message
     */
    public $error;
    /**
     * sets config data
     * @param array $config api config
     */
    public function __construct($config = array()) 
    {
        $this->config = $config;
    }
    /**
     * creates remote user
     * @param array $data request user data
     * @return array user data or false
     */
    public function userCreate($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/create', $data);
        return ($this->response) ? $this->response['user'] : false;
    }
    /**
     * gets session key and captcha for creating user
     * @return \ApiExtension self instance
     */
    public function userChallenge()
    {
        $this->simpleRequest($this->baseUrl . 'user/challenge/get', array('type'=>'image'));
        return $this;
    }
    /**
     * updates user account data
     * @param array $data user new data
     * @return boolean whether user has been updates
     */
    public function userUpdate($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/update', $data);
        return ($this->response) ? true : false;
    }    
    /**
     * gets remote api user data
     * @param array $data user data (token or email/passord)
     * @return array user data or false
     */
    public function userGet($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/get', $data);
        return ($this->response) ? $this->response['user'] : false;
    }    
    /**
     * processes simple remote api request
     * @param string $url remote url
     * @param array $data get params
     */
    public function simpleRequest($url, $data)
    {
        if($data){
            $url .= '?' . http_build_query($data);
        }
        
        $result = json_decode(file_get_contents($url), true);
        if (json_last_error()) {
            $this->error = "Could not connect to server";
        } else if($result['code'] !== 0){
            $this->error = $result['message'];
        } else {
            $this->response = $result;
        }
    }
}