<?php


namespace Commands;


use Carbon\Carbon;
use HtmlParser\HtmlParser;

class SecondCommand extends Command {

	private $date = null;

	public function __construct($date) {
		$this->date = $date
			? Carbon::createFromFormat('d-m', $date)
			: null;
	}

	public function handle() {
		foreach($this->getFilesByMask(0) as $file) {
			$this->outMessage($file);
		}
		foreach($this->getFilesByMask(1) as $file) {
			$this->outMessage($file);
		}
	}
	private function outMessage($file) {
		$queries = $this->getQueries($file);
		foreach ($queries as $query) {
			$queryTime = $query->item(QUERY_START)->nodeValue;
			if (
				$this->date
				&& (
					Carbon::parse($queryTime)->format('d')
					== $this->date->format('d')
				)
			) {
				$this->sendMessage($query, $queryTime);
			} else if (
				Carbon::parse($queryTime)->isToday()
				&& !$this->date
			) {
				$this->sendMessage($query, $queryTime);
			}
		}
	}

	private function removeOneHour($time) {
		return Carbon::parse($time)
			->addMinutes(-50)
			->format('d-m H:i:s');
	}

	private function sendMessage(\DOMNodeList $query, $queryTime) {
		echo 'Прошу предоставить логи запросов по pid '
			. $query->item(PID)->nodeValue . ' с '
			. $this->removeOneHour($queryTime)
			. ' по '. Carbon::parse($queryTime)->format('d-m H:i:s')
			. "\n";
	}
}