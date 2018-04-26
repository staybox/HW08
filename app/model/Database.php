<?php
namespace Acme\Model;
use Acme\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database extends Model
{
    public $table = "users";
    protected $fillable = ['NAME'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->initDb();
    }

    protected function initDb()
    {
        $capsule = new Capsule;
        $capsule->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'dz8', 'username' => 'root', 'password' => '', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci', 'prefix' => '']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
    public function getAllOrders()
    {
        return self::all();
    }

    public function getOneOrder($orderId)
    {
        return $this->where('ORDER_ID',$orderId)->first();
    }

    public function createOrder($name)
    {
        return self::forceCreate(['NAME' => $name]);
    }

    public function modifyOrder($id, $name)
    {
        $order = $this->where('ORDER_ID', $id)->first();

        if ($order !== null) {


            return $this->where('ORDER_ID', $id)->update(['NAME' => $name]);
        }
    }

    public function deleteOrder($id)
    {
        $delete = $this->where('ORDER_ID', $id)->first();

        if($delete !== null){
            return $this->where('ORDER_ID', $id)->delete();
        }
    }
}