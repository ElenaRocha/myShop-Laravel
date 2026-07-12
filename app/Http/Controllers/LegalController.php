<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('legal', ['title' => 'messages.privacy.title', 'body' => 'messages.privacy.body']);
    }

    public function terms(): View
    {
        return view('legal', ['title' => 'messages.terms.title', 'body' => 'messages.terms.body']);
    }

    public function cookies(): View
    {
        return view('legal', ['title' => 'messages.cookies.title', 'body' => 'messages.cookies.body']);
    }
}