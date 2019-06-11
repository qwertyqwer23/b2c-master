<?php

namespace App\Http\Controllers;
use GraphAware\Neo4j\Client\ClientBuilder;

use Illuminate\Http\Request;

use App\Models\Neo4j\Part;
use App\Models\Neo4j\Supplier;
use App\Models\Neo4j\Partsupp;
use App\Models\Neo4j\Customer;
use App\Models\Neo4j\Nation;
use App\Models\Neo4j\Region;
use App\Models\Neo4j\Lineitem;
use App\Models\Neo4j\Orders;

class MasterNeo4jController extends Controller
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

		return date('Y-m-d H:i:s', $val);
	}
	
	private function do_joins($count = 5){
		$client = ClientBuilder::create()
		->addConnection('default', 'http://neo4j:123@localhost:7474') // Example for HTTP connection configuration (port is optional)
		->build();
		
		for ($i = 1; $i <= $count; $i++) {
			$query = 'MATCH (o:Order {id:'.$i.'}), (l:Lineitem {ORDERKEY:'.$i.'}) CREATE (o)-[:CONTAINS]->(l)';
			$result = $client->run($query);
		}
		
		for ($i = 1; $i <= $count; $i++) {
			$query = 'MATCH (o:Order {CUSTKEY:'.$i.'}), (c:Customer {id:'.$i.'}) CREATE (o)-[:CREATED_BY]->(c)';
			$result = $client->run($query);
		}
		
	}
  
	public function generate_tables()
	{
		
		$supplier = new Supplier();
		$data_arr = $supplier->return_data();
		foreach($data_arr as $data){
			
			$supplier->id = $data['id'];
			$supplier->NAME = $data['NAME'];
			$supplier->ADDRESS = $data['ADDRESS'];
			$supplier->NATIONKEY = $data['NATIONKEY'];
			$supplier->PHONE = $data['PHONE'];
			$supplier->ACCTBAL = $data['ACCTBAL'];
			$supplier->COMMENT = $data['COMMENT'];
			$supplier->save();
			
			$supplier = new Supplier();
		}

		$part = new Part();
		$data_arr = $part->return_data();
		foreach($data_arr as $data){
			$part->id = $data['id'];
			$part->NAME = $data['NAME'];
			$part->MFGR = $data['MFGR'];
			$part->BRAND = $data['BRAND'];
			$part->TYPE = $data['TYPE'];
			$part->SIZE = $data['SIZE'];
			$part->CONTAINER = $data['CONTAINER'];
			$part->RETAILPRICE = $data['RETAILPRICE'];
			$part->COMMENT = $data['COMMENT'];
			$part->save();
			
			$part = new Part();
		}
		
		$partsupp = new Partsupp();
		$data_arr = $partsupp->return_data();
		foreach($data_arr as $data){

			$partsupp->PART_KEY = $data['PART_KEY'];
			$partsupp->SUPPKEY = $data['SUPPKEY'];
			$partsupp->AVAILQTY = $data['AVAILQTY'];
			$partsupp->SUPPLYCOST = $data['SUPPLYCOST'];
			$partsupp->COMMENT = $data['COMMENT'];
			$partsupp->save();
			
			$partsupp = new Partsupp();
		}
		
		$customer = new Customer();
		$data_arr = $customer->return_data();
		foreach($data_arr as $data){

			$customer->id = $data['id'];
			$customer->NAME = $data['NAME'];
			$customer->ADDRESS = $data['ADDRESS'];
			$customer->NATIONKEY = $data['NATIONKEY'];
			$customer->PHONE = $data['PHONE'];
			$customer->ACCTBAL = $data['ACCTBAL'];
			$customer->MKTSEGMENT = $data['MKTSEGMENT'];
			$customer->COMMENT = $data['COMMENT'];
			$customer->save();
			
			$customer = new Customer();
		}

		$nation = new Nation();
		$data_arr = $nation->return_data();
		foreach($data_arr as $data){

			$nation->id = $data['id'];
			$nation->NAME = $data['NAME'];
			$nation->REGIONKEY = $data['REGIONKEY'];
			$nation->COMMENT = $data['COMMENT'];
			$nation->save();
			
			$nation = new Nation();
		}
		
		$region = new Region();
		$data_arr = $region->return_data();
		foreach($data_arr as $data){

			$region->id = $data['id'];
			$region->NAME = $data['NAME'];
			$region->COMMENT = $data['COMMENT'];
			$region->save();
			
			$region = new Region();
		}

		$lineitem = new Lineitem();
		$data_arr = $lineitem->return_data();
		foreach($data_arr as $data){

			$lineitem->ORDERKEY = $data['ORDERKEY'];
			$lineitem->PARTKEY = $data['PARTKEY'];
			$lineitem->LINENUMBER = $data['LINENUMBER'];
			$lineitem->QUANTITY = $data['QUANTITY'];
			$lineitem->EXTENDEDPRICE = $data['EXTENDEDPRICE'];
			$lineitem->DISCOUNT = $data['DISCOUNT'];
			$lineitem->TAX = $data['TAX'];
			$lineitem->RETURNFLAG = $data['RETURNFLAG'];
			$lineitem->LINESTATUS = $data['LINESTATUS'];
			$lineitem->SHIPDATE = strtotime($data['SHIPDATE']);
			$lineitem->COMMITDATE = strtotime($data['COMMITDATE']);
			$lineitem->RECEIPTDATE = strtotime($data['RECEIPTDATE']);
			$lineitem->SHIPINSTRUCT = $data['SHIPINSTRUCT'];
			$lineitem->SHIPMODE = $data['SHIPMODE'];
			$lineitem->COMMENT = $data['COMMENT'];
			$lineitem->save();
			
			$lineitem = new Lineitem();
		}
		
		$orders = new Orders();
		$data_arr = $orders->return_data();
		foreach($data_arr as $data){

			$orders->id = $data['id'];
			$orders->CUSTKEY = $data['CUSTKEY'];
			$orders->ORDERSTATUS = $data['ORDERSTATUS'];
			$orders->TOTALPRICE = $data['TOTALPRICE'];
			$orders->ORDERDATE = strtotime($data['ORDERDATE']);
			$orders->ORDERPRIORITY = $data['ORDERPRIORITY'];
			$orders->CLERK = $data['CLERK'];
			$orders->SHIPPRIORITY = $data['SHIPPRIORITY'];
			$orders->COMMENT = $data['COMMENT'];
			$orders->save();
			
			$orders = new Orders();
		}
		
		$this->do_joins();
	}
	
	private function create_connection()
	{
		$client = ClientBuilder::create()
		->addConnection('b2c_small', 'http://neo4j:123@localhost:7474') // Example for HTTP connection configuration (port is optional)
		->build();
		return $client;
	}
	
	public function return_query_statistic($count = 15){
		$client = ClientBuilder::create()
		->addConnection('b2c_small', 'http://neo4j:123@localhost:7474') // Example for HTTP connection configuration (port is optional)
		->build();
		
		$q1 = 'MATCH (item:Lineitem)
			WHERE item.SHIPDATE <= 912524220
			RETURN item.RETURNFLAG,
			item.LINESTATUS,
			sum(item.QUANTITY) AS sum_qty,
			sum(item.EXTENDEDPRICE) AS sum_base_price,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)) AS sum_disc_price,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)*(1+item.TAX)) AS sum_charge,
			avg(item.QUANTITY) AS avg_qty,
			avg(item.EXTENDEDPRICE) AS avg_price,
			avg(item.DISCOUNT) AS avg_disc
			ORDER BY item.RETURNFLAG, item.LINESTATUS';
			
		$q3 = "MATCH
			(item:Lineitem) <-[:CONTAINS]- (order:Order ) -[:CREATED_BY]-> (customer:Customer)
			WHERE order.ORDERDATE < 912524220
			AND item.SHIPDATE > 631205820
			AND customer.MKTSEGMENT = 'AUTOMOBILE'
			RETURN order.id,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)) AS REVENUE,
			order.ORDERDATE,
			order.SHIPPRIORITY
			ORDER BY REVENUE DESC, order.ORDERDATE";
			
		$q4 = 'MATCH
			(order:Order) -[:CONTAINS]-> (item:Lineitem)
			WHERE item.COMMITDATE < item.RECEIPTDATE 
			AND order.ORDERDATE >= 631205820
			AND order.ORDERDATE < 9125242200
			RETURN order.ORDERPRIORITY, count(*) AS ORDER_COUNT
			ORDER BY order.ORDERPRIORITY';
			
		$sum_q1 = 0;
		$sum_q3 = 0;
		$sum_q4 = 0;
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q1);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
		
			$sum_q1 += $timediff;
			$result_arr['query_exec_time_q1'][] = $timediff;
		}
		foreach ($result->getRecords() as $record) {
			$result_arr['result']['q1'] = [
				"item.RETURNFLAG" =>$record->value("item.RETURNFLAG"),
				"item.LINESTATUS" => $record->value("item.LINESTATUS"),
				"sum_qty" => $record->value('sum_qty'),
				"sum_base_price" => $record->value('sum_base_price'),
				"sum_disc_price" => $record->value('sum_disc_price'),
				"sum_charge" => $record->value('sum_charge'),
				"avg_qty" => $record->value('avg_qty'),
				"avg_price" => $record->value('avg_price'),
				"avg_disc" => $record->value('avg_disc')
			];	
		}
	
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q3);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q3 += $timediff;
			$result_arr['query_exec_time_q3'][] = $timediff;
		}
		
		foreach ($result->getRecords() as $record) {
			$result_arr['result']['q3'] = [
				"order.id" => $record->value('order.id'),
				"REVENUE" => $record->value('REVENUE'),
				"order.ORDERDATE" => $record->value('order.ORDERDATE'),
				"order.SHIPPRIORITY" => $record->value('order.SHIPPRIORITY')
		
			];	
		}
	
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q4);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q4 += $timediff;
			$result_arr['query_exec_time_q4'][] = $timediff;
		}
		foreach ($result->getRecords() as $record) {
			$result_arr['result']['q4'] = [
				'order.ORDERPRIORITY' =>$record->value('ORDER_COUNT'),
				'ORDER_COUNT' => $record->value('order.ORDERPRIORITY')
			];	
		}
		
		$result_arr['avg']['q1'] = $sum_q1 / $count;
		$result_arr['avg']['q3'] = $sum_q3 / $count;
		$result_arr['avg']['q4'] = $sum_q4 / $count;

		echo '<pre>';
		print_r($result_arr);
		
		return $result_arr;
	}
	
	function q1_statistic($count=15)
	{
		$client = $this->create_connection();
		
		$q1 = 'MATCH (item:Lineitem)
			WHERE item.SHIPDATE <= 912524220
			RETURN item.RETURNFLAG,
			item.LINESTATUS,
			sum(item.QUANTITY) AS sum_qty,
			sum(item.EXTENDEDPRICE) AS sum_base_price,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)) AS sum_disc_price,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)*(1+item.TAX)) AS sum_charge,
			avg(item.QUANTITY) AS avg_qty,
			avg(item.EXTENDEDPRICE) AS avg_price,
			avg(item.DISCOUNT) AS avg_disc,
			COUNT(*) as count_sum
			ORDER BY item.RETURNFLAG, item.LINESTATUS';
			
		$sum_q1 = 0;
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q1);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
		
			$sum_q1 += $timediff;
			$result_arr['query_exec_time'][] = $timediff;
		}
		
		foreach ($result->getRecords() as $record) {
			$result_arr['result'][] = [
				"sum_qty" => $record->value('sum_qty'),
				"sum_base_price" => $record->value('sum_base_price'),
				"sum_disc_price" => $record->value('sum_disc_price'),
				"sum_charge" => $record->value('sum_charge'),
				"avg_price" => $record->value('avg_price'),
				"avg_qty" => $record->value('avg_qty'),
				"avg_disc" => $record->value('avg_disc'),
				"count_sum" => $record->value('count_sum'),
				"item.RETURNFLAG" =>$record->value("item.RETURNFLAG"),
				"item.LINESTATUS" => $record->value("item.LINESTATUS"),
			];	
		}
		
		$result_arr['avg'] = $sum_q1 / $count;
		
		return $result_arr;
	}
	
	function q3_statistic($count=15)
	{
		$client = $this->create_connection();
		
		$q3 = "MATCH
			(item:Lineitem) <-[:CONTAINS]- (order:Order ) -[:CREATED_BY]-> (customer:Customer)
			WHERE order.ORDERDATE < 912524220
			AND item.SHIPDATE > 631205820
			AND customer.MKTSEGMENT = 'AUTOMOBILE'
			RETURN order.id,
			sum(item.EXTENDEDPRICE*(1-item.DISCOUNT)) AS REVENUE,
			order.ORDERDATE,
			order.SHIPPRIORITY
			ORDER BY REVENUE DESC, order.ORDERDATE";
			
		$sum_q3 = 0;
		
			for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q3);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q3 += $timediff;
			$result_arr['query_exec_time'][] = $timediff;
		}
		
		foreach ($result->getRecords() as $record) {
			$result_arr['result'][] = [
				"order.id" => $record->value('order.id'),
				"REVENUE" => $record->value('REVENUE'),
				"order.ORDERDATE" => $record->value('order.ORDERDATE'),
				"order.SHIPPRIORITY" => $record->value('order.SHIPPRIORITY')
		
			];	
		}
		
		$result_arr['avg'] = $sum_q3 / $count;
		
		return $result_arr;
	}
	
	function q4_statistic($count=15)
	{
		$client = $this->create_connection();
		
		$q4 = 'MATCH
			(order:Order) -[:CONTAINS]-> (item:Lineitem)
			WHERE item.COMMITDATE < item.RECEIPTDATE 
			AND order.ORDERDATE >= 631205820
			AND order.ORDERDATE < 9125242200
			RETURN order.ORDERPRIORITY, count(*) AS ORDER_COUNT
			ORDER BY order.ORDERPRIORITY';
		
		$sum_q4 = 0;
		
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $client->run($q4);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q4 += $timediff;
			$result_arr['query_exec_time'][] = $timediff;
		}
		foreach ($result->getRecords() as $record) {
			$result_arr['result'][] = [
				'order.ORDERPRIORITY' =>$record->value('ORDER_COUNT'),
				'ORDER_COUNT' => $record->value('order.ORDERPRIORITY')
			];	
		}
		
		$result_arr['avg'] = $sum_q4 / $count;
		
		return $result_arr;	
	}
	
	function generate_big_data($counter='10000'){
		set_time_limit(200000);
	
		//$counter = 50000;
		$counter = 500000;
		
		/*for ($i = 1; $i <= $counter; $i++) {
			$this->insert_part();
		*/
		
		for ($i = 1; $i <= 250000; $i++) {
			$this->insert_supplier();
		}
		
		for ($i = 1; $i <= $counter; $i++) {
			$this->insert_part_supplier();
		}
		
		
		for ($i = 1; $i <= $counter; $i++) {
			$this->insert_customer();
		}
		
		for ($i = 1; $i <= $counter; $i++) {
			$this->insert_lineitem();
		}
		
		for ($i = 1; $i <= $counter; $i++) {
			$this->insert_orders();
		}
	}	

	public function insert_part()
	{
		$part = new Part([
			'id' => rand(1, 200000),
			'NAME' => $this->generate_string(55),									
			'MFGR' => $this->generate_string(25),									
			'BRAND' => $this->generate_string(10),									
			'TYPE' => $this->generate_string(25),				
			'SIZE' => $this->generate_numbers(2),						
			'CONTAINER' => $this->generate_string(10),								
			'RETAILPRICE' => $this->generate_string(rand(1, 9)).'.'.rand(10, 99),
			'COMMENT' => $this->generate_string(23),
		]);
		
		$part->save();
		
		/*$part = "
		CREATE (n:Part {
			id: '". rand(1, 200000) ."',
			NAME: '".$this->generate_string(55) ."',
			MFGR: '".$this->generate_string(25)."',
			BRAND: '".$this->generate_string(10)."' ,
			TYPE: '".$this->generate_string(25)."',
			SIZE: '".$this->generate_numbers(2)."',
			CONTAINER: '".$this->generate_string(10)."' ,
			RETAILPRICE: '".$this->generate_string(rand(1, 9)).'.'.rand(10, 99)."',
			COMMENT: '".$this->generate_string(23)."'
			})
		";
		$client->run($part);*/
	}
	
	public function insert_supplier()
	{
		$supplier = new Supplier();
		$supplier->id = rand(1, 10000);
		$supplier->NAME = $this->generate_string(25);
		$supplier->ADDRESS = $this->generate_string(40);
		$supplier->NATIONKEY = rand(1, 25);
		$supplier->PHONE = rand(1,99).'-'.rand(1,199).'-'.rand(1,6000);
		$supplier->ACCTBAL = rand(1,99). '.' . rand(10, 99);
		$supplier->COMMENT = $this->generate_string(100);
		$supplier->save();
	}
	
	public function insert_part_supplier()
	{
		//Primary Key: PS_PARTKEY, PS_SUPPKEY
		
		$data = [
			'PART_KEY' => rand(1, 200000),								//Identifier Foreign Key to P_PARTKEY
			'SUPPKEY' => rand(1, 10000),								//Identifier Foreign Key to S_SUPPKEY
			'AVAILQTY' => $this->generate_numbers(12),					//integer
			'SUPPLYCOST' => rand(1,99). '.' . rand(10, 99),		//Decimal
			'COMMENT' => $this->generate_string(150)					//variable text, size 199
		];
		
		$part_supplier = new Partsupp($data);
		$part_supplier->save();
	}
	
	public function insert_customer()
	{
		//Primary Key: C_CUSTKEY
		
		$data = [
			//C_CUSTKEY 													Identifier SF*150,000 are populated
			'id' => rand(1, 150000),
			'NAME' => $this->generate_string(25),							//variable text, size 25
			'ADDRESS' => $this->generate_string(40),						//variable text, size 40
			'NATIONKEY' => rand(1, 25),										//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),			//fixed text, size 15
			'ACCTBAL' => rand(1,99). '.' . rand(10, 99),				//Decimal
			'MKTSEGMENT' => $this->generate_string(10),						//fixed text, size 10
			'COMMENT' => $this->generate_string(117)						//variable text, size 117
		];
		
		$part_supplier = new Customer($data);
		$part_supplier->save();
	}
	
	public function insert_nation()
	{
		//Primary Key: N_NATIONKEY
		
		$data = [
		//	 N_NATIONKEY 								identifier 25 nations are populated
			'id' => rand(1, 20),
			'NAME' => $this->generate_string(25),		//fixed text, size 25
			'REGIONKEY' => rand(1, 5),					//identifier Foreign Key to R_REGIONKEY
			'COMMENT' => $this->generate_string(152)	//variable text, size 152
		];
		
		$nation = new Nation($data);
		$nation->save();
	}
	
	/*public function insert_region()
	{
		//Primary Key: R_REGIONKEY

		$data = [
		//	 R_REGIONKEY 								identifier 5 regions are populated
			'NAME' => $this->generate_string(25), 		//fixed text, size 25
			'COMMENT' => $this->generate_string(152)	//variable text, size 152
		];
		
		$nation = new Nation($data);
		$nation->save();
	}*/
	
	public function insert_lineitem()
	{
		//Primary Key: L_ORDERKEY, L_LINENUMBER
		$data = [
			'ORDERKEY' => rand(1, 1500000), 							//identifier Foreign Key to O_ORDERKEY
			'PARTKEY' => rand(1, 200000), 								//identifier Foreign key to P_PARTKEY, first part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_SUPPKEY
			'SUPPKEY' => rand(1, 10000),								//Identifier Foreign key to S_SUPPKEY, second part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_PARTKEY
			'LINENUMBER' => rand(1,6000000),							//integer
			'QUANTITY' => rand(1, 1500000),								//decimal
			'EXTENDEDPRICE' => rand(1, 100000). '.' . rand(1, 9) / 10,	//decimal
			'DISCOUNT' => rand(1, 9) / 100,								//decimal
			'TAX' => rand(1, 9) / 100,									//decimal
			'RETURNFLAG' => $this->generate_just_string(1),				//fixed text, size 1
			'LINESTATUS' => $this->generate_just_string(1),				//fixed text, size 1
			'SHIPDATE' => $this->rand_date(),							//date
			'COMMITDATE' => $this->rand_date(),							//date
			'RECEIPDATE' => $this->rand_date(),							//date
			'SHIPINSTRUCT' => $this->generate_string(25),				//fixed text, size 25
			'SHIPMODE' => $this->generate_string(10),					//fixed text, size 10
			'COMMENT' => $this->generate_string(44)						//variable text size 44
		];
		
		$nation = new Lineitem($data);
		$nation->save();

	}
	
	public function insert_orders()
	{
		//Primary Key: O_ORDERKEY

		$data = [
			//O_ORDERKEY 															Identifier SF*1,500,000 are sparsely populated 
			'id' => rand(1,1500000),
			'CUSTKEY' => rand(1, 150000), 											//Identifier Foreign Key to C_CUSTKEY
			'ORDERSTATUS' => rand(0, 5), 											//fixed text, size 1
			'TOTALPRICE' => $this->generate_numbers(10). '.' . rand(1, 9) / 10, 	//Decimal
			'ORDERDATE' => $this->rand_date(),						 				//date
			'ORDER-PRIORITY' => rand(0, 3),											//fixed text, size 15
			'CLERK' => $this->generate_numbers(15),									//fixed text, size 15
			'SHIP-PRIORITY' => rand(0, 4), 											//integer
			'COMMENT' => $this->generate_string(79)									//variable text, size 79
		];
		
		$nation = new Orders($data);
		$nation->save();
	}
}
