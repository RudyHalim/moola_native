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
		$this->table->countries->trackingUpdated = false;

		$this->table->roles = new StdClass;
		$this->table->roles->name = "roles";
		$this->table->roles->primary = "role_id";
		$this->table->roles->unique = [];
		$this->table->roles->trackingUpdated = false;

		$this->table->configs = new StdClass;
		$this->table->configs->name = "configs";
		$this->table->configs->primary = "config_id";
		$this->table->configs->unique = [];
		$this->table->configs->trackingUpdated = false;

		$this->table->order_status = new StdClass;
		$this->table->order_status->name = "order_status";
		$this->table->order_status->primary = "orderstatus_id";
		$this->table->order_status->unique = [];
		$this->table->order_status->trackingUpdated = false;

		$this->table->pages = new StdClass;
		$this->table->pages->name = "pages";
		$this->table->pages->primary = "page_id";
		$this->table->pages->unique = [];
		$this->table->pages->trackingUpdated = true; 	// 'created_dt', 'created_by', 'updated_dt', 'updated_by'

		$this->table->users = new StdClass;
		$this->table->users->name = "users";
		$this->table->users->primary = "user_id";
		$this->table->users->unique = ["email_addr"];
		$this->table->users->trackingUpdated = false;

		$this->table->products = new StdClass;
		$this->table->products->name = "products";
		$this->table->products->primary = "product_id";
		$this->table->products->unique = [];
		$this->table->products->trackingUpdated = true; 	// 'created_dt', 'created_by', 'updated_dt', 'updated_by'
	}

}