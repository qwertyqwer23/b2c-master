<?
namespace App\Models\Cassandra;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Tpc_q4 extends NeoEloquent  {
	
    protected $fillable = ['orderkey','linenumber', 'o_orderpriority', 'o_orderdate', 'l_receiptdate', 'l_commitdate'];

	public function return_data()
	{
		return [
			[
				'orderkey' => 1,
				'linenumber' => 1,
				'o_orderpriority' => '5-LOW',
				'o_orderdate' => '1996-01-02',
				'l_receiptdate' => '1996-03-22',
				'l_commitdate' => '1996-02-12'
			],
			[
				'orderkey' => 2,
				'linenumber' => 2,
				'o_orderpriority' => '1-URGENT',
				'o_orderdate' => '1996-12-01',
				'l_receiptdate' => '1996-04-20',
				'l_commitdate' => '1996-02-28'
			],
			[
				'orderkey' => 3,
				'linenumber' => 3,
				'o_orderpriority' => '5-LOW',
				'o_orderdate' => '1993-10-14',
				'l_receiptdate' => '1996-01-31',
				'l_commitdate' => '1996-03-05'
			],
			[
				'orderkey' => 4,
				'linenumber' => 4,
				'o_orderpriority' => '5-LOW',
				'o_orderdate' => '1995-10-11',
				'l_receiptdate' => '1996-05-16',
				'l_commitdate' => '1996-03-30'
			],
			[
				'orderkey' => 5,
				'linenumber' => 5,
				'o_orderpriority' => '5-LOW',
				'o_orderdate' => '1994-07-30',
				'l_receiptdate' => '1996-04-01',
				'l_commitdate' => '1996-03-14'
			]	
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
