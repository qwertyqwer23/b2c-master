<?
namespace App\Models\Neo4j;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Lineitem extends NeoEloquent  {

    protected $connection = 'neo4j_small';
	protected $label = 'Lineitem';
    protected $fillable = ['ORDERKEY','PARTKEY', 'SUPPKEY', 'LINENUMBER','QUANTITY', 'EXTENDEDPRICE', 'DISCOUNT', 'TAX', 'RETURNFLAG', 'LINESTATUS', 'SHIPDATE', 'COMMITDATE', 'RECEIPTDATE', 'SHIPINSTRUCT', 'SHIPMODE', 'COMMENT'];
			

	public function return_data()
	{
		return [
			[
				'ORDERKEY' => 1,
				'PARTKEY' => 1,
				'SUPPKEY' => 2,
				'LINENUMBER' => 1,
				'QUANTITY' => 17,
				'EXTENDEDPRICE' => 21168.23,
				'DISCOUNT' => 0.04,
				'TAX' => 0.02,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => '1996-03-13',
				'COMMITDATE' => '1996-02-12',
				'RECEIPTDATE' => '1996-03-22',
				'SHIPINSTRUCT' => 'DELIVER IN PERSON',
				'SHIPMODE' => 'TRUCK',
				'COMMENT' => 'egular courts above the'
			],
			[
				'ORDERKEY' => 2,
				'PARTKEY' => 3,
				'SUPPKEY' => 5,
				'LINENUMBER' => 2,
				'QUANTITY' => 36,
				'EXTENDEDPRICE' => 45983.16,
				'DISCOUNT' => 0.09,
				'TAX' => 0.06,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => '1996-04-12',
				'COMMITDATE' => '1996-02-28',
				'RECEIPTDATE' => '1996-04-20',
				'SHIPINSTRUCT' => 'TAKE BACK RETURN',
				'SHIPMODE' => 'MAIL',
				'COMMENT' => 'ly final dependencies: slyly bold'
			],
			[
				'ORDERKEY' => 3,
				'PARTKEY' => 4,
				'SUPPKEY' => 3,
				'LINENUMBER' => 3,
				'QUANTITY' => 8,
				'EXTENDEDPRICE' => 13309.60,
				'DISCOUNT' => 0.10,
				'TAX' => 0.02,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => '1996-01-29',
				'COMMITDATE' => '1996-03-05',
				'RECEIPTDATE' => '1996-01-31',
				'SHIPINSTRUCT' => 'TAKE BACK RETURN',
				'SHIPMODE' => 'REG AIR',
				'COMMENT' => 'riously. regular, express dep'
			],
			[
				'ORDERKEY' => 4,
				'PARTKEY' => 5,
				'SUPPKEY' => 1,
				'LINENUMBER' => 4,
				'QUANTITY' => 28,
				'EXTENDEDPRICE' => 28955.64,
				'DISCOUNT' => 0.09,
				'TAX' => 0.06,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => '1996-04-21',
				'COMMITDATE' => '1996-03-30',
				'RECEIPTDATE' => '1996-05-16',
				'SHIPINSTRUCT' => 'NONE',
				'SHIPMODE' => 'AIR',
				'COMMENT' => 'lites. fluffily even de'
			],
			[
				'ORDERKEY' => 5,
				'PARTKEY' => 2,
				'SUPPKEY' => 3,
				'LINENUMBER' => 5,
				'QUANTITY' => 24,
				'EXTENDEDPRICE' => 22824.48,
				'DISCOUNT' => 0.10,
				'TAX' => 0.04,
				'RETURNFLAG' => 'N',
				'LINESTATUS' => 'O',
				'SHIPDATE' => '1996-03-30',
				'COMMITDATE' => '1996-03-14',
				'RECEIPTDATE' => '1996-04-01',
				'SHIPINSTRUCT' => 'NONE',
				'SHIPMODE' => 'FOB',
				'COMMENT' => 'pending foxes. slyly re'
			]	
		];
	}
	/*public function createPart()
    {
        return $this->create('App\MovieType','TYPE');
    }  */
}
