<?php 
/**
 * DefaultController class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * DefaultController model for processing client requests
 * @package controllers
 */
class DefaultController
{
    /**
     * @var string rendered page title
     */
    public $title = 'Main page';
    /**
     * @var string action name (e.g. 'index' for 'actionIndex' method)
     */
    public $action;
    /**
     * @var array data for displaing in view 
     */
    public $data = array();
    /**
     * @var string error request processing error for displaying in view
     */
    public $error;
    /**
     * starts controller, renders action according to get params
     * @uses DefaultController::runAction()
     */
    public function run()
    {
        //print_r(Tiny::app()->user->data);
        $action = isset($_GET['q']) 
            ? str_replace('/', '', $_GET['q'])
            : 'index';
        $this->runAction($action);
    }
    /**
     * runs named action method
     * @param string $action action name to run
     */
    public function runAction($action)
    {
        $this->action = $action;
        call_user_func(array($this, 'action'. ucfirst($this->action)));
    }
    /**
     * menu for current view
     * @return array menu items (url, title)
     */
    public function menu()
    {
        $result = array(
            array('url'   => '/', 'title' => 'Home')
        );
        if(Tiny::app()->user->data){
            $result[] = array('url'   => '/account', 'title' => 'Account');
            $result[] = array('url'   => '/logout', 'title' => 'Logout');
        }else{
            $result[] = array('url'   => '/login', 'title' => 'Login');
        }
        return $result;
    }
    /**
     * index action
     */
    public function actionIndex()
    {
        $this->render('index');
    }
    /**
     * logs user in
     * @return boolean if redirects
     */
    public function actionLogin()
    {
        $this->title = "User Account";
        $data = array(); 
        if(Tiny::app()->user->data){
            return $this->redirect('/account');
        }
        if($post = @$_POST['LoginForm']){
            if($user = Tiny::app()->api->userGet($post)){
                Tiny::app()->user->login($user);
                $this->redirect('/account');
            }
            $data['LoginForm'] = $post;
        }
        $this->error = Tiny::app()->api->error;
        $this->render('login', $data);
    }
    /**
     * logs user out
     */
    public function actionLogout()
    {
        Tiny::app()->user->logout();
        $this->redirect('/index');
    }
    /**
     * registers user
     * @return boolean if redirects
     */
    public function actionRegister()
    {
        $this->title = "Registration";
        
        if(Tiny::app()->user->data){
            return $this->redirect('/account');
        }
        if(($data = @$_POST['LoginForm']) && ($user = Tiny::app()->api->userCreate($data))){
            Tiny::app()->user->login($user);
            return $this->redirect('/account');
        }
        
        $data = array(
            'LoginForm' => Tiny::app()->api->userChallenge()->response['challenge']
        );
        $this->error = Tiny::app()->api->error;
        $this->render('register', $data);
    }
    /**
     * renders users account view and updates it via POST
     */
    public function actionAccount()
    {
        $this->title = "User Account";
        $data = array(
            'LoginForm' => Tiny::app()->api->userGet(Tiny::app()->user->data)
        );        
        if($post = @$_POST['LoginForm']){
            $post['api_token'] = Tiny::app()->user->data['api_token'];
            if(Tiny::app()->api->userUpdate($post)){
                unset($post['password']);
                Tiny::app()->user->login($post);
                $this->redirect('/account');
            }
            $data['LoginForm'] = $post;
        }
        $this->error = Tiny::app()->api->error;
        $this->render('account', $data);
    }
    /**
     * renders view file
     * @param string $view view file name
     * @param array $data variables to add to view
     */
    public function render($view, $data = array())
    {
        $this->data = $data;
        $this->view = ROOT . DS . 'views' . DS . "{$view}.php";
        include_once ROOT . DS . 'views' . DS . 'layout.php';
    }
    /**
     * redirects to another url
     * @param string $url url to redirect to
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}

