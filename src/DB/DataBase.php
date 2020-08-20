<?php
namespace DB;
use Illuminate\Database\Capsule\Manager as Capsule;

class DataBase {
	public function __construct() {
		$this->capsule = new Capsule;
		$this->capsule->addConnection(
			DB_CONNECTION,
			'default');
		$this->capsule->bootEloquent();
		$this->capsule->setAsGlobal();
		$this->connection = $this->capsule->getConnection('default');
	}
}