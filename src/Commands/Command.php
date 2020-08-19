<?php


namespace Commands;


use HtmlParser\HtmlParser;

abstract class Command {

	abstract public function handle();

	protected function getDuration($string){
		list($hours, $minutes, $seconds) = explode(':', $string);
		list($seconds, $milliseconds) = explode('.', $seconds);
		return (($hours * 60 + $minutes) * 60 + $seconds) * 1000 + $milliseconds;
	}

	protected function getFilesByMask($type = 0){
		$mask = PATH_TO_LOG_FILES . '*3 min*';
		if ($type === 1) {
			$mask = PATH_TO_LOG_FILES . '*10 min*';
		}
		return glob($mask);
	}

	protected function getQueries($file) {
		return (new HtmlParser($file))
			->getQueriesInfo();
	}

}