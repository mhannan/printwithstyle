<?php
class cls_coupons {
	private $table = "coupon_codes";
	private $data = array();
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		} else {
			return NULL;
		}
	}
	
	public function get_all() {
		$sql = "SELECT {$this->table}.* FROM {$this->table} ORDER BY {$this->table}.use_date DESC";
		
		$table = mysql_query( $sql ) or die ( "get all codes</br>$sql" . mysql_error() );
		if ( mysql_num_rows( $table ) ) {
			return $table;
		} else {
			return FALSE;
		}
	}
	
	public function insert() {
		$sql = "INSERT INTO {$this->table} SET " . $this->column_values();
		if ( mysql_unbuffered_query($sql) or die ("Insert Coupon<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update() {
		$sql = "UPDATE {$this->table} SET " . $this->column_values() . " WHERE id = " . $this->id;
		if ( mysql_unbuffered_query($sql) or die ("Update Coupon<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function delete() {
		$sql = "DELETE FROM {$this->table} WHERE " . $this->column_values();
		if ( mysql_unbuffered_query($sql) or die ("Delete Coupon<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		} 
	}
	
	private function column_values() {
		$col_val = array();
		foreach( $this->data as $column => $value ) {
			$value = mysql_real_escape_string($value); 
			if ( is_numeric($column) === FALSE && is_integer($column) === FALSE ) {
				if ( $value == 'NOW()' || is_numeric( $value ) || is_integer( $value ) ) {
					$col_val[] = "{$column} = {$value}";
				} else {
					$col_val[] = "{$column} = '{$value}'";
				}
			}
		}
		return (string)implode( ', ', $col_val );
	}
	
	public function set_code() {
		$sql = "SELECT * FROM {$this->table} WHERE " . $this->column_values();
		$table = mysql_query($sql) or die ("set code <br/>$sql</br>" . mysql_error() );
		if ( mysql_num_rows($table) ) {
			$this->data = mysql_fetch_array($table);
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
/* create a class object to be used in the files */
$objCoupon = new cls_coupons();
