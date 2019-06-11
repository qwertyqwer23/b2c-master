<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Region extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Region';
    protected $fillable = ['id','NAME', 'COMMENT'];
	
	public function return_data()
	{
		return [
			[
				'id' => 0,
				'NAME' => 'AFRICA',
				'COMMENT' => 'lar deposits. blithely final packages cajole. regular waters are final requests. regular accounts are according to' 
			],
			[
				'id' => 1,
				'NAME' => 'AMERICA',
				'COMMENT' => 'hs use ironic, even requests. s'
			],
			[
				'id' => 2,
				'NAME' => 'ASIA',
				'COMMENT' => 'ges. thinly even pinto beans ca'
			],
			[
				'id' => 3,
				'NAME' => 'EUROPE',
				'COMMENT' => 'ly final courts cajole furiously final excuse'
			],
			[
				'id' => 4,
				'NAME' => 'MIDDLE EAST',
				'COMMENT' => 'uickly special accounts cajole carefully blithely close requests. carefully final asymptotes haggle furiousl'
			]
			
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
