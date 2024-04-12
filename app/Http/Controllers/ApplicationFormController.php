<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationFormController extends Controller
{
    public function index()
    {
        // You can perform additional checks or pass data to the view here
        return view('application-form.index');
    }
}
