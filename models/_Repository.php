<?php
namespace Natty\Repositories;
use Nette;

/**
 * This file is part of Natty CMS
 * @author Daniel Sykora (jsem@dsykora.cz)
 */

/* Ancestor of all models in app
 * Provides functionality to perform all basic CRUD interactions
 * 
 */

class Repository {
    const EXCEPTION_MISSING_VALUE = 1;
    /**
     *
     * @var Nette\Database\Connection 
     */
    protected $db = NULL;
    
    /**
     * Prefix for all tables in db
     * @var String
     */
    protected $prefix; //= "natty_";
    
    /**
     * Table name either to be overriden by child or set in constructor  
     * @var String
     */
    protected $table;
    
    public function __construct(\Nette\Database\Connection $db, $table = null) {

	$this->db = $db;

	if ($table) {

	    $this->table = $table;
	}
    }
    protected function checkDemandedKeys($keys,$demanded){
	$keys = array_keys($keys);
	if(is_string($demanded)) $demanded = explode (", ", $demanded);
	foreach ($demanded as $demandedKey){
	    if(!in_array($demandedKey, $keys)) throw new \ModelException("One of the demanded keys is not present:".$demandedKey,  
			Repository::EXCEPTION_MISSING_VALUE);
	}
	return true;
    }

    protected function filterArray($array, $allowedKeys) {
	if(is_string($allowedKeys)) $allowedKeys = explode (", ", $allowedKeys);
	return array_intersect_key($array, array_flip($allowedKeys));
    }
    /**
     * return all rows from the table
     * @return Nette\Database\Table\Selection
     */
    public function getAll()
    {
        return $this->getSelection();
	
    }
    public function getOne($id){
	return $this->getSelection()->where("id", $id)->fetch();
    }
    /**
     * Returns rows according to filter, e.g. array('name' => 'John').
     * @return Nette\Database\Table\Selection
     */
    public function getBy(array $by)
    {
        return $this->getSelection()->where($by);
    }
    public function delete($id){
	return $this->getSelection()->where("id", $id)->fetch()->delete();
    }

    /**
     * Return object that represents database table 
     * @return Nette\Database\Table\Selection
     */
    protected function getSelection(){
	if($this->table) {
	    return $this->db->table($this->prefix.$this->table);
	} else throw new \MissingValueException ("Table name is not set in the model ".get_class ($this));
    }

    /**
     * Set table
     * @param String $tableName 
     */
    public function setTable($tableName){
	$this->table = $tableName;
    }
    public function getTableName(){
	return $this->table;
    }
    public function setPrefix($prefix){
	$this->prefix = $prefix;
    }
}
