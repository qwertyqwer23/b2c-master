@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
	
	<p class="h1_p">db.orders.aggregate([</p>
	<p class="h1_p">{</p>  
		<p class="h2_p">"$match":{ </p> 
			<p class="h3_p">"ORDERDATE":{ </p> 
				<p class="h4_p">"$lte": "1998-12-01"</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{</p>
			<p class="h3_p">$lookup:{</p>
				<p class="h4_p">from: "lineitems",</p>       
				<p class="h4_p">localField: "ORDERKEY", </p>  
				<p class="h4_p">foreignField: "ORDERKEY", </p>
				<p class="h4_p">as: "lineitems"</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{</p>
			<p class="h3_p">$lookup:{</p>
				<p class="h4_p">from: "customers",</p>       
				<p class="h4_p">localField: "CUSTKEY",</p>   
				<p class="h4_p">foreignField: "CUSTKEY",</p>
				<p class="h4_p">as: "customer"</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{  </p>
			<p class="h3_p">"$match":{</p>  
				<p class="h4_p">"customer.MKTSEGMENT":"AUTOMOBILE",</p>
				<p class="h4_p">"lineitems.SHIPDATE":{</p>  
					<p class="h5_p">"$gte": "1990-01-01"</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{ </p> 
			<p class="h3_p">"$unwind":"$lineitems"</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{ </p> 
			<p class="h3_p">"$project":{ </p> 
				<p class="h4_p">"ORDERDATE":1,</p>
				<p class="h4_p">"SHIPPRIORITY":1,</p>
				<p class="h4_p">"lineitems.EXTENDEDPRICE":1,</p>
				<p class="h4_p">"l_dis_min_1":{</p>  
					<p class="h5_p">"$subtract":[ </p> 
						<p class="h6_p">1,</p>
						<p class="h6_p">"$lineitems.DISCOUNT"</p>
					<p class="h5_p">]</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{ </p> 
			<p class="h3_p">"$group":{</p>  
				<p class="h4_p">"_id":{ </p> 
					<p class="h5_p">"ORDERKEY":"$ORDERKEY",</p>
					<p class="h5_p">"ORDERDATE":"$ORDERDATE",</p>
					<p class="h5_p">"SHIPPRIORITY":"$SHIPPRIORITY"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"revenue":{</p>  
					<p class="h5_p">"$sum":{</p>  
						<p class="h6_p">"$multiply":[ </p> 
							<p class="h7_p">"$lineitems.EXTENDEDPRICE",</p>
							<p class="h7_p">"$l_dis_min_1"</p>
						<p class="h6_p">]</p>
					<p class="h5_p">}</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{</p>  
			<p class="h3_p">"$sort":{</p>  
				<p class="h4_p">"revenue":1,</p>
				<p class="h4_p">"ORDERDATE":1</p>
			<p class="h4_p">}</p>
		<p class="h2_p">}</p> 
	<p class="h1_p">}</p>
	<p class="h1_p">])</p>
	</div>
</div>
<style>
.queries-form p { 
  margin-bottom: 0;
  font-family: "Arial", Arial, cursive; font-size: 16px;
}

.queries-form .h1_p{ 
  margin-left: 5px;
}
.queries-form .h2_p{ 
  margin-left: 25px;
}
.queries-form .h3_p{ 
  margin-left: 45px;
}
.queries-form .h4_p{ 
  margin-left: 65px;
}
.queries-form .h5_p{ 
  margin-left: 85px;
}
.queries-form .h6_p{ 
  margin-left: 105px;
}
.queries-form .h7_p{ 
  margin-left: 125px;
}
.queries-form .h8_p{ 
  margin-left: 145px;
}
.queries-form .h9_p{ 
  margin-left: 165px;
}
</style>