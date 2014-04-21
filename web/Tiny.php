<?php 
/**
 * Tiny class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * base application class
 * @package application
 */
class Tiny
{
    /**
     * @var array app config
     */
    public $config = array();
    /**
     * @var ApiExtension api instance
     */
    public $api;
    /**
     * @var DefaultController controller instance
     */
    public $controller;
    /**
     * @var User current user model instance 
     */
    public $user;
    /**
     * @var self instance of self
     */
    private static $_app;
    /**
     * setd autoload dirs using config
     * @return array folders to autoload from
     */
    public function dirs()
    {
        $root = dirname(__FILE__);
        $result = array($root);
        foreach ((array) @$this->config['import'] as $dir) {
            $result[] = $root . DIRECTORY_SEPARATOR . $dir;
        }
        return $result;
    }
    /**
     * singleton realisation
     * @return self self instance
     */
    public static function app()
    {
        return self::$_app;
    }
    /**
     * starts application
     * @param array $config app config
     */
    public static function init($config = array())
    {
        $app = new self;
        $app->config = $config;
        
        spl_autoload_register(array($app, "customAutoloader"));
        
        $app->setController()
            ->setApi()
            ->setUser();
        self::$_app = $app;
        self::app()->controller->run();
    }
    /**
     * sets controller instance
     * @return \Tiny this
     */
    private function setController()
    {
        $this->controller = new DefaultController();
        return $this;
    }
    /**
     * sets api instance
     * @return \Tiny this
     */
    private function setApi()
    {
        $this->api = new ApiExtension($this->config['api']);
        return $this;
    }
    /**
     * sets current user instance
     * @return \Tiny this
     */
    private function setUser()
    {
        $this->user = new User;
        $this->user->init();
        return $this;
    }
    /**
     * autoloads class from set folders
     * @param string $className class name 
     * @return boolean whether class is found
     */
    private function customAutoloader($className)
    {
        if (class_exists($className)) {
            return true;
        }
        foreach ($this->dirs() as $directory) {
            $files = scandir($directory);
            if (in_array($className.".php", $files)) {
                require_once($directory. DIRECTORY_SEPARATOR .$className.".php");
                return true;
            }
        }
        return false;
    }
}

