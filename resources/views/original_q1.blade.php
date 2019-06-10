@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
	  <!-- post text -->
		<p class="h1_p">select</p>
			<p class="h2_p">l_returnflag,</p>
			<p class="h2_p">l_linestatus,</p>
			<p class="h2_p"> <b>sum</b>(l_quantity) <b>as</b> sum_qty,</p>
			<p class="h2_p"> <b>sum</b>(l_extendedprice) <b>as</b> sum_base_price,</p>
			<p class="h2_p"> <b>sum</b>(l_extendedprice*(1-l_discount)) <b>as</b> sum_disc_price,</p>
			<p class="h2_p"> <b>sum</b>(l_extendedprice*(1-l_discount)*(1+l_tax)) <b>as</b> sum_charge,</p>
			<p class="h2_p"> <b>avg</b>(l_quantity) <b>as</b> avg_qty,</p>
			<p class="h2_p"> <b>avg</b>(l_extendedprice) <b>as</b> avg_price,</p>
			<p class="h2_p"> <b>avg</b>(l_discount) <b>as</b> avg_disc,</p>
			<p class="h2_p"> <b>count</b>(*) <b>as</b> count_order</p>
		<p class="h1_p">from</p>
		   <p class="h2_p">lineitem</p>
		<p class="h1_p">where</p>
		   <p class="h2_p">l_shipdate <= <span style="color: blue;">date</span> <span style="color: red;">'1998-12-01'</span> - <span style="color: blue;">interval</span> <span style="color: red;">'[DELTA]'</span> <b>day</b> (3)</p>
		<p class="h1_p">group by</p>
		   <p class="h2_p">l_returnflag,</p>
		   <p class="h2_p">l_linestatus</p>
		<p class="h1_p">order by</p>
		   <p class="h2_p">l_returnflag,</p>
		   <p class="h2_p">l_linestatus;</p>
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