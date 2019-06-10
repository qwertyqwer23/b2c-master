<?
namespace Vinelab\Cms;
class User extends NeoEloquent {

    protected $label = 'User'; // or array('User', 'Fan')

    protected $fillable = ['name', 'email'];
}

$user = User::create(['name' => 'Some Name', 'email' => 'some@email.com']);