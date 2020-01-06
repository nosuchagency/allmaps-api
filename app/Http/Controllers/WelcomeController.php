<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WelcomeController extends Controller
{

    /**
     * @return View
     */
    public function index()
    {
        return view('welcome');
    }
}
