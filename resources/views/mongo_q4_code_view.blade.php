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
    <p class="h1_p">{ </p> 
		<p class="h2_p">"$match":{</p>  
			<p class="h3_p">"ORDERDATE":{</p>  
				<p class="h4_p">"$gte": "1990-01-01"</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
	<p class="h1_p">},</p>
    <p class="h1_p">{</p>  
		<p class="h2_p">"$match":{ </p> 
			<p class="h3_p">"ORDERDATE":{</p>  
				<p class="h4_p">"$lt": "2000-01-01"</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
	<p class="h1_p">},</p>
    <p class="h1_p">{</p>
        <p class="h2_p">"$lookup":{</p>
			<p class="h3_p">"from": "lineitems",</p>
            <p class="h3_p">"localField": "ORDERKEY",</p>
            <p class="h3_p">"foreignField": "ORDERKEY",</p>
            <p class="h3_p">"as": "lineitems"</p>
        <p class="h2_p">}</p>
    <p class="h1_p">},</p>
    <p class="h1_p">{ </p> 
		<p class="h2_p">"$project":{ </p> 
			<p class="h3_p">"ORDERDATE":1,</p>
			<p class="h3_p">"ORDERPRIORITY":1,</p>
			<p class="h3_p">"eq":{ </p> 
				<p class="h4_p">"$cond":[ </p> 
					<p class="h5_p">{</p>  
						<p class="h6_p">"$lt":[ </p> 
							<p class="h7_p">"$lineitems.RECEIPTDATE",</p>
							<p class="h7_p">"$lineitems.COMMITDATE"</p>
						<p class="h6_p">]</p>
					<p class="h5_p">},</p>
					<p class="h5_p">0,</p>
					<p class="h5_p">1</p>
				<p class="h4_p">]</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
   <p class="h1_p">},</p>
   <p class="h1_p">{</p>  
		<p class="h2_p">"$match":{ </p> 
			<p class="h3_p">"eq":{</p>  
				<p class="h4_p">"$eq":1</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
   <p class="h1_p">},</p>
   <p class="h1_p">{ </p> 
		<p class="h2_p">"$group":{ </p> 
			<p class="h3_p">"_id":{ </p> 
				<p class="h4_p">"ORDERPRIORITY":"$ORDERPRIORITY"</p>
			<p class="h3_p">},</p>
			<p class="h3_p">"order_count":{</p>  
				<p class="h4_p">"$sum":1</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
   <p class="h1_p">},</p>
   <p class="h1_p">{ </p> 
		<p class="h2_p">"$sort":{ </p> 
			<p class="h3_p">"ORDERPRIORITY":1</p>
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