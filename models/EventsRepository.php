<?php
namespace Natty\Repositories;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersRepository
 *
 * @author Daniel
 */
class EventsRepository extends Repository{
    public function __construct(\Nette\Database\Connection $db){
	$table = "events";
	parent::__construct($db, $table);
    }
    public function createEvent($name, $dateFrom,$timeFrom, $dateTo, $timeTo, $location, $description, $userId){
        $this->getTable()->insert(Array(
	    "name" =>$name,
            "date_start" => $dateFrom,
	    "time_start" => $timeFrom,
	    "date_end" => $dateTo,
	    "time_end" => $timeTo,
	    "location" => $location,
	    "description"=>$description,
            "user_id" => $userId
        ));
    }
    public function updateEvent($id ,$name, $dateFrom,$timeFrom , $dateTo, $timeTo, $location, $description, $userId){
	$data = Array(
	    "name" =>$name,
            "date_start" => $dateFrom,
	    "time_start" => $timeFrom,
	    "date_end" => $dateTo,
	    "time_end" => $timeTo,
	    "location" => $location,
	    "description"=>$description,
            "user_id" => $userId
	);
	$this->db->query("UPDATE events SET ? WHERE id = ?",$data,$id);

    }
}