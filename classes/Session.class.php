<?php

/*
	Revised code by Dominick Lee
	Original code derived from "Essential PHP Security" by Chriss Shiflett
	Last Modified 2/27/2017
	CREATE TABLE sessions
	(
		id varchar(32) NOT NULL,
		access int(10) unsigned,
		data text,
		PRIMARY KEY (id)
	);
	+--------+------------------+------+-----+---------+-------+
	| Field  | Type             | Null | Key | Default | Extra |
	+--------+------------------+------+-----+---------+-------+
	| id     | varchar(32)      |      | PRI |         |       |
	| access | int(10) unsigned | YES  |     | NULL    |       |
	| data   | text             | YES  |     | NULL    |       |
	+--------+------------------+------+-----+---------+-------+
	*/


class Session
{

	// Define database connection variable
	private $conn;

	public function __construct($db)
	{
		// Database connection
		$this->conn = $db;

		// Set handler to overide SESSION
		session_set_save_handler(
			array($this, "_open"),
			array($this, "_close"),
			array($this, "_read"),
			array($this, "_write"),
			array($this, "_destroy"),
			array($this, "_gc")
		);

		// Start the session
		session_start();

		// Delete unused rows
		$this->_gc(10);
	}
	public function _open()
	{
		// If successful
		if ($this->conn) {
			// Return True
			return true;
		}
		// Return False
		return false;
	}
	public function _close()
	{
		return true;
	}
	public function _read($id)
	{
		// Set query
		$sql = "SELECT data FROM sessions WHERE id =?";
		$stmt = $this->conn->prepare($sql);
		// Attempt execution
		$stmt->execute([$id]);
		//Return row as an array
		$returned_row = $stmt->fetch();
		//Check if row is actually returned
		if (is_array($returned_row)) {
			// Return the data
			return $returned_row['data'];
		}
		// Return an empty string
		return '';
	}
	public function _write($id, $data)
	{
		// Create time stamp
		$access = time();
		// Set query  
		$sql = "REPLACE INTO sessions VALUES (?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		if ($stmt->execute([$id, $access, $data])) {
			// Return True
			return true;
		}
		// Return False
		return false;
	}
	public function _destroy($id)
	{
		// Set query
		$sql = "DELETE FROM sessions WHERE id=?";
		$stmt = $this->conn->prepare($sql);
		// Attempt execution
		if ($stmt->execute([$id])) {
			// Return True
			return true;
		}
		// Return False
		return false;
	}
	public function _gc($max)
	{
		// Calculate what is to be deemed old
		$old = time() - $max;
		// Set query
		$sql = "DELETE FROM sessions WHERE (access < ? AND data = '')";
		$stmt = $this->conn->prepare($sql);
		// Attempt execution
		if ($stmt->execute([$old])) {
			// Return True
			return true;
		}
		// Return False
		return false;
	}
}
