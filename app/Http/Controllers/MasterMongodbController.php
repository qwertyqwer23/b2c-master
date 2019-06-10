<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterMongodb;
use DB;

use App\Models\Mongodb\Part;
use App\Models\Mongodb\Supplier;
use App\Models\Mongodb\Partsupp;
use App\Models\Mongodb\Customer;
use App\Models\Mongodb\Nation;
use App\Models\Mongodb\Region;
use App\Models\Mongodb\Lineitem;
use App\Models\Mongodb\Orders;

class MasterMongodbController extends Controller
{
	private function generate_string($length = 10)
	{  
		return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
	}
	
	private function generate_just_string($length = 10)
	{  
		return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
	}
	
	private function generate_numbers($length = 9)
	{   
		return substr(str_shuffle('123456789'),1,$length);
	}
	
	private function rand_date()
	{
		$start = strtotime('2002-01-01');
		$end = strtotime('2003-12-30');

		$val = rand($start, $end);

		return date('Y-m-d', $val);
	}
	
	private function get_q1(){
		return Lineitem::raw(function($collection)
		{
			return $collection->aggregate([  
			    [  
				  '$match'=>[  
					 'SHIPDATE'=>[ 
						'$lte'=> '1998-12-01'
					 ]
				  ]
			   ],
			   [  
				  '$project'=>[  
					 'RETURNFLAG'=>1,
					 'LINESTATUS'=>1,
					 'QUANTITY'=>1,
					 'EXTENDEDPRICE'=>1,
					 'DISCOUNT'=>1,
					 'l_dis_min_1'=>[  
						'$subtract'=>[  
						   1,
						   '$DISCOUNT'
						]
					 ],
					 'l_tax_plus_1'=>[  
						'$add'=>[  
						   '$TAX',
						   1
						]
					 ]
				  ]
			   ],
			   [  
				  '$group'=>[  
					 '_id'=>[  
						'RETURNFLAG'=>'$RETURNFLAG',
						'LINESTATUS'=>'$LINESTATUS'
					 ],
					 'sum_qty'=>[  
						'$sum'=>'$QUANTITY'
					 ],
					 'sum_base_price'=>[  
						'$sum'=>'$EXTENDEDPRICE'
					 ],
					 'sum_disc_price'=>[  
						'$sum'=>[  
						   '$multiply'=>[  
							  '$EXTENDEDPRICE',
							  '$l_dis_min_1'
						   ]
						]
					 ],
					 'sum_charge'=>[  
						'$sum'=>[  
						   '$multiply'=>[  
							  '$EXTENDEDPRICE',
							  [  
								 '$multiply'=>[  
									'$l_tax_plus_1',
									'$l_dis_min_1'
								 ]
							  ]
						   ]
						]
					 ],
					 'avg_price'=>[  
						'$avg'=>'$EXTENDEDPRICE'
					 ],
					 'avg_disc'=>[  
						'$avg'=>'$DISCOUNT'
					 ],
					 'count_order'=>[  
						'$sum'=>1
					 ]
				  ]
			   ],
			   [  
				  '$sort'=>[  
					 'RETURNFLAG'=>1,
					 'LINESTATUS'=>1
				  ]
			   ]
			]);
		})->toArray();
	}
	
