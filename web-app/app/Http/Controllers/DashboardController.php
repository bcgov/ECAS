<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


/*
 * Main Controller for the application
 */

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{


    /*
     * Main entry point for the single page Vue.js application
     */
    public function index(Request $request)
    {

        if(preg_match('~MSIE|Internet Explorer|Trident~i', $_SERVER['HTTP_USER_AGENT']))
        {
            // Do not display site to all versions of Internet Explorer
            return view('internet-explorer');
        }

        return view('dashboard');


    }

}
