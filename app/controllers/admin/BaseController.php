<?php

namespace App\Controllers\Admin;

use Igoframework\Core\Base\Controller;
use App\Models\Users;

class BaseController extends Controller
{
    protected $layout = 'default';

    public function __construct($route)
    {
        parent::__construct($route);
    }
}