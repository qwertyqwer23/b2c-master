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
	
	public function mongo_q1_code_view()
	{
		return view('mongo_q1_code_view');
	}
	
	public function mongo_q3_code_view()
	{
		return view('mongo_q3_code_view');
	}
	public function mongo_q4_code_view()
	{
		return view('mongo_q4_code_view');
	}
	
	public function neo4j_q1_code_view()
	{
		return view('neo4j_q1_code_view');
	}
	
	public function neo4j_q3_code_view()
	{
		return view('neo4j_q3_code_view');
	}
	
	public function neo4j_q4_code_view()
	{
		return view('neo4j_q4_code_view');
	}
	
	public function cassandra_q1_code_view()
	{
		return view('cassandra_q1_code_view');
	}
	
	public function cassandra_q3_code_view()
	{
		return view('cassandra_q3_code_view');
	}
	
	public function cassandra_q4_code_view()
	{
		return view('cassandra_q4_code_view');
	}
	
	public function test_queries()
    {
        return view('test_queries');
    }
	
}