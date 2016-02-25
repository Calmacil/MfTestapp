<?php
// overrides default Calma\Mf\Application

namespace Myproject;

use Calma\Mf\Application;
use Calma\Mf\Config;
use Calma\Mf\Security\SecurityPlugin;

class App extends Application
{
  public function __construct($root, $env="prod")
  {
    parent::__construct($root, $env);

    $this['security'] = new SecurityPlugin($this, Config::get($this->cfile)->security);
  }
}
