@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		<p class="h2_p"><span style="color: blue;">SELECT</span> returnflag, linestatus,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(quantity) <span style="color: blue;">as</span> sum_qty,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(extendedprice) <span style="color: blue;">as</span> sum_base_price,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(CASSANDRA_EXAMPLE_KEYSPACE.fSumDiscPrice(extendedprice,discount)) <span style="color: blue;">as</span> sum_disc_price,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(CASSANDRA_EXAMPLE_KEYSPACE.fSumChargePrice(extendedprice,discount,tax)) <span style="color: blue;">as</span> sum_charge,</p>
		<p class="h2_p"><span style="color: blue;">avg</span>(quantity) <span style="color: blue;">as</span> avg_qty, avg(extendedprice) <span style="color: blue;">as</span> avg_price,</p>
		<p class="h2_p"><span style="color: blue;">avg</span>(discount) <span style="color: blue;">as</span> avg_disc,</p>
		<p class="h2_p">count(*) <span style="color: blue;">as</span> count_order</p>
		<p class="h2_p"><span style="color: blue;">FROM</span> </p>
		<p class="h2_p">CASSANDRA_EXAMPLE_KEYSPACE.TPCH_Q1</p>
		<p class="h2_p"><span style="color: blue;">WHERE</span> shipdate < <span style="color: green;">'912524220'</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> returnflag= <span style="color: green;">'N'</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> linestatus = <span style="color: green;">'O'</span></p>
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