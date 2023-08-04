<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factor;
use Illuminate\View\View;

class AppController extends Controller
{
  /**
   * @return Application|Factor|View
   */
  public function index()
  {
    return view('welcome');
  }
}