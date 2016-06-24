<?php
class Model {
	
	public $table;

	public function __construct() {

		$this->table = new StdClass;
		$this->getList();
		
	}

	public function getList() {
		$this->table->countries = new StdClass;
		$this->table->countries->name = "countries";
		$this->table->countries->primary = "country_id";
		$this->table->countries->unique = ["country_name", "country_currency"];
	}

}