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

		$this->table->roles = new StdClass;
		$this->table->roles->name = "roles";
		$this->table->roles->primary = "role_id";
		$this->table->roles->unique = [];

		$this->table->configs = new StdClass;
		$this->table->configs->name = "configs";
		$this->table->configs->primary = "config_id";
		$this->table->configs->unique = [];

		$this->table->order_status = new StdClass;
		$this->table->order_status->name = "order_status";
		$this->table->order_status->primary = "orderstatus_id";
		$this->table->order_status->unique = [];
	}

}