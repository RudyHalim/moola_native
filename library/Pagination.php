<?php
class Pagination {

	public $itemPerPage = 10;
	public $maxShowingPaging = 5;
	public $page = 1;

	public $totalRows;
	public $minPage;
	public $maxPage;

	public function generateLimitQuery() {
		return ($this->page-1)*$this->itemPerPage.", ".$this->itemPerPage;
	}

	public function calculate() {
		$this->minPage = 1;
		$this->maxPage = ceil($this->totalRows / $this->itemPerPage);
	}

}