	private function get_q3(){
		return Orders::raw(function($collection)
		{
			return $collection->aggregate([
				[  
					'$match' => [  
						'ORDERDATE' => [ 
							'$lte' => "1998-12-01"
						]
						  
					]
				  
			   ],			
			    [
					'$lookup'=>[
						'from'=> 'lineitems',       // other table name
						'localField'=> 'ORDERKEY',   // name of users table field
						'foreignField'=> 'ORDERKEY', // name of userinfo table field
						'as'=> 'lineitems'         // alias for userinfo table
					]
				],
				[
					'$lookup'=>[
						'from'=> 'customers',       
						'localField'=> 'CUSTKEY',   
						'foreignField'=> 'CUSTKEY', 
						'as'=> 'customer'  
					]
				],
			   [  
				  '$match'=>[  
					 'customer.MKTSEGMENT'=>'AUTOMOBILE',
					 'lineitems.SHIPDATE'=>[  
						'$gte'=> '1990-01-01'
					 ]
				  ]
			   ],
			   [  
				  '$unwind'=>'$lineitems'
			   ],
			   [  
				  '$project'=>[  
					 'ORDERDATE'=>1,
					 'SHIPPRIORITY'=>1,
					 'lineitems.EXTENDEDPRICE'=>1,
					 'l_dis_min_1'=>[  
						'$subtract'=>[  
						   1,
						   '$lineitems.DISCOUNT'
						]
					 ]
				  ]
			   ],
			   [  
				  '$group'=>[  
					 '_id'=>[  
						'ORDERKEY'=>'$ORDERKEY',
						'ORDERDATE'=>'$ORDERDATE',
						'SHIPPRIORITY'=>'$SHIPPRIORITY'
					 ],
					 'revenue'=>[  
						'$sum'=>[  
						   '$multiply'=>[  
							  '$lineitems.EXTENDEDPRICE',
							  '$l_dis_min_1'
						   ]
						]
					 ]
				  ]
			   ],
			   [  
				  '$sort'=>[  
					 'revenue'=>1,
					 'ORDERDATE'=>1
				  ]
			   ]
			]);
		})->toArray();
	}
	
	private function get_q4(){
		return Orders::raw(function($collection)
		{
			return $collection->aggregate([  
				[  
				  '$match'=>[  
					 'ORDERDATE'=>[  
						'$gte'=> '1990-01-01'
					 ]
				  ]
			   ],
				[  
				  '$match'=>[  
					 'ORDERDATE'=>[  
						'$lt'=> '2000-01-01'
					 ]
				  ]
			   ],
			    [
					'$lookup'=>[
						'from'=> 'lineitems',       // other table name
						'localField'=> 'ORDERKEY',   // name of users table field
						'foreignField'=> 'ORDERKEY', // name of userinfo table field
						'as'=> 'lineitems'         // alias for userinfo table
					]
				],
				[  
				  '$project'=>[  
					 'ORDERDATE'=>1,
					 'ORDERPRIORITY'=>1,
					 'eq'=>[  
						'$cond'=>[  
						   [  
							  '$lt'=>[  
								  '$lineitems.RECEIPTDATE',
								 '$lineitems.COMMITDATE'
							  ]
						   ],
						   0,
						   1
						]
					 ]
				  ]
			   ],
			   [  
				  '$match'=>[  
					 'eq'=>[  
						'$eq'=>1
					 ]
				  ]
			   ],
			   [  
				  '$group'=>[  
					 '_id'=>[  
						'ORDERPRIORITY'=>'$ORDERPRIORITY'
					 ],
					 'order_count'=>[  
						'$sum'=>1
					 ]
				  ]
			   ],
			   [  
				  '$sort'=>[  
					 'ORDERPRIORITY'=>1
				  ]
			   ]
			]);
		})->toArray();
	}
  
    public function select()
    {
		$q1_result = json_decode(json_encode($this->get_q1()),true);
		$q3_result = json_decode(json_encode($this->get_q3()),true);
		$q4_result = json_decode(json_encode($this->get_q4()),true);
		
		//DB::connection( 'mongodb' )->enableQueryLog();
		//dd(DB::connection('mongodb')->getQueryLog());
		//dd(json_decode(json_encode($q4_result)),true);
		echo '<pre>';
		print_r($q4_result);
		die;
		dd($q4_result);
    }
	
