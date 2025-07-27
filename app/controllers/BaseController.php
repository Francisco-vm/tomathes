<?php

namespace App\Controllers;

abstract class BaseController
{
    public function __construct()
    {
        require_once __DIR__ . '/../middlewares/session.php';
    }
}
