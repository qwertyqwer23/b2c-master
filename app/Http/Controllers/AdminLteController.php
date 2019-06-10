<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLteController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminlte');
    }
	
	public function original_q1_form()
	{
		return view('original_q1');
	}
	
	public function original_q3_form()
	{
		return view('original_q3');
	}
	public function original_q4_form()
	{
		return view('original_q4');
	}
	
	public function master_q1_form()
	{
		return view('original_q1');
	}
	
	public function master_q3_form()
	{
		return view('original_q3');
	}
	public function master_q4_form()
	{
		return view('original_q4');
	}
	
	public function test_queries()
    {
        return view('test_queries');
    }
	
}