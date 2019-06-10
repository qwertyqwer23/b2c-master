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
		(<span style="color: blue;">order:Order</span>) -[<span style="color: blue;">:CONTAINS</span>]-> (<span style="color: blue;">item:Lineitem</span>)</p>
		<p class="h2_p"><span style="color: blue;">WHERE</span> item.COMMITDATE < item.RECEIPTDATE</p>
		<p class="h2_p"><span style="color: blue;">AND</span> order.ORDERDATE >= <span style="color: green;">631205820</span></p>
		<p class="h2_p"><span style="color: blue;">AND</span> order.ORDERDATE < <span style="color: green;">9125242200</span></p>
		<p class="h2_p"><span style="color: blue;">RETURN</span> order.ORDERPRIORITY, count(*) <span style="color: blue;">AS</span> ORDER_COUNT</p>
		<p class="h2_p"><span style="color: blue;">ORDER BY</span> order.ORDERPRIORITY</p>
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