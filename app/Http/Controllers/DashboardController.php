<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
        // todo
    }

    public function index()
    {
        $app_url = env('APP_URL');
        return view('dashboard', compact('app_url'));
    }
}
