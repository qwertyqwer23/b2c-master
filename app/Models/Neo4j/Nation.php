<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Nation extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Nation';
    protected $fillable = ['id','NAME', 'REGIONKEY', 'COMMENT'];
	
	public function return_data()
	{
		return [
			[
				'id' => 0,
				'NAME' => 'ALGERIA',
				'REGIONKEY' => 0,
				'COMMENT' =>  'haggle. carefully final deposits detect slyly agai'
			],
			[
				'id' => 1,
				'NAME' => 'ARGENTINA',
				'REGIONKEY' => 1,
				'COMMENT' => 'al foxes promise slyly according to the regular accounts. bold requests alon'
			],
			[
				'id' => 2,
				'NAME' => 'BRAZIL',
				'REGIONKEY' => 2,
				'COMMENT' => 'y alongside of the pending deposits. carefully special packages are about the ironic forges. slyly special'
			],
			[
				'id' => 3,
				'NAME' => 'CANADA',
				'REGIONKEY' => 1,
				'COMMENT' => 'eas hang ironic, silent packages. slyly regular packages are furiously over the tithes. fluffily bold'
			],
			[
				'id' => 4,
				'NAME' => 'EGYPT',
				'REGIONKEY' => 4,
				'COMMENT' => 'y above the carefully unusual theodolites. final dugouts are quickly across the furiously regular d'
			],
			[
				'id' => 5,
				'NAME' => 'ETHIOPIA',
				'REGIONKEY' => 0,
				'COMMENT' => 'ven packages wake quickly. regu'
			]
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
