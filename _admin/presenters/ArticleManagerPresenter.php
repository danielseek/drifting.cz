<?php
/*
 * This file is part of the Natty CMS (http://nattycms.org), based on the Nette Framework (http://nette.org)
 *  Copyright (c) 2013 Daniel Sýkora (http://danielsykora.com)
 */
namespace AdminModule;
use Natty;
use Nette\Application\UI\Form;
use Natty\ArticlesComponent;
use Natty\AdminFramework\Fields\Field;
/**
 * @author Daniel Sýkora
 */
class ArticleManagerPresenter extends Natty\Manager {
    /** @var \Natty\Repositories\ArticlesRepository */
    protected $repository;
    public $menuId = 10;
    protected $headline = Array(
	"edit" => "Úprava článku",
	"add" => "Přidání nového článku",
	"default" => "Správa článků"
    );
    
    public function startup() {
        parent::startup();
	$this->repository = $this->context->articlesRepository;
    }
    public function createComponentAdmin($name){
	$admin = new \Natty\AdminFramework\Admin($this, $name);
	
	$admin//->setOnFormSubmitted(callback($this, 'formSubmitted'))
	    ->setRepository($this->repository)
	    ->setPrimaryKey("id");
	$admin->addField("user_id", "Autor", Field::TYPE_HIDDEN)
		->setValue($this->user->id);
	
	$admin->setMultilingualMode()
		->setLanguages($this->languages)
		->setDefaultLanguage($this->defaultLanguage);

		
	$admin->addField("headline","Nadpis", Field::TYPE_TEXT)
		->setMandatory(true)
		->setMaxlength(200)
		->setMultilingual();
	$admin->addField("perex","Úvod", Field::TYPE_TEXTAREA)
		->setUseEditor(true)
		->setMultilingual();;
		
	$admin->addField("text", "Text článku", Field::TYPE_TEXTAREA)
		->setUseEditor(true)
		->setMultilingual();;
	return $admin;
    }
    public function formSubmitted($form,$preparedValues){
        $vals = $form->form->getValues();
	if(!$vals->id) {
	    $this->articlesRepository->createArticle($vals->headline,$vals->perex,$vals->text, $this->user->id);
	    $this->flashMessage('Článek přidán.', 'success');
	    $this->redirect("Default");	    
	} else {
	    $this->articlesRepository->updateArticle($vals->id, $vals->headline,$vals->perex,$vals->text, $this->user->id);
	    $this->flashMessage('Článek byl upraven.', 'success');
	    $this->redirect("Default");
	}
    }
    protected function prepareDefaultsEdit($article){
	return Array(
	    "id" =>  $article->id,
	    "headline" =>  $article->headline,
	    "perex" =>  $article->perex,
	    "text" =>  $article->text
	);
    }
    /*
    public function actionEdit($id){

	$item = $this->articlesRepository->getOne($id);
	$defaults = $this->prepareDefaultsEdit($item);
	$this['articleForm']->setDefaults($defaults);
    }*/
    //Add
    /*
    protected function createComponentArticleForm($name){
        $msg = "Nevyplnili jste povinné pole ";
        $form = new Form;
	$form->addHidden("id");
        $form->addText("headline", "Nadpis")
		->addRule(Form::FILLED, $msg."'Nadpis'.")
                ->addRule(Form::MAX_LENGTH,"Nadpis nesmí být delší než 200 znaků.", 200);
        $form->addTextArea("perex", "Úvod")->setAttribute('class', "ckeditor");
        $form->addTextArea("text", "Text článku")->setAttribute('class', "ckeditor");
        $form->addSubmit("send", "Potvrdit");
	$form->onSuccess[] = callback($this, "formSubmitted");
	
        return new \Natty\FormRenderer($form, $this, $name);  
    }*/

    //Edit

    //Delete
    /*
    public function actionDelete($id){
	$this->articlesRepository->delete($id);
	$this->redirect("Default");
    }
    //Delete
    protected function createComponentArticles($name){
	$articles = new ArticlesComponent($this->articlesRepository, $this,$name);
	$articles->isAdmin = true;
	return $articles;
    }*/

}
?>
