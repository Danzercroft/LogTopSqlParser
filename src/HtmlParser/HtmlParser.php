<?php
namespace HtmlParser;

class HtmlParser {

	protected $dom;

	public function __construct($file) {
		$this->dom = new \DOMDocument();
		$this->dom->loadHTMLFile($file);
	}

	private function getTables() {
		return $this->dom->getElementsByTagName('table');
	}

	private function getRows() {
		$rows = [];
		foreach($this->getTables() as $table) {
			$rows[] = $this->getTrs($table);
		}
		return $rows;
	}

	private function getTrs(\DOMElement $table) {
		return $table->getElementsByTagName('tr');
	}

	private function getTds(\DOMElement $table) {
		return $table->getElementsByTagName('td');
	}

	public function getQueriesInfo() {
		$queriesInfo = [];
		foreach($this->getRows() as $rows) {
			foreach($rows as $row) {
				$td = $row->getElementsByTagName('td');
				if ($td->length) {
					$queriesInfo [] = $td;
				}
			}
		}
		return $queriesInfo;
	}
}