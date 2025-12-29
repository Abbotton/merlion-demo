<?php

namespace App\Pages;

use Merlion\Http\Controllers\Home;

class Dashboard extends Home
{
    public function __invoke()
    {
        return admin()
            ->content(view('dashboard'))
            ->render();
    }
}
