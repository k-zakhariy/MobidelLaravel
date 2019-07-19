<?php

namespace Zakhariy\MobidelLaravel\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zakhariy\MobidelLaravel\Facades\MobidelCallback;

class CallbackController extends Controller
{
    public function index(Request $request)
    {
        MobidelCallback::handleRequest($request);
    }
}