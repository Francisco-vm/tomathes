<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        require __DIR__ . '/../views/home.php';
    }
}
