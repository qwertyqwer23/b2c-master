@extends('adminlte::master')

<div class="box box-widget">
	<div class="box-header with-border">
		<div class="user-block">
			<span class="username">Interogarea Q1</span>
			<!--<span class="description">Shared publicly - 7:30 PM Today</span>-->
		</div> 
	</div>
	
	<div class="box-body queries-form" style="">
	
	<p class="h1_p">db.lineitems.aggregate(</p>
		<p class="h2_p">{</p>  
			<p class="h3_p">"$match":{</p>  
				<p class="h4_p">"SHIPDATE":{</p>  
					<p class="h5_p">"$lte": "1998-12-01"</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{</p>  
			<p class="h3_p">"$project":{ </p> 
				<p class="h4_p">"RETURNFLAG":1,</p>
				<p class="h4_p">"LINESTATUS":1,</p>
				<p class="h4_p">"QUANTITY":1,</p>
				<p class="h4_p">"EXTENDEDPRICE":1,</p>
				<p class="h4_p">"DISCOUNT":1,</p>
				<p class="h4_p">"l_dis_min_1":{</p>  
					<p class="h5_p">"$subtract":[ </p> 
						<p class="h6_p">1,</p>
						<p class="h6_p">"$DISCOUNT"</p>
					<p class="h5_p">]</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"l_tax_plus_1":{</p>  
					<p class="h5_p">"$add":[</p>  
					   <p class="h6_p">"$TAX",</p>
					   <p class="h6_p">1</p>
					<p class="h5_p">]</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{</p>  
			<p class="h3_p">"$group":{</p>  
				<p class="h4_p">"_id":{ </p> 
					<p class="h5_p">"RETURNFLAG":"$RETURNFLAG",</p>
					<p class="h5_p">"LINESTATUS":"$LINESTATUS"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"sum_qty":{</p>  
					<p class="h5_p">"$sum":"$QUANTITY"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"sum_base_price":{</p>  
					<p class="h5_p">"$sum":"$EXTENDEDPRICE"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"sum_disc_price":{</p>  
					<p class="h5_p">"$sum":{</p>  
					   <p class="h6_p">"$multiply":[ </p> 
							<p class="h7_p">"$EXTENDEDPRICE",</p>
							<p class="h7_p">"$l_dis_min_1"</p>
					   <p class="h6_p">]</p>
					<p class="h5_p">}</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"sum_charge":{</p>  
					<p class="h5_p">"$sum":{ </p> 
						<p class="h6_p">"$multiply":[ </p> 
							<p class="h7_p">"$EXTENDEDPRICE",</p>
							<p class="h7_p">{ </p> 
								<p class="h8_p">"$multiply":[</p>  
									<p class="h9_p">"$l_tax_plus_1",</p>
									<p class="h9_p">"$l_dis_min_1"</p>
								<p class="h8_p">]</p>
							<p class="h7_p">}</p>
						<p class="h6_p">]</p>
					<p class="h5_p">}</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"avg_price":{ </p> 
					<p class="h5_p">"$avg":"$EXTENDEDPRICE"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"avg_qty": {</p>
					<p class="h5_p">"$avg": "$QUANTITY"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"avg_disc":{</p>  
					<p class="h5_p">"$avg":"$DISCOUNT"</p>
				<p class="h4_p">},</p>
				<p class="h4_p">"count_order":{ </p> 
					<p class="h5_p">"$sum":1</p>
				<p class="h4_p">}</p>
			<p class="h3_p">}</p>
		<p class="h2_p">},</p>
		<p class="h2_p">{ </p> 
			<p class="h3_p">"$sort":{ </p> 
				<p class="h4_p">"RETURNFLAG":1,</p>
				<p class="h4_p">"LINESTATUS":1</p>
			<p class="h3_p">}</p>
		<p class="h2_p">}</p>
	<p class="h1_p">);</p>
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