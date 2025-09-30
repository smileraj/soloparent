<?php

	// mini framework fortement inspir� du framework joomla
	class DB {

		public $connexion_id	= null; // connexion mysql
		public $ressource		= null;	// id du r�sultat d'une requ�te

		function DB() {
			$this->connexion_id	= null;
			$this->ressource	= null;
			$this->connect();
		}

		function connect() {

			@$this->connexion_id = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

			if(!$this->connexion_id) {
				@$this->connexion_id = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

				if(!$this->connexion_id) {die();}
			}

			@mysqli_select_db(DB_DATABASE);
			//mysql_query("SET NAMES 'utf8'", $this->connexion_id);
		}

		function disconnect() {
			mysqli_close($this->connexion_id);
		}

		function getConnexion() {
			return $this->connexion_id ? true : false;
		}

		function setQuery($query) {
			$this->ressource = mysqli_query(@$this->connexion_id, $query);
			if(!$this->ressource) {
				//echo '<div style="border:solid 2px red;padding:10px;background:#fff;margin:10px;color:#000;"><span style="color:#f00;font-weight:bold;">'.mysql_error($this->connexion_id).'</span><br /><br />'.$query.'</div>';
				return false;
			} else {
				return true;
			}
		}

		function query($query) {
			$this->ressource = mysqli_query(@$this->connexion_id, $query);
		}

		function insert_id() {
			return mysqli_insert_id();
		}

		function affected_rows() {
			return mysqli_affected_rows();
		}

		function loadResult($query = '') {
			if($query) {
				$this->setQuery($query);
			}
			if($data = mysqli_fetch_array($this->ressource)) {
				return $data[0];
			} else {
				return null;
			}
		}

		function loadObjectList($query = '') {
			if($query) {
				$this->setQuery($query);
			}
			if($data = mysqli_fetch_array($this->ressource)) {
				return $data;
			} else {
				return [];
			}
		}

		function loadObject($query = '') {
			if($query) {
				$this->setQuery($query);
			}
			if($data = @mysqli_fetch_object($this->ressource)) {
				return $data;
			} else {
				return null;
			}
		}

		function loadArrayList($query = '') {
			if($query) {
				$this->setQuery($query);
			}
			$datas	= [];
			while($data = mysqli_fetch_array($this->ressource)) {
				$datas[]	= $data;
			}
			return $datas;
		}

		function loadObjectList($query = '') {
			if($query) {
				$this->setQuery($query);
			}
			$datas	= [];

			while(@$data = mysqli_fetch_object($this->ressource)) {
				$datas[]	= $data;
			}
			return $datas;
		}

		function escape($string) {
			return mysqli_real_escape_string($string, (string) $this->connexion_id);
		}
	}
?>