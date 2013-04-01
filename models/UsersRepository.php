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
class UsersRepository extends Repository{
    public function __construct(\Nette\Database\Connection $db){
	$table = "users";
	parent::__construct($db, $table);
    }    
}