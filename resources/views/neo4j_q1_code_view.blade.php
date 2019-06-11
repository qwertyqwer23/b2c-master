@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		<p class="h2_p"><span style="color: blue;">MATCH</span> (item:Lineitem)</p>
		<p class="h2_p"><span style="color: blue;">WHERE</span> item.SHIPDATE <= <span style="color: green;">912524220</span></p>
		<p class="h2_p"><span style="color: blue;">RETURN</span> item.RETURNFLAG,</p>
		<p class="h2_p">item.LINESTATUS,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(item.QUANTITY) <span style="color: blue;">AS</span> sum_qty,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(item.EXTENDEDPRICE) <span style="color: blue;">AS</span> sum_base_price,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(item.EXTENDEDPRICE*(1-item.DISCOUNT)) <span style="color: blue;">AS</span> sum_disc_price,</p>
		<p class="h2_p"><span style="color: blue;">sum</span>(item.EXTENDEDPRICE*(1-item.DISCOUNT)*(1+item.TAX)) <span style="color: blue;">AS</span> sum_charge,</p>
		<!--<p class="h2_p"><span style="color: blue;">avg</span>(item.QUANTITY) <span style="color: blue;">AS</span> avg_qty,</p>-->
		<p class="h2_p"><span style="color: blue;">avg</span>(item.EXTENDEDPRICE) <span style="color: blue;">AS</span> avg_price,</p>
		<p class="h2_p"><span style="color: blue;">avg</span>(item.DISCOUNT) <span style="color: blue;">AS</span> avg_disc,</p>
		<p class="h2_p"><span style="color: blue;">COUNT</span>(*) <span style="color: blue;">AS</span> count_sum,</p>
		<p class="h2_p"><span style="color: blue;">ORDER BY</span> item.RETURNFLAG, item.LINESTATUS</p>
	
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