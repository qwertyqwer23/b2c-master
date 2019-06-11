<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Supplier extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Supplier';
    protected $fillable = ['id','NAME', 'ADDRESS', 'NATIONKEY', 'PHONE', 'ACCTBAL', 'COMMENT'];
	
	function return_data(){
		return [
			[
				'id' => 1,
				'NAME' => 'Supplier#000000001',
				'ADDRESS' => 'N kD4on9OM Ipw3,gf0JBoQDd7tgrzrddZ',
				'NATIONKEY' => 2,
				'PHONE' => '27-918-335-1736',
				'ACCTBAL' => 5755.94,
				'COMMENT' => 'each slyly above the careful'
			],
			[
				'id' => 2,
				'NAME' => 'Supplier#000000002',
				'ADDRESS' => '89eJ5ksX3ImxJQBvxObC',
				'NATIONKEY' => 5,
				'PHONE' => '15-679-861-2259',
				'ACCTBAL' => 4032.68,
				'COMMENT' =>  'slyly bold instructions. idle dependen'
			],
			[
				'id' => 3,
				'NAME' => 'Supplier#000000003',
				'ADDRESS' => 'q1,G3Pj6OjIuUYfUoH18BFTKP5aU9bEV3',
				'NATIONKEY' => 1,
				'PHONE' => '11-383-516-1199',
				'ACCTBAL' => 4192.40,
				'COMMENT' => 'blithely silent requests after the express dependencies are sl'
			],
			[
				'id' => 4,
				'NAME' => 'Supplier#000000004',
				'ADDRESS' => 'Bk7ah4CK8SYQTepEmvMkkgMwg',
				'NATIONKEY' => 3,
				'PHONE' => '25-843-787-7479',
				'ACCTBAL' => 4641.08,
				'COMMENT' => 'riously even requests above the exp'
			],
			[
				'id' => 5,
				'NAME' => 'Supplier#000000005',
				'ADDRESS' => 'Gcdm2rJRzl5qlTVzc',
				'NATIONKEY' => 4,
				'PHONE' => '21-151-690-3663',
				'ACCTBAL' => -283.84,
				'COMMENT' => '. slyly regular pinto bea'
			]
		];
	}
	
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}