<?php

namespace Myproject;

class Home extends \Calma\Mf\Controller
{

  protected $template = array(
    'index' => 'home/index',
    'member' => 'home/member',
    'protect' => 'home/protect'
  );

  public $credentials = array(
    'member' =>    ['MEMBER', 'ADMIN'],
    'protect' => ['ADMIN']
  );

  public function index()
  {
    return 'text/html';
  }

  public function member()
  {
    return 'text/html';
  }

  public function protect()
  {
    return 'text/html';
  }
}
