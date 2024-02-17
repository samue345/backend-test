<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RedirectLog;

class RedirectsController extends Controller
{
  public function showStats(RedirectLog $redirect){
        return $redirect;
  }
}
