<?php

/*
 * This file is part of Natty CMS based on Nette (http://nattycms.org)
 *  Copyright (c) 2013 Daniel Sýkora (http://danielsykora.com)
 */
namespace Natty\Repositories;
/**
 * Description of MultilingualRepository
 *
 * @author Daniel Sýkora #<jsem@danielsykora.com>
 */
class MultilingualRepository extends Repository {
    
    /** @var Nette\Database\Table\Selection Description */
    protected $translations;
    public function __construct(\Nette\Database\Connection $db, $table, $translationsTable){
	$this->translations = New Repository($db, $translationsTable);
	parent::__construct($db, $table);
    }
    public function getAllMultilingual(Array $multilingualColumns){
	$selection =  $this->translations->getAll();
	return $selection->select('articletranslations.*, articles.*')->where(array("lang"=>"cs"));
	$selectString = $this->table.".*";
	foreach($multilingualColumns as $column){
	    $selectString .= ", ".$this->translations->getTableName().".".$column." as ".$column;
	}
	flog($selectString);

    }
}

