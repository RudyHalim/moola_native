<?php
class Query {

	private $mysqli;
	public $fields;
	public $data;
	public $condition;
	public $orderby;
	public $limit;
	public $select;
	public $insert;
	public $update;
	public $delete;

	public $flash_msg;

	public function __construct() {
		global $mysqli;

		$this->mysqli 		= $mysqli;
		$this->fields 		= "*";
		$this->data 		= new StdClass;
		$this->condition 	= new StdClass;
		$this->limit 		= 0;
	}

	public function execute() {
		$sql = $this->getQuery();
		$result = mysqli_query($this->mysqli, $sql);

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
			$sql .= "DELETE ".$this->delete;
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
		if(!empty($this->condition)) {
			$sql .= " WHERE 1=1";
			foreach ($this->condition as $column => $value) {
				$sql .= " AND ".$column." = '".$value."'";
			}
		}

		// order by
		if(!empty($this->orderby)) {
			$sql .= " ORDER BY ".$this->orderby;
		}

		// limit
		if($this->limit > 0) {
			$sql .= " LIMIT ".$this->limit;
		}

		return $sql;
	}
}
