<?php
namespace Models;

use DB2Eloquent\Model;

class SlowQuery extends Model {

	const TABLE = 'slow_query';

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