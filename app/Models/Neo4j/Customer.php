<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Customer extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Customer';
    protected $fillable = ['id', 'NAME','ADDRESS', 'NATIONKEY', 'PHONE', 'ACCTBAL', 'MKTSEGMENT', 'COMMENT'];
		
	function return_data(){
		return [
			[
				'id' => 1,
				'NAME' => 'Customer#000000001',
				'ADDRESS' => 'IVhzIApeRb ot,c,E',
				'NATIONKEY' => 2,
				'PHONE' => '25-989-741-2988',
				'ACCTBAL' => 711.56,
				'MKTSEGMENT' => 'BUILDING',
				'COMMENT' => 'to the even, regular platelets. regular, ironic epitaphs nag e'
			],
			[
				'id' => 2,
				'NAME' =>'Customer#000000002',
				'ADDRESS' => 'XSTf4,NCwDVaWNe6tEgvwfmRchLXak',
				'NATIONKEY' => 4,
				'PHONE' => '23-768-687-3665',
				'ACCTBAL' => 121.65,
				'MKTSEGMENT' => 'AUTOMOBILE',
				'COMMENT' => 'l accounts. blithely ironic theodolites integrate boldly: caref'
			],
			[
				'id' => 3,
				'NAME' => 'Customer#000000003',
				'ADDRESS' => 'MG9kdTD2WBHm',
				'NATIONKEY' => 1,
				'PHONE' => '11-719-748-3364',
				'ACCTBAL' => 7498.12,
				'MKTSEGMENT' => 'AUTOMOBILE',
				'COMMENT' =>  'deposits eat slyly ironic, even instructions. express foxes detect slyly. blithely even accounts abov'
			],
			[
				'id' => 4,
				'NAME' => 'Customer#000000004',
				'ADDRESS' => 'XxVSJsLAGtn',
				'NATIONKEY' => 3,
				'PHONE' => '14-128-190-5944',
				'ACCTBAL' => 2866.83,
				'MKTSEGMENT' => 'MACHINERY',
				'COMMENT' =>  'requests. final, regular ideas sleep final accou'
			],
			[
				'id' => 5,
				'NAME' => 'Customer#000000005',
				'ADDRESS' => 'KvpyuHCplrB84WgAiGV6sYpZq7Tj',
				'NATIONKEY' => 5,
				'PHONE' => '13-750-942-6364',
				'ACCTBAL' => 794.47,
				'MKTSEGMENT' => 'HOUSEHOLD',
				'COMMENT' => 'n accounts will have to unwind. foxes cajole accor'
			]
		];
	}
	
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}