<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{

    /**
     * WelcomeController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }
}
