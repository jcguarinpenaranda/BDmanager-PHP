<?php

/**
* Otherwise Studios BDManager
* @autor Juan Camilo Guarin Peñaranda
*/

class BDManager
{
	private $host;
	private $user;
	private $pass;
	private $db;

	function __construct($h,$u,$p,$db)
	{
		$this->host=$h;
		$this->user=$u;
		$this->pass=$p;
		$this->db=$db;
	}

	/*
	The query function lets you make MySQL queries in a normal way
	@param $query Your query
	@param $encodeutf8 Wether the result has to be encoded in UTF-8 or not
	*/
	public function query($query, $encodeutf8=false){

		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);

		$resultado = $mysqli->query($query);
		$resultados = array();

		$todos=array();
		while($row=$resultado->fetch_array()){
			$todos[]=$row;
		}

		$num = $resultado->num_rows;

		$fields=array();

		while ($property = $resultado->fetch_field()) {
			$fields[]= $property->name;
		}

		for($i=0; $i<$num; $i++){
			$resultado2=array();
			for($j=0; $j<count($fields);$j++){
				if($encodeutf8){
					$resultado2[$fields[$j]]=utf8_encode($todos[$i][$j]);
				}else{
					$resultado2[$fields[$j]]=($todos[$i][$j]);
				}
			}
			$resultados[]=$resultado2;
		}

		$resultado->free();

		$mysqli->close();

		return $resultados;
	}

	/*
	The insert function is just to be semantic
	@param $query The query you want to make
	*/
	public function insert($query){
		$bool = $this->update($query);
		return $bool;
	}

	/*
	The delete function is just to be semantic
	@param $query The query you want to make
	*/
	public function delete($query){
		$bool = $this->update($query);
		return $bool;

	}

	/*
	The update function makes an update to the database. Calling this function
	you are able to make Inserts, deletes and updates
	@param $query The query you want to make
	*/
	public function update($query){
		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Error de conexión: %s\n", mysqli_connect_error());
			exit();
		}

		$booleano = $mysqli->query($query);

		/* close connection */
		$mysqli->close();

		return $booleano;
	}


	/*
	The escapeString function is just to be semantic
	@param $string The string you want to escape
	*/
	public function escapeString($string){
		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);
		$string = $mysqli->real_escape_string($string);
		$mysqli->close();
		return $string;
	}
}
