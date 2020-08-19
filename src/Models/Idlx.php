<?php
namespace Models;

use DB2Eloquent\Model;

class Idlx extends Model {

	const TABLE = 'idlx_3min';

	protected $table = self::TABLE;
	public $timestamps = false;

	public static function checkIfQueryExists($query) {
		return self::where(
			'query_hash',
			md5($query->item(QUERY)->nodeValue)
		)
			->exists();
	}
}