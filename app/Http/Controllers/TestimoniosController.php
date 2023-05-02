<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestimoniosController extends Controller
{
    public function index()
    {
        return view('testimonios.index');
    }
}
