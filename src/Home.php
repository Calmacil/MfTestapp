<?php

namespace Myproject;

class Home extends \Calma\Mf\Controller
{

  protected $template = array(
    'index' => 'home/index',
    'member' => 'home/member',
    'protect' => 'home/protected'
  );

  public $credentials = array(
    'member' =>    ['MEMBER', 'ADMIN'],
    'protect' => ['ADMIN']
  );

  public function index()
  {
    $this->notice('This is the Home Page!');
    return 'text/html';
  }

  public function member()
  {
    $this->notice('This is the members page!');
    return 'text/html';
  }

  public function protect()
  {
    $this->notice('This is the admin page!');
    return 'text/html';
  }
  
  public function login()
  {
    $this->notice('This is the login script!');
    $username = $this->post('username');
    $password = $this->post('password');
    $this->info('Checking for login and password');
    
    if ($this->app['security']->login($username, $password)) {
      $this->info('OK: User authentified, go on');
      return $this->redirect('member');
    }
    $this->info('KO: User rejected, go back');
    return $this->redirect('home');
  }
  
  public function logout()
  {
    $this->app['security']->logout();
    return $this->redirect('home');
  }
}
