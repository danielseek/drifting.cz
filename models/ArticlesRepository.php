<?php
namespace Natty\Repositories;
use Nette;
/**
 * Description of MenuModel
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
class ArticlesRepository extends MultilingualRepository  {
    public function __construct(\Nette\Database\Connection $db){
	$table = "articles";
	$translationsTable = "articletranslations";
	parent::__construct($db, $table,$translationsTable);
    }
    /**
     * 
     * @param array $values Asociative array of values to be inserted. 
     *	    Demanded keys: lang, user_id, headline, perex. 
     *	    Accepted keys: lang, headline, perex, text, user_id, image_url
     * @return \Natty\Repositories\ArticlesRepository
     */
    public function create(Array $values){
	$demandedKeys = "lang, user_id, headline, perex";
	
	$this->checkDemandedKeys($values, $demandedKeys);
	$this->getTable()->insert(
	    $this->filterArray($values, "user_id, image_url")
	);
	$translation = $this->filterArray($values, "lang, headline, perex, text");
	$translation["article_id"] = $this->db->lastInsertId();
	$this->db->table("articletranslations")->insert($translation);

	return $this;
    }
    public function addTranslation($lang,$articleId, $lang, $headline){
	
	return $this;
    }
    public function update($id,Array $values){
        $this->getTable()->get($id)->update(Array(
            "headline" =>$headline,
            "perex" => $introduction,
            "text" => $text,
            "user_id" => $userId
        ));
    }
}