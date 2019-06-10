<?
namespace App\Models\Cassandra;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Partsupp extends NeoEloquent  {

    //protected $connection = 'neo4j';
	//protected $label = 'Partsupp';
    protected $fillable = ['PARTKEY','SUPPKEY', 'AVAILQTY', 'SUPPLYCOST', 'COMMENT'];
	
	function return_data(){
		return [
			[
				'PARTKEY' => 1,
				'SUPPKEY' => 2,
				'AVAILQTY' => 23325,
				'SUPPLYCOST' => 771.64,
				'COMMENT' => ', even theodolites. regular, final theodolites eat after the carefully pending foxes. furiously regular deposits sleep slyly. carefully bold realms above the ironic dependencies haggle careful'
			],
			[
				'PARTKEY' => 3,
				'SUPPKEY' => 5,
				'AVAILQTY' => 8076,
				'SUPPLYCOST' => 993.49,
				'COMMENT' =>  'ven ideas. quickly even packages print. pending multipliers must have to are fluff'
			],
			[
				'PARTKEY' => 4,
				'SUPPKEY' => 3,
				'AVAILQTY' => 3956,
				'SUPPLYCOST' => 337.09,
				'COMMENT' => 'after the fluffily ironic deposits? blithely special dependencies integrate furiously even excuses. blithely silent theodolites could have to haggle pending, express requests; fu'
			],
			[
				'PARTKEY' => 5,
				'SUPPKEY' => 1,
				'AVAILQTY' => 4069,
				'SUPPLYCOST' => 357.84,
				'COMMENT' => 'al, regular dependencies serve carefully after the quickly final pinto beans. furiously even deposits sleep quickly final, silent pinto beans. fluffily reg'
			],
			[
				'PARTKEY' => 2,
				'SUPPKEY' => 3,
				'AVAILQTY' => 8895,
				'SUPPLYCOST' => 378.49,
				'COMMENT' => 'nic accounts. final accounts sleep furiously about the ironic, bold packages. regular, regular accounts'
			]
		];
	}
	
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}