<?php
namespace Commands;

use Carbon\Carbon;
use GoogleApi\GoogleApi;
use HtmlParser\HtmlParser;
use Models\Idlx;
use Models\SlowQuery;

class FirstCommand extends Command {

	public function handle() {
		foreach($this->getFilesByMask(0) as $file) {
			$this->saveQueries3Min($file);
		}
		foreach($this->getFilesByMask(1) as $file) {
			$this->saveQueries10Min($file);
		}
	}

	protected function saveQueries3Min($file) {
		$queries = $this->getQueries($file);

		foreach($queries as $query) {
			if (
				!Idlx::checkIfQueryExists($query)
			) {
				(new GoogleApi())
					->insertQuery($query, 0);
			}
			(new Idlx())
				->setDate(
					(new Carbon($query->item(QUERY_START)->nodeValue))
						->format('Y-m-d')
				)
				->setQuery(
					$query->item(QUERY)->nodeValue
				)
				->setPid(
					$query->item(PID)->nodeValue
				)
				->setTime(
					(new Carbon($query->item(QUERY_START)->nodeValue))
						->format('H:i:s')
				)
				->setSended(0)
				->setDuration(
					$this->getDuration($query->item(DURATION)->nodeValue)
				)
				->setUser($query->item(USENAME)->nodeValue)
				->setQueryHash(md5($query->item(QUERY)->nodeValue))
				->save();
		}
	}

	protected function saveQueries10Min($file) {
		$htmlParser = new HtmlParser($file);
		$queries = $htmlParser
			->getQueriesInfo();

		foreach($queries as $query) {
			if (
				!SlowQuery::checkIfQueryExists($query)
			) {
				(new GoogleApi())
					->insertQuery($query, 1);
			}
			(new SlowQuery())
				->setDate(
					(new Carbon($query->item(QUERY_START)->nodeValue))
						->format('Y-m-d')
				)
				->setQuery(
					$query->item(QUERY)->nodeValue
				)
				->setPid(
					$query->item(PID)->nodeValue
				)
				->setTime(
					(new Carbon($query->item(QUERY_START)->nodeValue))
						->format('H:i:s')
				)
				->setSended(0)
				->setDuration(
					$this->getDuration($query->item(DURATION)->nodeValue)
				)
				->setUser($query->item(USENAME)->nodeValue)
				->setQueryHash(md5($query->item(QUERY)->nodeValue))
				->save();
		}
	}


}