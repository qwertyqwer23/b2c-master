<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class MasterRedisController extends Controller
{
  
    public function test()
    {
		//Redis::connection('default')->hSet('h2', 'key2', 'hello2');
		//$redis = Redis::connection('default')->command('HSET',[12345 => ['name'  => "Post A", 'val2' => "Blah Blah", 'val3' => "Blah Blah Blah"]]);

		$qq = Redis::connection('default')->hGet('h2','key2');
		dd($qq);
		
		//$values = Redis::command('lrange', ['name', 5, 10]);
		$values = Redis::lrange('names', 5, 10);
		dd($values);
      //  $user = Redis::get('user:profile:'.$id);

        //return view('user.profile', ['user' => $user]);
    }
	
	function generate_big_data(){
		
		set_time_limit(200000);
		
		for ($i = 1; $i <= 200000; $i++) {
			$this->insert_part();
		}
		for ($i = 1; $i <= 10000; $i++) {
			$this->insert_supplier();
		}
		for ($i = 1; $i <= 800000; $i++) {
			$this->insert_part_supplier();
		}
		
		for ($i = 1; $i <= 150000; $i++) {
			$this->insert_customer();
		}
		
		for ($i = 1; $i <= 20; $i++) {
			$this->insert_nation();
		}
		
		for ($i = 1; $i <= 6000000; $i++) {
			$this->insert_lineitem();
		}
		
		for ($i = 1; $i <= 150000; $i++) {
			$this->insert_orders();
		}
	}
	
	public function insert_part()
	{
		//Primary Key: P_PARTKEY
		
		$data = [
			//P_PARTKEY 															identifier SF*200,000 are populated
			'NAME' => $this->generate_string(55),									//variable text, size 55
			'MFGR' => $this->generate_string(25),									//fixed text, size 25
			'BRAND' => $this->generate_string(10),									//fixed text, size 10
			'TYPE' => $this->generate_string(25),									//variable text, size 25
			'SIZE' => $this->generate_numbers(2),									//integer
			'CONTAINER' => $this->generate_string(10),								//fixed text, size 10
			'RETAILPRICE' => $this->generate_string(rand(1, 9)).'.'.rand(10, 99),	//decimal
			'COMMENT' => $this->generate_string(23)									//variable text, size 23
		];
		
		$insertData = DB::connection('mongodb')->collection('Part')->insert($data);
	
	}
	
	public function insert_supplier()
	{
		//Primary Key: S_SUPPKEY
		$data = [
			//S_SUPPKEY 												identifier SF*10,000 are populated	
			'NAME' => $this->generate_string(25),						//fixed text, size 25
			'ADDRESS' => $this->generate_string(40),					//variable text, size 40
			'NATIONKEY' => rand(1, 25),									//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),		//fixed text, size 15
			'ACCTBAL' => rand(1,99). '.' . rand(10, 99),			//decimal
			'COMMENT' => $this->generate_string(100)					//variable text, size 101
		];
		
		$insertData = DB::connection('mongodb')->collection('Supplier')->insert($data);
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
		
		$insertData = DB::connection('mongodb')->collection('Partsupp')->insert($data);
	}
	
	public function insert_customer()
	{
		//Primary Key: C_CUSTKEY
		
		$data = [
			//C_CUSTKEY 													Identifier SF*150,000 are populated
			'NAME' => $this->generate_string(25),							//variable text, size 25
			'ADDRESS' => $this->generate_string(40),						//variable text, size 40
			'NATIONKEY' => rand(1, 25),										//Identifier Foreign Key to N_NATIONKEY
			'PHONE' => rand(1,99).'-'.rand(1,199).'-'.rand(1,6000),			//fixed text, size 15
			'ACCTBAL' => rand(1,99). '.' . rand(10, 99),				//Decimal
			'MKTSEGMENT' => $this->generate_string(10),						//fixed text, size 10
			'COMMENT' => $this->generate_string(117)						//variable text, size 117
		];
		
		$insertData = DB::connection('mongodb')->collection('Customer')->insert($data);
	}
	
	public function insert_nation()
	{
		//Primary Key: N_NATIONKEY
		
		$data = [
		//	 N_NATIONKEY 								identifier 25 nations are populated
			'NAME' => $this->generate_string(25),		//fixed text, size 25
			'REGIONKEY' => rand(1, 5),					//identifier Foreign Key to R_REGIONKEY
			'COMMENT' => $this->generate_string(152)	//variable text, size 152
		];
		
		$insertData = DB::connection('mongodb')->collection('Nation')->insert($data);
	}
	
	public function insert_region()
	{
		//Primary Key: R_REGIONKEY

		$data = [
		//	 R_REGIONKEY 								identifier 5 regions are populated
			'NAME' => $this->generate_string(25), 		//fixed text, size 25
			'COMMENT' => $this->generate_string(152)	//variable text, size 152
		];
		
		$insertData = DB::connection('mongodb')->collection('Region')->insert($data);
	}
	
	public function insert_lineitem()
	{
		//Primary Key: L_ORDERKEY, L_LINENUMBER
		$data = [
			'ORDERKEY' => rand(1, 1500000), 							//identifier Foreign Key to O_ORDERKEY
			'PARTKEY' => rand(1, 200000), 								//identifier Foreign key to P_PARTKEY, first part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_SUPPKEY
			'SUPPKEY' => rand(1, 10000),								//Identifier Foreign key to S_SUPPKEY, second part of the compound Foreign Key to (PS_PARTKEY, PS_SUPPKEY) with L_PARTKEY
			'LINENUMBER' => 0,											//integer
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
		
		$insertid = DB::connection('mongodb')->collection('Lineitem')->insertGetId($data);
		DB::connection('mongodb')->collection('Lineitem')->where('_id', $insertid)->update(['LINENUMBER' => $insertid, ['upsert' => true]]);
		
		//$user = DB::collection('users')->where('name', 'John')->first();
		//die('here');
	}
	
	public function insert_orders()
	{
		//Primary Key: O_ORDERKEY

		$data = [
			//O_ORDERKEY 															Identifier SF*1,500,000 are sparsely populated 
			'CUSTKEY' => rand(1, 150000), 											//Identifier Foreign Key to C_CUSTKEY
			'ORDERSTATUS' => rand(0, 5), 											//fixed text, size 1
			'TOTALPRICE' => $this->generate_numbers(10). '.' . rand(1, 9) / 10, 	//Decimal
			'ORDERDATE' => $this->rand_date(),						 				//date
			'ORDER-PRIORITY' => rand(0, 3),											//fixed text, size 15
			'CLERK' => $this->generate_numbers(15),									//fixed text, size 15
			'SHIP-PRIORITY' => rand(0, 4), 											//integer
			'COMMENT' => $this->generate_string(79)									//variable text, size 79
		];
		
		$insertData = DB::connection('mongodb')->collection('Orders')->insert($data);
	}
}