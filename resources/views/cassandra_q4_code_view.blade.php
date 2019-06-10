@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		<p class="h2_p"><span style="color: blue;">SELECT</span></p>
		<p class="h2_p">o_orderpriority,</p>
		<p class="h2_p">count(*) as order_count</p>
		<p class="h2_p"><span style="color: blue;">FROM</span></p>
		<p class="h2_p">CASSANDRA_EXAMPLE_KEYSPACE.TPCH_Q4</p>
		<p class="h2_p"><span style="color: blue;">WHERE</span> o_orderdate >= <span style="color: green;">'1990-01-01'</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> o_orderdate < <span style="color: green;">'2000-01-01'</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> l_commitdate < <span style="color: green;">'2000-01-01'</span></p>
		<p class="h2_p">ALLOW FILTERING;</p>
	</div>
</div>
<style>
.queries-form p { 
  margin-bottom: 0;
  font-family: "Arial", Arial, cursive; font-size: 16px;
}

.queries-form .h1_p{ 
  margin-left: 5px;
  font-weight: bold;
}
.queries-form .h2_p{ 
  margin-left: 25px;
}
</style>