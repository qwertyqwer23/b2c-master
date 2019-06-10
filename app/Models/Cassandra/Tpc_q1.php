<?
namespace App\Models\Cassandra;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Tpc_q1 extends NeoEloquent  {
	
    protected $fillable = ['ORDERKEY','LINENUMBER','QUANTITY', 'EXTENDEDPRICE', 'DISCOUNT', 'TAX', 'RETURNFLAG', 'LINESTATUS', 'SHIPDATE'];

	public function return_data()
	{
		
		return [
			[
				'ORDERKEY' => 1,
				'LINENUMBER' => 1,
				'QUANTITY' => 17,
				'EXTENDEDPRICE' => 21168.23,
				'DISCOUNT' => 0.04,
				'TAX' => 0.02,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => strtotime('1996-03-13')
			],
			[
				'ORDERKEY' => 2,
				'LINENUMBER' => 2,
				'QUANTITY' => 36,
				'EXTENDEDPRICE' => 45983.16,
				'DISCOUNT' => 0.09,
				'TAX' => 0.06,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => strtotime('1996-04-12')
			],
			[
				'ORDERKEY' => 3,
				'LINENUMBER' => 3,
				'QUANTITY' => 8,
				'EXTENDEDPRICE' => 13309.60,
				'DISCOUNT' => 0.10,
				'TAX' => 0.02,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => strtotime('1996-01-29')
			],
			[
				'ORDERKEY' => 4,
				'LINENUMBER' => 4,
				'QUANTITY' => 28,
				'EXTENDEDPRICE' => 28955.64,
				'DISCOUNT' => 0.09,
				'TAX' => 0.06,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => strtotime('1996-04-21')
			],
			[
				'ORDERKEY' => 5,
				'LINENUMBER' => 5,
				'QUANTITY' => 24,
				'EXTENDEDPRICE' => 22824.48,
				'DISCOUNT' => 0.10,
				'TAX' => 0.04,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => strtotime('1996-03-30')
			]	
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
