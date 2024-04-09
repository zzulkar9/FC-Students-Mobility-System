<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseHandbookController extends Controller
{
    public function index()
    {
        // Assuming you have a model for CourseHandbook
        // $handbooks = CourseHandbook::all();

        // return view('course-handbook.index', compact('handbooks'));
        // For now, just return an empty view until the model and data are set up
        return view('course-handbook.index');
    }
}
