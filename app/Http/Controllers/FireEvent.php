<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MyEvent;

class FireEvent extends Controller
{
    public function fire()
    {
        event(new MyEvent('hello world'));
    }
}
