<?php 
class DefaultController
{
    public $title = 'Main page';
    public $action;
    public $data = array();
    public $error;
    
    public function run()
    {
        print_r(Tiny::app()->user->data);
        $action = isset($_GET['q']) 
            ? str_replace('/', '', $_GET['q'])
            : 'index';
        $this->runAction($action);
    }
    
    public function runAction($action)
    {
        $this->action = $action;
        return call_user_func(array($this, 'action'. ucfirst($this->action)));
    }
    
    public function menu()
    {
        $result = array(
            array(
                'url'   => '/',
                'title' => 'Home'
            )
        );
        if(Tiny::app()->user->data){
            $result[] = array(
                'url'   => '/account',
                'title' => 'Account'
            );
            $result[] = array(
                'url'   => '/logout',
                'title' => 'Logout'
            );
        }else{
            $result[] = array(
                'url'   => '/login',
                'title' => 'Login'
            );
        }
        return $result;
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
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
    
    public function actionLogout()
    {
        Tiny::app()->user->logout();
        $this->redirect('/index');
    }
    
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
    
    
    
    public function render($view, $data = array())
    {
        $this->data = $data;
        $this->view = ROOT . DS . 'views' . DS . "{$view}.php";
        include_once ROOT . DS . 'views' . DS . 'layout.php';
    }
    
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}

