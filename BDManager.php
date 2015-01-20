<?php

/**
* Otherwise Studios BDManager
* by Juan Camilo Guarin Peñaranda
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

	public function search($query, $encodeutf8=true){

		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);

		$resultado = $mysqli->query($query);
		$resultados = array();

		//var_dump($resultado);

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
	

	public function searchOmitted($busqueda,$columnasomitidas,$encodeutf8=true){

		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);

		$resultado = $mysqli->query($busqueda);

		$resultados = array();

		//$todos = $resultado->fetch_all();
		$todos=array();
		while($row=$resultado->fetch_array()){
			$todos[]=$row;
		}
		

		$num = $resultado->num_rows;

		$fields=array();
		$colsomit = array();

		$i=0;
		while ($property = $resultado->fetch_field()) {
			if(in_array($property->name, $columnasomitidas)){
				$colsomit[]=$i;
			}
			$fields[]= $property->name;
			$i++;
		}

		for($i=0; $i<$num; $i++){
			$resultado2=array();
			for($j=0; $j<count($fields);$j++){
				if(!in_array($j, $colsomit)){
					if($encodeutf8){
						$resultado2[$fields[$j]]=utf8_encode($todos[$i][$j]);
					}else{
						$resultado2[$fields[$j]]=($todos[$i][$j]);
					}
				}
			}
			$resultados[]=$resultado2;
		}

		$resultado->free();

		$mysqli->close();

		return $resultados;
	}

	public function insert($query){
		$bool = $this->update($query);
		return $bool;
	}

	public function delete($query){
		$bool = $this->update($query);
		return $bool;

	}

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

	public function escapeString($string){
		$mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);
		$string = $mysqli->real_escape_string($string);
		$mysqli->close();
		return $string;
	}
}