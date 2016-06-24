<?php
class Query {

	private $mysqli;
	private $config;
	public $fields;
	public $data;
	public $condition;
	public $orderby;
	public $limit;
	public $select;
	public $insert;
	public $update;
	public $delete;
	public $result;

	public $flash_msg;

	public function __construct() {
		global $mysqli;
		global $config;

		$this->mysqli 		= $mysqli;
		$this->config 		= $config;
		$this->fields 		= "*";
		$this->data 		= new StdClass;
		$this->condition 	= new StdClass;
		$this->limit 		= 0;
	}

	public function execute() {
		$sql = $this->getQuery();
		$result = mysqli_query($this->mysqli, $sql);
		$this->result = $result;

		if($result) {
			$this->flash_msg = "Your query has been successfully executed.";

			if(isset($this->select)) {
				$return = array();
			    while($obj = $result->fetch_object()) {
			    	$return[] = (array)$obj;
				}
				return $return;
			}

			return 1;
		} else {
			$this->flash_msg = mysqli_error($this->mysqli);
			return 0;
		}
	}

	public function getQuery() {
		$sql = "";

		// pre
		if(isset($this->select)) {
			$sql .= "SELECT ".$this->fields." FROM ".$this->select;
		} else if(isset($this->insert)) {
			$sql .= "INSERT INTO ".$this->insert;
		} else if(isset($this->update)) {
			$sql .= "UPDATE ".$this->update;
		} else if(isset($this->delete)) {
			$sql .= "DELETE FROM ".$this->delete;
		}

		// mid
		if(isset($this->insert) || isset($this->update)) {
			if(!empty($this->data)) {

				$sql .= " SET ";
				foreach ($this->data as $column => $value) {
					$sql .= $column." = '".$value."', ";
				}
				$sql = rtrim($sql, ", ");
			}
		}

		// cond
		if(count((array)$this->condition) != 0) {
			$sql .= " WHERE 1=1";
			foreach ($this->condition as $column => $value) {
				if(strpos($value, '%') !== false)
					$sql .= " AND ".$column." LIKE '".$value."'";
				else
					$sql .= " AND ".$column." = '".$value."'";
			}
		}

		// order by
		if(!empty($this->orderby)) {
			$sql .= " ORDER BY ".$this->orderby;
		}

		// limit
		if($this->limit) {
			$sql .= " LIMIT ".$this->limit;
		}

		return $sql;
	}

	public function getColumns($tablename) {

		$sql = "SELECT `COLUMN_NAME`, `COLUMN_TYPE`, `COLUMN_KEY`
				FROM `INFORMATION_SCHEMA`.`COLUMNS` 
				WHERE `TABLE_SCHEMA`='".$this->config['database']['dbname']."' 
				    AND `TABLE_NAME`='".$tablename."'
				";
		$result = mysqli_query($this->mysqli, $sql);

		if($result) {
			$return = array();
		    while($obj = $result->fetch_object()) {
		    	$return[] = (array)$obj;
			}
			return $return;
		}
		return 0;
	}

	public function getTotalRows() {
		return $this->result->num_rows;
	}
}
