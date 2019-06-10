@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		<p class="h2_p"><span style="color: blue;">MATCH</span>
		(item:Lineitem) <-[:<span style="color: blue;">CONTAINS</span>]- (<span style="color: blue;">order:Order</span> ) -[:<span style="color: blue;">CREATED_BY</span>]-> (customer:Customer)</p>
		<p class="h2_p"><span style="color: blue;">WHERE</span> order.ORDERDATE < <span style="color: green;">912524220</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> item.SHIPDATE > <span style="color: green;">631205820</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> customer.MKTSEGMENT = <span style="color: green;">'AUTOMOBILE'</span></p>
		<p class="h2_p"><span style="color: blue;">RETURN</span> order.id,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(item.EXTENDEDPRICE*(1-item.DISCOUNT)) <span style="color: blue;">AS</span> REVENUE,</p>
		<p class="h2_p">order.ORDERDATE,</p>
		<p class="h2_p">order.SHIPPRIORITY</p>
		<p class="h2_p"><span style="color: blue;">ORDER BY</span> REVENUE <span style="color: blue;">DESC</span>, order.ORDERDATE</p>
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