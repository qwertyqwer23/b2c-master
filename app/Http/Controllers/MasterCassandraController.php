<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cassandra;
use DB;

use App\Models\Cassandra\Part;
use App\Models\Cassandra\Supplier;
use App\Models\Cassandra\Partsupp;
use App\Models\Cassandra\Customer;
use App\Models\Cassandra\Nation;
use App\Models\Cassandra\Region;
use App\Models\Cassandra\Lineitem;
use App\Models\Cassandra\Orders;
use App\Models\Cassandra\Tpc_q1;
use App\Models\Cassandra\Tpc_q3;
use App\Models\Cassandra\Tpc_q4;

class MasterCassandraController extends Controller
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
  
	function do_query($session, $query)
	{
		set_time_limit(200000);
		
		$statement = new Cassandra\SimpleStatement($query);
		$future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
		$result    = $future->get(); 
		
		return $result;
	}
	
	private function do_connection($keyspace  = 'b2c_small')
	{
		set_time_limit(200000);
		//$cluster   = Cassandra::cluster()
					 //->build();
		$cluster  = Cassandra::cluster()->withDefaultTimeout(1200)->build();
		$session  = $cluster->connect($keyspace);
		
		return $session;
	}
  
 public function return_query_statistic($count = 15){
	set_time_limit(200000);
		$keyspace  = 'b2c_small';
		//$keyspace = 'b2c_middle';
		//$keyspace = 'b2c_big';
	
		$q1 = "SELECT
			returnflag,
			linestatus,
			sum(quantity) as sum_qty,
			sum(extendedprice) as sum_base_price,
			sum(".$keyspace.".fSumDiscPrice(extendedprice,discount)) as sum_disc_price,
			sum(".$keyspace.".fSumChargePrice(extendedprice,discount,tax)) as sum_charge,
			avg(quantity) as avg_qty, avg(extendedprice) as avg_price,
			avg(discount) as avg_disc,
			count(*) as count_order
			FROM
			".$keyspace.".lineitem
			WHERE
			shipdate < 912524220
			and returnflag= 'N'
			and linestatus = 'O'
			ALLOW FILTERING 
		";
	
		$q3 = "
			SELECT
			orderkey,
			sum(".$keyspace.".fSumDiscPrice(l_extendedprice,l_discount)) as revenue,
			o_orderdate,
			l_shipdate,
			o_shippriority,
			linenumber
			from
			".$keyspace.".tpch_q3
			where
			o_orderdate < '1998-12-01'
			and l_shipdate > '1990-01-01'
			ALLOW FILTERING;
		";
			
		$q4 = "SELECT
			o_orderpriority,
			count(*) as order_count
			from
			".$keyspace.".tpch_q4
			where o_orderdate >= '1990-01-01'
			and o_orderdate < '2000-01-01'
			and l_commitdate < '2000-01-01'
			ALLOW FILTERING
			";
			
		$connection = $this->do_connection($keyspace);	
	
		$sum_q1 = 0;
		$sum_q3 = 0;
		$sum_q4 = 0;
		
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q1);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q1 += $timediff;
			$result_arr['query_exec_time_q1'][] = $timediff;
		}
		
		foreach ($result as $row) {
			
			$q1_result[] = [
				'returnflag' => $row['returnflag'],
				'linestatus' => $row['linestatus'],
				'sum_qty' => $row['sum_qty'],
				'sum_base_price' => $row['sum_base_price'],
				'sum_disc_price' => $row['sum_disc_price'],
				'sum_charge' => $row['sum_charge'],
				'avg_qty' => $row['avg_qty'],
				'avg_price' => $row['avg_price'],
				'avg_disc' => $row['avg_disc'],
				'count_order' => sprintf( $row['count_order'])
			];
		}
		
		$connection = $this->do_connection($keyspace);
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q3);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q3 += $timediff;
			$result_arr['query_exec_time_q3'][] = $timediff;
		}
		
		foreach ($result as $row) {
			$q3_result[] = [
					'orderkey' => $row['orderkey'],
					'revenue' => $row['revenue'],
					'o_orderdate' => sprintf($row['o_orderdate']),
					'l_shipdate' => sprintf($row['l_shipdate']),
					'o_shippriority' => $row['o_shippriority'],
					'linenumber' => $row['linenumber'],
					
			];
		}

		
		$connection = $this->do_connection($keyspace);
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q4);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q4 += $timediff;
			$result_arr['query_exec_time_q4'][] = $timediff;
		}
		
		foreach ($result as $row) {
			$q4_result[] = [
					'o_orderpriority' => $row['o_orderpriority'],
					'order_count' => sprintf( $row['order_count'])
			];
		}
		
		$result_arr['avg']['q1'] = $sum_q1 / $count;
		$result_arr['avg']['q2'] = $sum_q3 / $count;
		$result_arr['avg']['q3'] = $sum_q4 / $count;
		$result_arr['result']['q1'] = $q1_result;
		$result_arr['result']['q3'] = $q3_result;
		$result_arr['result']['q4'] = $q4_result;
		
		
		echo '<pre>';
		print_r($result_arr);
		
		return $result_arr;
	}
	
	function q1_statistic($count='15')
	{
		$keyspace  = 'b2c_small';
		//$keyspace = 'b2c_middle';
		//$keyspace = 'b2c_big';
		
		$connection = $this->do_connection($keyspace);
	
		$q1 = "SELECT
			returnflag,
			linestatus,
			sum(quantity) as sum_qty,
			sum(extendedprice) as sum_base_price,
			sum(".$keyspace.".fSumDiscPrice(extendedprice,discount)) as sum_disc_price,
			sum(".$keyspace.".fSumChargePrice(extendedprice,discount,tax)) as sum_charge,
			avg(quantity) as avg_qty, avg(extendedprice) as avg_price,
			avg(discount) as avg_disc,
			count(*) as count_order
			FROM
			".$keyspace.".lineitem
			WHERE
			shipdate < 912524220
			and returnflag= 'N'
			and linestatus = 'O'
			ALLOW FILTERING 
		";
		
		$sum_q1 = 0;
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q1);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q1 += $timediff;
			$result_arr['query_exec_time'][] = $timediff;
		}
		
		foreach ($result as $row) {
			$result_arr['result'][] = [
				'sum_qty' => $row['sum_qty'],
				'sum_base_price' => $row['sum_base_price'],
				'sum_disc_price' => $row['sum_disc_price'],
				'sum_charge' => $row['sum_charge'],
				'avg_price' => $row['avg_price'],
				'avg_qty' => $row['avg_qty'],
				'avg_disc' => $row['avg_disc'],
				'count_order' => sprintf( $row['count_order']),
				'returnflag' => $row['returnflag'],
				'linestatus' => $row['linestatus'],
			];
		}
		
		$result_arr['avg'] = $sum_q1 / $count;
		
		return $result_arr;
	}
	
	function q3_statistic($count='15')
	{	
		$keyspace  = 'b2c_small';
		//$keyspace = 'b2c_middle';
		//$keyspace = 'b2c_big';
		
		$connection = $this->do_connection($keyspace);
	
		/*$q3 = "
			SELECT
			orderkey,
			sum(".$keyspace.".fSumDiscPrice(l_extendedprice,l_discount)) as revenue,
			o_orderdate,
			l_shipdate,
			o_shippriority,
			linenumber
			from
			".$keyspace.".tpch_q3
			where
			o_orderdate < '1998-12-01'
			and l_shipdate > '1990-01-01'
			ALLOW FILTERING
		";*/
		
		$q3 = "
			SELECT
			orderkey,
			sum(".$keyspace.".fSumDiscPrice(l_extendedprice,l_discount)) as revenue,
			o_orderdate,
			l_shipdate,
			o_shippriority,
			linenumber
			from
			".$keyspace.".tpch_q3
			where
			c_mktsegment = 'AUTOMOBILE'
			and o_shippriority = '0'
			and o_orderdate <= '1998-12-01'
			ALLOW FILTERING
		";
		
	
		
		$sum_q3 = 0;
		
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q3);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q3 += $timediff;
			$result_arr['query_exec_time_q3'][] = $timediff;
		}
		
		foreach ($result as $row) {
			$result_arr['result'][] = [
					'orderkey' => $row['orderkey'],
					'revenue' => $row['revenue'],
					'o_orderdate' => date('Y-m-d', substr(sprintf($row['o_orderdate']),0,9)),
					'l_shipdate' =>  date('Y-m-d', substr(sprintf($row['l_shipdate']),0, 9)),
					'o_shippriority' => $row['o_shippriority'],
					'linenumber' => $row['linenumber'],
					
			];
		}

		$result_arr['avg'] = $sum_q3 / $count;
		
		return $result_arr;
	}
	
	function q4_statistic($count='15')
	{
		$keyspace  = 'b2c_small';
		//$keyspace = 'b2c_middle';
		//$keyspace = 'b2c_big';
		$connection = $this->do_connection($keyspace);	
		
		$q4 = "SELECT
			o_orderpriority,
			count(*) as order_count
			from
			".$keyspace.".tpch_q4
			where o_orderdate >= '1990-01-01'
			and o_orderdate < '2000-01-01'
			and l_commitdate < '2000-01-01'
			ALLOW FILTERING
			";

		$sum_q4 = 0;
		for ($i = 1; $i <= $count; $i++) {
			$starttime = microtime(true);
				$result = $this->do_query($connection, $q4);
			$endtime = microtime(true);
			$timediff = $endtime - $starttime;
			
			$sum_q4 += $timediff;
			$result_arr['query_exec_time_q4'][] = $timediff;
		}
		
		foreach ($result as $row) {
			$result_arr['result'][] = [
					'o_orderpriority' => $row['o_orderpriority'],
					'order_count' => sprintf( $row['order_count'])
			];
		}
	
		$result_arr['avg'] = $sum_q4 / $count;
		
		return $result_arr;
	}
	
	public function removde_tables($connection = 'cassandra_small')
	{
		$connection = 'cassandra_small';
		//$connection = 'cassandra_middle';
		//$connection = 'cassandra_big';
		$database_arr = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.tpch_q1');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.tpch_q3');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.tpch_q4');
		
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.supplier');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.part');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.partsupp');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.customer');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.nation');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.region');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.lineitem');
		DB::connection($connection)->execute('DROP TABLE '.$database_arr[$connection].'.orders');
		
		DB::connection($connection)->execute('DROP FUNCTION IF EXISTS '.$database_arr[$connection].'.fSumDiscPrice');
		DB::connection($connection)->execute('DROP FUNCTION IF EXISTS '.$database_arr[$connection].'.fSumChargePrice');
	}
	
	private function create_cassandra_functions($connection = 'cassandra_small')
	{
		$database = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		DB::connection($connection)->execute("
		CREATE OR REPLACE FUNCTION  ". $database[$connection] . ".fSumDiscPrice (l_extendedprice double,l_discount double) CALLED ON NULL INPUT RETURNS double LANGUAGE java AS 'return (Double.valueOf( l_extendedprice.doubleValue() *  (1.0 - l_discount.doubleValue() ) ));'
		");
	
		DB::connection($connection)->execute("
			CREATE OR REPLACE FUNCTION ". $database[$connection] . ".fSumChargePrice (l_extendedprice double,l_discount double,l_tax double) CALLED ON NULL INPUT RETURNS double LANGUAGE java AS 'return (Double.valueOf( l_extendedprice.doubleValue() *  (1.0 - l_discount.doubleValue() ) * (1.0 + l_tax.doubleValue()) ));'
		");
	}
	
	private function generate_test_data($connection = 'cassandra_small')
	{
		//$connection = 'cassandra_small';
		//$connection = 'cassandra_middle';
		//$connection = 'cassandra_big';
		
		$database = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		$tpc_q1 = new Tpc_q1();
		$data_arr = $tpc_q1->return_data();	
		foreach($data_arr as $data){
			DB::connection($connection)->table('tpch_q1')->insert($data);
		}
		
		/*$tpc_q3 = new Tpc_q3();
		$data_arr = $tpc_q3->return_data();	
		foreach($data_arr as $data){
			DB::connection($database)->table('tpch_q3')->insert($data);
		}
				
		$tpc_q4 = new Tpc_q4();
		$data_arr = $tpc_q4->return_data();	
		foreach($data_arr as $data){
			DB::connection($database)->table('tpch_q4')->insert($data);
		}*/

		$tpc_q3 = new Tpc_q3();
		$data_arr = $tpc_q3->return_data();	
		foreach($data_arr as $data){
			DB::connection($connection)->execute("
				INSERT INTO ".$database[$connection].".TPCH_Q3 (orderkey, linenumber, o_orderdate, o_shippriority, c_mktsegment, l_extendedprice, l_discount, l_shipdate)
				VALUES ('".$data['orderkey']."', '".$data['linenumber']."', '".$data['o_orderdate']."', '".$data['o_shippriority']."', '".$data['c_mktsegment']."', ".$data['l_extendedprice'].", ".$data['l_discount'].", '".$data['l_shipdate']."');
			");
		}
				
		$tpc_q4 = new Tpc_q4();
		$data_arr = $tpc_q4->return_data();	
		foreach($data_arr as $data){
			
			DB::connection($connection)->execute("
				INSERT INTO ".$database[$connection].".TPCH_Q4 (orderkey, linenumber, o_orderpriority, o_orderdate, l_receiptdate, l_commitdate)
				VALUES ('".$data['orderkey']."', '".$data['linenumber']."', '".$data['o_orderpriority']."', '".$data['o_orderdate']."', '".$data['l_receiptdate']."', '".$data['l_commitdate']."');
			");
		}
		
		//Start default tables
		$supplier = new Supplier();
		$data_arr = $supplier->return_data();	
		foreach($data_arr as $data){
			DB::connection($connection)->table('Supplier')->insert($data);
		}
		
		$part = new Part();
		$data_arr = $part->return_data();
		foreach($data_arr as $data){
		DB::connection($connection)->table('Part')->insert($data);
		}
		
		$partsupp = new Partsupp();
		$data_arr = $partsupp->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Partsupp')->insert($data);
		}
		
		$customer = new Customer();
		$data_arr = $customer->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Customer')->insert($data);
		}

		$nation = new Nation();
		$data_arr = $nation->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Nation')->insert($data);
		}
		
		$region = new Region();
		$data_arr = $region->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Region')->insert($data);
		}

		$lineitem = new Lineitem();
		$data_arr = $lineitem->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Lineitem')->insert($data);
		}
		
		$orders = new Orders();
		$data_arr = $orders->return_data();
		foreach($data_arr as $data){
			DB::connection($connection)->table('Orders')->insert($data);
		}
		
	}
	
	public function generate_tables()
	{
		$connection = 'cassandra_small';
		//$connection = 'cassandra_middle';
		//$connection = 'cassandra_big';
		$database = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		$this->create_cassandra_functions($connection);
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.TPCH_Q1(
				orderkey int,
				linestatus text,
				linenumber int,
				returnflag text,
				quantity int,
				extendedprice double,
				discount double,
				tax double,
				shipdate int,
				PRIMARY KEY ((returnflag,linestatus),shipdate,orderkey,linenumber)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.TPCH_Q3(
				orderkey text,
				linenumber text,
				o_orderdate timestamp,
				o_shippriority text,
				c_mktsegment text,
				l_extendedprice double,
				l_discount double,
				l_shipdate timestamp,
				PRIMARY KEY (c_mktsegment, o_shippriority, o_orderdate)
				//PRIMARY KEY ((orderkey,o_shippriority),c_mktsegment,linenumber)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.TPCH_Q4(
				orderkey text,
				linenumber text,
				o_orderpriority text,
				o_orderdate timestamp,
				l_receiptdate timestamp,
				l_commitdate timestamp,
				PRIMARY KEY (o_orderpriority,o_orderdate,orderkey,linenumber)
			);
		');
		
		//Start default tables
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Supplier(
				SUPPKEY int,
				NAME text,
				ADDRESS text,
				NATIONKEY int,
				PHONE text,
				ACCTBAL double,
				COMMENT text,
				PRIMARY KEY (SUPPKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Part(
				PARTKEY int,
				NAME text,
				MFGR text,
				BRAND text,
				TYPE text,
				SIZE int,
				CONTAINER text,
				RETAILPRICE double,
				COMMENT text,
				PRIMARY KEY (PARTKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Partsupp(
				PARTKEY int,
				SUPPKEY int,
				AVAILQTY int,
				SUPPLYCOST double,
				COMMENT text,
				PRIMARY KEY (PARTKEY, SUPPKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Customer(
				CUSTKEY int,
				NAME text,
				ADDRESS text,
				NATIONKEY int,
				PHONE text,
				ACCTBAL double,
				MKTSEGMENT text,
				COMMENT text,
				PRIMARY KEY (CUSTKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Nation(
				NATIONKEY int,
				NAME text,
				REGIONKEY int,
				COMMENT text,
				PRIMARY KEY (NATIONKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Region(
				REGIONKEY int,
				NAME text,
				COMMENT text,
				PRIMARY KEY (REGIONKEY)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Lineitem(
				ORDERKEY int,
				PARTKEY int,
				SUPPKEY int,
				LINENUMBER int,
				QUANTITY int,
				EXTENDEDPRICE double,
				DISCOUNT double,
				TAX double,
				RETURNFLAG text,
				LINESTATUS text,
				SHIPDATE int,
				COMMITDATE int,
				RECEIPTDATE int,
				SHIPINSTRUCT text,
				SHIPMODE text,
				COMMENT text,
				PRIMARY KEY (ORDERKEY,PARTKEY,SUPPKEY,LINENUMBER)
			);
		');
		
		DB::connection($connection)->execute('
			CREATE TABLE IF NOT EXISTS '.$database[$connection].'.Orders(
				ORDERKEY int,
				CUSTKEY int,
				ORDERSTATUS text,
				TOTALPRICE double,
				ORDERDATE int,
				ORDERPRIORITY text,
				CLERK text,
				SHIPPRIORITY int,
				COMMENT text,
				PRIMARY KEY (ORDERKEY, CUSTKEY)
			);
		');
		
		$this->generate_test_data($connection);
	}
	
	function generate_big_data(){
		
		set_time_limit(200000);
		
		//$connection = 'cassandra_small';
		//$connection = 'cassandra_middle';
		$connection = 'cassandra_big';
		
		$size_arr = [
			'cassandra_small' => '5000',
			'cassandra_middle' => '50000',
			'cassandra_big' => '500000'
		];
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_tpc_3($connection);
		}
		/*for ($i = 1; $i <= 300000; $i++) {
			$this->insert_part($connection);
		}

		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_supplier($connection);
		}
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_part_supplier($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_customer($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_lineitem($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_orders($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_tpc_1($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_tpc_3($connection);
		}
		
		for ($i = 1; $i <= $size_arr[$connection]; $i++) {
			$this->insert_tpc_4($connection);
		}*/
		
	}
	
	public function insert_part($connection = 'cassandra_small')
	{
		//Primary Key: P_PARTKEY

		$data = [
			//P_PARTKEY 															identifier SF*200,000 are populated
			'PARTKEY' => rand(1,200000),
			'NAME' => $this->generate_string(55),							//variable text, size 55
			'MFGR' => $this->generate_string(25),							//fixed text, size 25
			'BRAND' => $this->generate_string(10),							//fixed text, size 10
			'TYPE' => $this->generate_string(25),							//variable text, size 25
			'SIZE' => rand(1,9),											//integer
			'CONTAINER' => $this->generate_string(10),						//fixed text, size 10
			'RETAILPRICE' => 22.22,											//decimal
			'COMMENT' => $this->generate_string(23)							//variable text, size 23
		];
		
		$insertData = DB::connection($connection)->table('Part')->insert($data);
	
	}
	
	public function insert_supplier($connection = 'cassandra_small')
	{
		//Primary Key: S_SUPPKEY
		$data = [
			//S_SUPPKEY 												identifier SF*10,000 are populated
			'SUPPKEY' => rand(1, 10000),
			'NAME' => $this->generate_string(25),			//fixed text, size 25
			'ADDRESS' => $this->generate_string(40),		//variable text, size 40
			'NATIONKEY' => rand(1, 25),						//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => '99-199-6000',						//fixed text, size 15
			'ACCTBAL' => 33.33,								//decimal
			'COMMENT' => $this->generate_string(100)		//variable text, size 101
		];
		
		$insertData = DB::connection($connection)->table('Supplier')->insert($data);
	}
	
	public function insert_part_supplier($connection = 'cassandra_small')
	{
		//Primary Key: PS_PARTKEY, PS_SUPPKEY
		
		$data = [
			'PARTKEY' => rand(1, 200000),						//Identifier Foreign Key to P_PARTKEY
			'SUPPKEY' => rand(1, 10000),						//Identifier Foreign Key to S_SUPPKEY
			'AVAILQTY' => rand(1, 10000),						//integer
			'SUPPLYCOST' => 44.44,								//Decimal
			'COMMENT' => $this->generate_string(150)			//variable text, size 199
		
		];
		
		$insertData = DB::connection($connection)->table('Partsupp')->insert($data);
	}
	
	public function insert_customer($connection = 'cassandra_small')
	{
		//Primary Key: C_CUSTKEY
		
		$data = [
			//C_CUSTKEY 													Identifier SF*150,000 are populated
			'CUSTKEY' => rand(1, 150000),
			'NAME' => $this->generate_string(25),							//variable text, size 25
			'ADDRESS' => $this->generate_string(40),						//variable text, size 40
			'NATIONKEY' => rand(1, 25),										//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),			//fixed text, size 15
			'ACCTBAL' => 55.55,												//Decimal
			'MKTSEGMENT' => $this->generate_string(10),						//fixed text, size 10
			'COMMENT' => $this->generate_string(117)						//variable text, size 117
		];
		
		$insertData = DB::connection($connection)->table('Customer')->insert($data);
	}
	
	public function insert_lineitem($connection = 'cassandra_small')
	{
		//Primary Key: L_ORDERKEY, L_LINENUMBER
		$data = [
			'ORDERKEY' => rand(1, 1500000), 									//identifier Foreign Key to O_ORDERKEY
			'PARTKEY' => rand(1, 200000), 										//identifier Foreign key to P_PARTKEY, first part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_SUPPKEY
			'SUPPKEY' => rand(1, 10000),										//Identifier Foreign key to S_SUPPKEY, second part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_PARTKEY
			'LINENUMBER' => rand(1, 1000000),									//integer
			'QUANTITY' => rand(1, 200000),												//decimal
			'EXTENDEDPRICE' => 77.77,											//decimal
			'DISCOUNT' => 88.88,												//decimal
			'TAX' => 99.99,														//decimal
			'RETURNFLAG' => $this->generate_just_string(1),						//fixed text, size 1
			'LINESTATUS' => $this->generate_just_string(1),						//fixed text, size 1
			'SHIPDATE' => strtotime($this->rand_date()),									//date
			'COMMITDATE' => strtotime($this->rand_date()),									//date
			'RECEIPTDATE' => strtotime($this->rand_date()),								//date
			'SHIPINSTRUCT' => $this->generate_string(25),						//fixed text, size 25
			'SHIPMODE' => $this->generate_string(10),							//fixed text, size 10
			'COMMENT' => $this->generate_string(44)								//variable text size 44
		];
		
		DB::connection($connection)->table('Lineitem')->insert($data);
	}
	
	public function insert_orders($connection = 'cassandra_small')
	{
		//Primary Key: O_ORDERKEY

		$data = [
			//O_ORDERKEY 															Identifier SF*1,500,000 are sparsely populated 
			'ORDERKEY' => rand(1, 1500000),
			'CUSTKEY' => rand(1, 150000), 								//Identifier Foreign Key to C_CUSTKEY
			'ORDERSTATUS' => $this->generate_string(1), 								//fixed text, size 1
			'TOTALPRICE' => 22.22, 										//Decimal
			'ORDERDATE' => strtotime($this->rand_date()),						 	//date
			'ORDERPRIORITY' => $this->generate_string(5),							//fixed text, size 15
			'CLERK' => $this->generate_numbers(15),						//fixed text, size 15
			'SHIPPRIORITY' => rand(0, 4), 								//integer
			'COMMENT' => $this->generate_string(79)						//variable text, size 79
		];
		
		$insertData = DB::connection($connection)->table('Orders')->insert($data);
	}
	
	public function insert_tpc_1($connection = 'cassandra_small')
	{
		$data = [
			'ORDERKEY' => rand(1, 1500000),
			'LINENUMBER' => rand(1,1000000),
			'QUANTITY' => rand(1,20000),
			'EXTENDEDPRICE' => 21168.23,
			'DISCOUNT' => 0.04,
			'TAX' => 0.02,
			'RETURNFLAG' => $this->generate_string(1),
			'LINESTATUS' => $this->generate_string(1),
			'SHIPDATE' => strtotime($this->rand_date())
		];
		
		$insertData = DB::connection($connection)->table('tpch_q1')->insert($data);
	}
	
	public function insert_tpc_3($connection = 'cassandra_small')
	{
		$l_extendedprice = 21168.23;
		$l_discount = 0.04;
		
		$database = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		DB::connection($connection)->execute("
				INSERT INTO ".$database[$connection].".TPCH_Q3 (orderkey, linenumber, o_orderdate, o_shippriority, c_mktsegment, l_extendedprice, l_discount, l_shipdate)
				VALUES ('".rand(1, 1500000)."', '".rand(1,1000000)."', '".date('Y-m-d',strtotime($this->rand_date()))."', '".rand(0,9)."', '".$this->generate_string(7)."', ".$l_extendedprice.", ".$l_discount.", '".date('Y-m-d',strtotime($this->rand_date()))."');
			");
	
		
		//$insertData = DB::connection($connection)->table('tpch_q3')->insert($data);
	}
	
	public function insert_tpc_4($connection = 'cassandra_small')
	{
		$database = [
			'cassandra_small' => 'b2c_small',
			'cassandra_middle' => 'b2c_middle',
			'cassandra_big' => 'b2c_big'
		];
		
		DB::connection($connection)->execute("
				INSERT INTO ".$database[$connection].".TPCH_Q4 (orderkey, linenumber, o_orderpriority, o_orderdate, l_receiptdate, l_commitdate)
				VALUES ('".rand(1, 1500000)."', '".rand(1,1000000)."', '".$this->generate_string(7)."', '".date('Y-m-d',strtotime($this->rand_date()))."', '".date('Y-m-d',strtotime($this->rand_date()))."', '".date('Y-m-d',strtotime($this->rand_date()))."');
			");
	}
	
}
	
