<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Part extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Part';
    protected $fillable = ['id','NAME', 'MFGR', 'BRAND', 'TYPE', 'SIZE', 'CONTAINER', 'RETAILPRICE', 'COMMENT'];
	
	public function return_data()
	{
		return [
			[
				'id' => 1,
				'NAME' => 'goldenrod lavender spring chocolate lace',
				'MFGR' => 'Manufacturer#1',
				'BRAND' => 'Brand#13',
				'TYPE' => 'PROMO BURNISHED COPPER',
				'SIZE' => 7,
				'CONTAINER' => 'JUMBO PKG',
				'RETAILPRICE' => 901.00,
				'COMMENT' => 'ly. slyly ironi'
			],
			[			
				'id' => 2,
				'NAME' => 'blush thistle blue yellow saddle',
				'MFGR' => 'Manufacturer#1',
				'BRAND' => 'Brand#13',
				'TYPE' => 'LARGE BRUSHED BRASS',
				'SIZE' => 1,
				'CONTAINER' => 'LG CASE',
				'RETAILPRICE' => 902.00,
				'COMMENT' => 'lar accounts amo'
			],
			[
				'id' => 3,
				'NAME' => 'spring green yellow purple cornsilk',
				'MFGR' => 'Manufacturer#4',
				'BRAND' => 'Brand#42',
				'TYPE' => 'STANDARD POLISHED BRASS',
				'SIZE' => 21,
				'CONTAINER' => 'WRAP CASE',
				'RETAILPRICE' => 903.00,
				'COMMENT' => 'egular deposits hag'
			],
			[
				'id' => 4,
				'NAME' => 'cornflower chocolate smoke green pink',
				'MFGR' => 'Manufacturer#3',
				'BRAND' => 'Brand#34',
				'TYPE' => 'SMALL PLATED BRASS',
				'SIZE' => 14,
				'CONTAINER' => 'MED DRUM',
				'RETAILPRICE' => 904.00,
				'COMMENT' => 'p furiously r'
			],
			[
				'id' => 5,
				'NAME' => 'forest brown coral puff cream',
				'MFGR' => 'Manufacturer#3',
				'BRAND' => 'Brand#32',
				'TYPE' => 'STANDARD POLISHED TIN',
				'SIZE' => 15,
				'CONTAINER' => 'SM PKG',
				'RETAILPRICE' => 905.00,
				'COMMENT' =>  'wake carefully'
			]
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
