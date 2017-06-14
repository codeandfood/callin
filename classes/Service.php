<?php

// namespace src\classes;

/**
* 
*/
class Service
{
	
	public $db = null;
	function __construct($cont)
	{
		$this->db = $cont->db;
	}

	function getServices(){
		try{
			$stmt = $this->db->prepare("SELECT service_id, service_name FROM service");
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		catch(Exception $e){
			var_dump($e->getMessage());
		}
	}

	function getCities(){
		try{
			$stmt = $this->db->prepare("SELECT city_id, city_name FROM city");
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		catch(Exception $e){
			var_dump($e->getMessage());
		}
	}

	function getAreas(){
		try{
			$stmt = $this->db->prepare("SELECT area_id, area_name FROM area");
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		catch(Exception $e){
			var_dump($e->getMessage());
		}
	}
	function getAreasWithCity($cityid){
		try{
			$stmt = $this->db->prepare("SELECT area_id, area_name FROM area where city_id = ?");
			$stmt->execute(array($cityid));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		catch(Exception $e){
			var_dump($e->getMessage());
		}
	}
	function getMobileNumbers(){
		try{
			$stmt = $this->db->prepare("SELECT mobile_no.mobile_no, service.service_name, area.area_name, city.city_name FROM mobile_no join area_service on area_service.area_service_id = mobile_no.area_service_id join service on area_service.service_id = service.service_id join area on area_service.area_id=area.area_id join city on city.city_id=area.city_id");
			$stmt->execute(array($cityid));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		catch(Exception $e){
			var_dump($e->getMessage());
		}
	}
}