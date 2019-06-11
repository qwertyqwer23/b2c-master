<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Orders extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Order';
    protected $fillable = ['id','CUSTKEY', 'ORDERSTATUS', 'TOTALPRICE', 'ORDERDATE', 'ORDERPRIORITY', 'CLERK', 'SHIPPRIORITY', 'COMMENT'];

	public function return_data()
	{
		return [
			[
				'id' => 1,
				'CUSTKEY' => 2,
				'ORDERSTATUS' => 'O',
				'TOTALPRICE' => 173665.47,
				'ORDERDATE' => '1996-01-02',
				'ORDERPRIORITY' => '5-LOW',
				'CLERK' => 'Clerk#000000951',
				'SHIPPRIORITY' => 0,
				'COMMENT' => 'nstructions sleep furiously among'
			],
			[			
				'id' => 2,
				'CUSTKEY' => 3,
				'ORDERSTATUS' => 'O',
				'TOTALPRICE' => 46929.18,
				'ORDERDATE' => '1996-12-01',
				'ORDERPRIORITY' => '1-URGENT',
				'CLERK' => 'Clerk#000000880',
				'SHIPPRIORITY' => 0,
				'COMMENT' =>  'foxes. pending accounts at the pending, silent asymptot'
			],
			[
				'id' => 3,
				'CUSTKEY' => 1,
				'ORDERSTATUS' => 'F',
				'TOTALPRICE' => 193846.25,
				'ORDERDATE' => '1993-10-14',
				'ORDERPRIORITY' => '5-LOW',
				'CLERK' => 'Clerk#000000955',
				'SHIPPRIORITY' => 0,
				'COMMENT' => 'sly final accounts boost. carefully regular ideas cajole carefully. depos'
			],
			[
				'id' => 4,
				'CUSTKEY' => 5,
				'ORDERSTATUS' => 'O',
				'TOTALPRICE' => 32151.78,
				'ORDERDATE' => '1995-10-11',
				'ORDERPRIORITY' => '5-LOW',
				'CLERK' => 'Clerk#000000124',
				'SHIPPRIORITY' => 0,
				'COMMENT' => 'sits. slyly regular warthogs cajole. regular, regular theodolites acro'
			],
			[
				'id' => 5,
				'CUSTKEY' => 4,
				'ORDERSTATUS' => 'F',
				'TOTALPRICE' => 144659.20,
				'ORDERDATE' => '1994-07-30',
				'ORDERPRIORITY' => '5-LOW',
				'CLERK' => 'Clerk#000000925',
				'SHIPPRIORITY' => 0,
				'COMMENT' => 'quickly. bold deposits sleep slyly. packages use slyly'
			]
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
