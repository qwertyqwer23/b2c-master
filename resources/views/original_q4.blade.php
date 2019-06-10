@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q4</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
		
		<p class="h1_p">select</p>
			<p class="h2_p">o_orderpriority,</p>
			<p class="h2_p"><b>count</b>(*) <b>as</b> order_count</p>
		<p class="h1_p">from</p>
			<p class="h2_p">orders</p>
		<p class="h1_p">where</p>
			<p class="h2_p">o_orderdate >= <span style="color: blue;">date</span> <span style="color: red;">'[DATE]'</span></p>
			<p class="h2_p"><b>and</b> o_orderdate < <span style="color: blue;">date</span> <span style="color: red;">'[DATE]'</span> + <span style="color: blue;">interval</span> <span style="color: red;">'3'</span> <b>month</b></p>
			<p class="h2_p"> <b>and exists</b> (</p>
				<p class="h3_p">select</p>
					<p class="h4_p">*</p>
				<p class="h3_p">from</p>
					<p class="h4_p">lineitem</p>
				<p class="h3_p">where</p>
					<p class="h4_p">l_orderkey = o_orderkey</p>
					<p class="h4_p"><b>and</b> l_commitdate < l_receiptdate</p>
			<p class="h2_p">)</p>
		<p class="h1_p">group by</p>
		<p class="h2_p">o_orderpriority</p>
		<p class="h1_p">order by</p>
		<p class="h2_p">o_orderpriority;</p>
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
.queries-form .h3_p{ 
  font-weight: bold;
  margin-left: 35px;
}
.queries-form .h4_p{ 
  margin-left: 45px;
}
</style>