<?php

namespace App\Http\Controllers\StaticPageManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Hash;
use Mail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
 


class StaticPageController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()	
    {
         
    }


    /**
     * Dashboard landing function
     *
     * @return void
     */

    public function index()
    {
      //  return view('user.dashboard.dashboard_view');
    }
	
	
	public function sitePolicy()
    {
        return view('static_page.policy_view');
    }
	
	public function siteTerms()
    {
        return view('static_page.terms_view');
    }
	
	
	
	
}