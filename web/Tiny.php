<?php 
class Tiny
{
    public $config = array();
    public $api;
    public $controller;
    public $user;
    
    
    private static $_app;
    
    public static function app()
    {
        return self::$_app;
    }
    
    public static function init($config = array())
    {
        $app = new self;
        spl_autoload_register(array($app, "customAutoloader"));
        $app->config = $config;
        $app->setController()
            ->setApi()
            ->setUser();
        self::$_app = $app;
        self::app()->controller->run();
    }
    
    private function setController()
    {
        $this->controller = new DefaultController();
        return $this;
    }
    
    private function setApi()
    {
        $this->api = new ApiExtension($this->config['api']);
        return $this;
    }
    
    private function setUser()
    {
        $this->user = new User;
        $this->user->init();
        return $this;
    }
    
    private function customAutoloader($class_name)
    {
        if(class_exists($class_name))
            return true;

        foreach($this->dirs() as $directory)
        {
            $files = scandir($directory);

            if(in_array($class_name.".php", $files))
            {
                require_once($directory. DS .$class_name.".php");
                return true;
            }
        }
        return false;
    }

    public function dirs()
    {
        return array(
            ROOT, 
            ROOT . DS . 'models',
            ROOT . DS . 'controllers',
            ROOT . DS . 'api'
        );
    }
}

