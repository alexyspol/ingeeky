<?php

namespace App\Controllers;

class PagesController extends BaseController
{
    public function home()
    {
        return view('pages/home');
    }

    public function about()
    {
        return view('pages/about');
    }

    public function services()
    {
        return view('pages/services');
    }

    public function contact()
    {
        return view('pages/contact');
    }
}
