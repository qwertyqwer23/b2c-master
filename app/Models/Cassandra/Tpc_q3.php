<?
namespace App\Models\Cassandra;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Tpc_q3 extends NeoEloquent  {
	
    protected $fillable = ['orderkey','linenumber', 'o_orderdate', 'o_shippriority', 'c_mktsegment', 'l_extendedprice', 'l_discount', 'l_shipdate'];
	
	public function return_data()
	{
		return [
			[
				'orderkey' => 1,
				'linenumber' => 1,
				'o_orderdate' => '1996-01-02',
				'o_shippriority' => 0,
				'c_mktsegment' => 'AUTOMOBILE',
				'l_extendedprice' => 21168.23,
				'l_discount' => 0.04,
				'l_shipdate' => '1996-03-13'
			],
			[
				'orderkey' => 2,
				'linenumber' => 2,
				'o_orderdate' => '1996-12-01',
				'o_shippriority' => 0,
				'c_mktsegment' => 'AUTOMOBILE',
				'l_extendedprice' => 45983.16,
				'l_discount' => 0.09,
				'l_shipdate' => '1996-04-12'
			],
			[
				'orderkey' => 3,
				'linenumber' => 3,
				'o_orderdate' => '1993-10-14',
				'o_shippriority' => 0,
				'c_mktsegment' => 'BUILDING',
				'l_extendedprice' => 13309.60,
				'l_discount' => 0.10,
				'l_shipdate' => '1996-01-29'
			],
			[
				'orderkey' => 4,
				'linenumber' => 4,
				'o_orderdate' => '1995-10-11',
				'o_shippriority' => 0,
				'c_mktsegment' => 'HOUSEHOLD',
				'l_extendedprice' => 28955.64,
				'l_discount' => 0.09,
				'l_shipdate' => '1996-04-21'
			],
			[
				'orderkey' => 5,
				'linenumber' => 5,
				'o_orderdate' => '1994-07-30',
				'o_shippriority' => 0,
				'c_mktsegment' => 'MACHINERY',
				'l_extendedprice' => 22824.48,
				'l_discount' => 0.10,
				'l_shipdate' => '1996-03-30'
			]	
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
