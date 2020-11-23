<?php

namespace App\Controllers;

use App\Models\User;

class HomeController
{
    public function index()
    {
        echo 'Home!';
    }

    public function about()
    {
        echo 'About!';
    }

    public function users()
    {
        header('Content-type: application/json');

        echo json_encode(
            User::get()
        );
    }
}
