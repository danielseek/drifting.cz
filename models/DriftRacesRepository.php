<?php
namespace Natty\Repositories;
use Nette;
/**
 * Description of MenuModel
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
class DriftRacesRepository extends Repository  {
    public function __construct(\Nette\Database\Connection $db){
	$table = "drift_races";
	parent::__construct($db, $table);
    }
    public function createRace($name, $track, $location, $isCurrent, $status = null){
        $this->getTable()->insert(Array(
	    "name" =>$name,
            "track" =>$track,
            "location" => $location,
            "is_current" => $isCurrent,
            "status" => $status
        ));
    }
    public function updateRace($id ,$track, $location, $isCurrent, $status = null){
        $this->getTable()->get($id)->update(Array(
	    "name" =>$name,
            "track" =>$track,
            "location" => $location,
            "is_current" => $isCurrent,
            "status" => $status
        ));
    }
}