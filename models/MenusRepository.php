<?php
namespace Natty\Repositories;
use Nette;
/**
 * Description of MenuModel
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
class MenusRepository extends Repository  {
    public function __construct(\Nette\Database\Connection $db){
	$table = "menus";
	parent::__construct($db, $table);
    }    
}

?>