	public function return_query_statistic($count = 15){
		set_time_limit(200000);	
		
		$sum_q1 = 0;
		$sum_q3 = 0;
		$sum_q4 = 0;

		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->get_q1();
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q1 += $timediff;
			$result_arr['query_exec_time_q1'][] = $timediff;
		}
		$result_arr['result']['q1'] = json_decode(json_encode($result),true);
	
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->get_q3();

			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q3 += $timediff;
			$result_arr['query_exec_time_q3'][] = $timediff;
		}
		$result_arr['result']['q3'] = json_decode(json_encode($result),true);
		
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->get_q4();
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q4 += $timediff;
			$result_arr['query_exec_time_q4'][] = $timediff;
		}
		$result_arr['result']['q4'] = json_decode(json_encode($result),true);
		
		$result_arr['avg']['q1'] = $sum_q1 / $count;
		$result_arr['avg']['q3'] = $sum_q3 / $count;
		$result_arr['avg']['q4'] = $sum_q4 / $count;

		echo '<pre>';
		print_r($result_arr);
		
		return $result_arr;
	}
	
	public function generate_tables($database='mongodb_small')
	{
		//$database = 'mongodb_small';
		//$database = 'mongodb_middle';
		//$database = 'mongodb_big';
		
		$supplier = new Supplier();
		$data_arr = $supplier->return_data();	
		foreach($data_arr as $data){
			DB::connection($database)->collection('suppliers')->insert($data);
		}
		
		$part = new Part();
		$data_arr = $part->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('parts')->insert($data);
		}
		
		$partsupp = new Partsupp();
		$data_arr = $partsupp->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('partsupps')->insert($data);
		}
		
		$customer = new Customer();
		$data_arr = $customer->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('customers')->insert($data);
		}

		$nation = new Nation();
		$data_arr = $nation->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('nations')->insert($data);
		}
		
		$region = new Region();
		$data_arr = $region->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('regions')->insert($data);
		}

		$lineitem = new Lineitem();
		$data_arr = $lineitem->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('lineitems')->insert($data);
		}
		
		$orders = new Orders();
		$data_arr = $orders->return_data();
		foreach($data_arr as $data){
			DB::connection($database)->collection('orders')->insert($data);
		}
		
	}
	
	function generate_big_data(){
		
		set_time_limit(200000);
		
		//$database = 'mongodb_small';
		//$database = 'mongodb_middle';
		$database = 'mongodb_big';
		
		$size_arr = [
			'mongodb_small' => '10000',
			'mongodb_middle' => '50000',
			'mongodb_big' => '500000'
		];
		
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_part($database);
		}
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_supplier($database);
		}
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_part_supplier($database);
		}
		
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_customer($database);
		}
		
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_lineitem($database);
		}
		
		for ($i = 1; $i <= $size_arr[$database]; $i++) {
			$this->insert_orders($database);
		}
	}
	
	
	public function insert_part($database = 'mongodb_small')
	{
		//Primary Key: P_PARTKEY
		
		$data = [
			//P_PARTKEY 															identifier SF*200,000 are populated
			'PARTKEY' => rand(1, 200000),
			'NAME' => $this->generate_string(55),									//variable text, size 55
			'MFGR' => $this->generate_string(25),									//fixed text, size 25
			'BRAND' => $this->generate_string(10),									//fixed text, size 10
			'TYPE' => $this->generate_string(25),									//variable text, size 25
			'SIZE' => $this->generate_numbers(2),									//integer
			'CONTAINER' => $this->generate_string(10),								//fixed text, size 10
			'RETAILPRICE' => $this->generate_string(rand(1, 9)).'.'.rand(10, 99),	//decimal
			'COMMENT' => $this->generate_string(23)									//variable text, size 23
		];
		
		$insertData = DB::connection($database)->collection('parts')->insert($data);
	
	}
	
	public function insert_supplier($database = 'mongodb_small')
	{
		//Primary Key: S_SUPPKEY
		$data = [
			//S_SUPPKEY 												identifier SF*10,000 are populated
			'SUPPKEY' => rand(1, 10000),		
			'NAME' => $this->generate_string(25),						//fixed text, size 25
			'ADDRESS' => $this->generate_string(40),					//variable text, size 40
			'NATIONKEY' => rand(1, 25),									//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),		//fixed text, size 15
			'ACCTBAL' => rand(1,99). '.' . rand(10, 99),			//decimal
			'COMMENT' => $this->generate_string(100)					//variable text, size 101
		];
		
		$insertData = DB::connection($database)->collection('suppliers')->insert($data);
	}
	
	public function insert_part_supplier($database = 'mongodb_small')
	{
		//Primary Key: PS_PARTKEY, PS_SUPPKEY
		
		$data = [
			'PART_KEY' => rand(1, 200000),								//Identifier Foreign Key to P_PARTKEY
			'SUPPKEY' => rand(1, 10000),								//Identifier Foreign Key to S_SUPPKEY
			'AVAILQTY' => $this->generate_numbers(12),					//integer
			'SUPPLYCOST' => rand(1,99). '.' . rand(10, 99),		//Decimal
			'COMMENT' => $this->generate_string(150)					//variable text, size 199
		];
		
		$insertData = DB::connection($database)->collection('partsupps')->insert($data);
	}
	
	public function insert_customer($database = 'mongodb_small')
	{
		//Primary Key: C_CUSTKEY
		
		$data = [
			//C_CUSTKEY 													Identifier SF*150,000 are populated
			'CUSTKEY' => rand(1, 150000),
			'NAME' => $this->generate_string(25),							//variable text, size 25
			'ADDRESS' => $this->generate_string(40),						//variable text, size 40
			'NATIONKEY' => rand(1, 25),										//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),			//fixed text, size 15
			'ACCTBAL' => rand(1,99),										//Decimal
			'MKTSEGMENT' => $this->generate_string(10),						//fixed text, size 10
			'COMMENT' => $this->generate_string(117)						//variable text, size 117
		];
		
		$insertData = DB::connection($database)->collection('customers')->insert($data);
	}
	
	public function insert_lineitem($database = 'mongodb_small')
	{
		//Primary Key: L_ORDERKEY, L_LINENUMBER
		$data = [
			'ORDERKEY' => rand(1, 1500000), 							//identifier Foreign Key to O_ORDERKEY
			'PARTKEY' => rand(1, 200000), 								//identifier Foreign key to P_PARTKEY, first part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_SUPPKEY
			'SUPPKEY' => rand(1, 10000),								//Identifier Foreign key to S_SUPPKEY, second part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_PARTKEY
			'LINENUMBER' => rand(1, 200000),							//integer
			'QUANTITY' => rand(1, 1500000),								//decimal
			'EXTENDEDPRICE' => 22824.48,								//decimal
			'DISCOUNT' => rand(1, 9) / 100,								//decimal
			'TAX' => rand(1, 9) / 100,									//decimal
			'RETURNFLAG' => $this->generate_just_string(1),				//fixed text, size 1
			'LINESTATUS' => $this->generate_just_string(1),				//fixed text, size 1
			'SHIPDATE' => $this->rand_date(),							//date
			'COMMITDATE' => $this->rand_date(),							//date
			'RECEIPTDATE' => $this->rand_date(),						//date
			'SHIPINSTRUCT' => $this->generate_string(25),				//fixed text, size 25
			'SHIPMODE' => $this->generate_string(10),					//fixed text, size 10
			'COMMENT' => $this->generate_string(44)						//variable text size 44
		];
		
		
		$insertid = DB::connection($database)->collection('lineitems')->insertGetId($data);
		//DB::connection($database)->collection('lineitems')->where('_id', $insertid)->update(['LINENUMBER' => $insertid, ['upsert' => true]]);
		
		//$user = DB::collection('users')->where('name', 'John')->first();
		//die('here');
	}
	
	public function insert_orders($database = 'mongodb_small')
	{
		//Primary Key: O_ORDERKEY

		$data = [
			//O_ORDERKEY 															Identifier SF*1,500,000 are sparsely populated 
			'ORDERKEY' => rand(1,1500000),
			'CUSTKEY' => rand(1, 150000), 											//Identifier Foreign Key to C_CUSTKEY
			'ORDERSTATUS' => $this->generate_string(1), 											//fixed text, size 1
			'TOTALPRICE' => 144659.2, 													//Decimal
			'ORDERDATE' => $this->rand_date(),						 				//date
			'ORDERPRIORITY' => $this->generate_string(5),							//fixed text, size 15
			'CLERK' => $this->generate_numbers(15),									//fixed text, size 15
			'SHIPPRIORITY' => rand(0, 4), 											//integer
			'COMMENT' => $this->generate_string(79)									//variable text, size 79
		];
		
		$insertData = DB::connection($database)->collection('orders')->insert($data);
	}
}
