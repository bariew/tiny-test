<?php 
class ApiExtension
{
    public $config = array();
    public $baseUrl = 'https://api.dev.swishu.com/';
    public $response = false;
    public $error;
    
    public function __construct($config = array()) 
    {
        $this->config = $config;
    }
    
    public function userCreate($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/create', $data);
        return ($this->response) ? $this->response['user'] : false;
    }
    
    public function userChallenge()
    {
        $this->simpleRequest($this->baseUrl . 'user/challenge/get', array('type'=>'image'));
        return $this;
    }
    
    public function userUpdate($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/update', $data);
        return ($this->response) ? true : false;
    }    
    
    public function userGet($data)
    {
        $this->simpleRequest($this->baseUrl . '/user/get', $data);
        return ($this->response) ? $this->response['user'] : false;
    }    
    
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
    
    public function request($url, $post = array())
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        if($post){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));            
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        if (json_last_error()) {
            $this->error = "Could not connect to server";
        } else if($result['code'] !== 0){
            $this->error = 'Wrong data';
        } else {
            $this->response = $result;
        }
        curl_close ($ch);
    }
}