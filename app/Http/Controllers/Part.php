<?
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

//namespace App;
namespace Vinelab\Cms;

//use Illuminate\Database\Eloquent\Model;
//Use DB;



class Part extends NeoEloquent  {

    protected $connection = 'neo4j';
	protected $label = 'Part';
    protected $fillable = ['name', 'mfgr', 'brand', 'type', 'size', 'container', 'retailprice', 'comment'];
}

$user = User::create(['name' => 'Some Name', 'email' => 'some@email.com']);

/*function create_part($data){
	$user = User::create(['name' => 'Some Name', 'email' => 'some@email.com']);
	dd($user);

}*/
