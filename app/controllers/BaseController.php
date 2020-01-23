<?php

namespace App\Controllers;

use Igoframework\Core\Base\Controller;

class BaseController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
    }
}