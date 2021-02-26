<?php
/*
  Name of Page: Users model

  Method: Users model, used for log in users, searching and working with permissions

  Date created: Nikita Zaharov, 14.03.2019

  Use: For searching, verificating users. Also this model provide method for work with permissions

  Input parameters:
  $db: database instance

  Output parameters:
  $users: model, it is responsible for working with users and them permissions

  Called from:
  + most controllers most controllers from /controllers

  Calls:
  sql

  Last Modified: 25.05.2019
  Last Modified by: Nikita Zaharov
*/

use Gregwar\Captcha\CaptchaBuilder;

require_once 'models/APIProxy.php';

class openshift extends APIProxy{
    public $captchaBuilder = false;
    
    public $validateTerminalID = false;
    public $shiftID = '';

    public function __construct(){
        $this->captchaBuilder = new CaptchaBuilder;
    }

}