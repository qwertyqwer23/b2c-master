@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q3</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		<p class="h1_p">select</p>
			<p class="h2_p">l_orderkey,</p>
			<p class="h2_p"><b>sum</b>(l_extendedprice*(1-l_discount)) <b>as</b> revenue,</p>
			<p class="h2_p">o_orderdate,</p>
			<p class="h2_p">o_shippriority</p>
		<p class="h1_p">from</p>
			<p class="h2_p">customer,</p>
			<p class="h2_p">orders,</p>
			<p class="h2_p">lineitem</p>
		<p class="h1_p">where</p>
			<p class="h2_p">c_mktsegment = <span style="color: red;">'[SEGMENT]'</span> </p>
			<p class="h2_p"><b>and</b> c_custkey = o_custkey</p>
			<p class="h2_p"><b>and</b> l_orderkey = o_orderkey</p>
			<p class="h2_p"><b>and</b> o_orderdate < <span style="color: blue;">date </span> <span style="color: red;">'[DATE]'</span> </p>
			<p class="h2_p"><b>and</b> l_shipdate > <span style="color: blue;">date </span> <span style="color: red;">'[DATE]'</span> </p>
		<p class="h1_p">group by</p>
			<p class="h2_p">l_orderkey,</p>
			<p class="h2_p">o_orderdate,</p>
			<p class="h2_p">o_shippriority</p>
		<p class="h1_p">order by</p>
			<p class="h2_p">revenue desc,</p>
			<p class="h2_p">o_orderdate;</p>
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