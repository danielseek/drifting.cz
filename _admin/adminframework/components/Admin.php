<?php
/*
 * This file is part of the Natty CMS (http://nattycms.org), based on the Nette Framework (http://nette.org)
 *  Copyright (c) 2013 Daniel Sýkora (http://danielsykora.com)
 */
namespace Natty\AdminFramework;
use Natty, Nette\Application\UI\Form;
/**
 * @author Daniel Sýkora
 */
class Admin extends \Nette\Application\UI\Control {
    /** @var Repositories\Repository Model */
    protected $repository;
    protected $multilingualMode = false;
    protected $multilingualFieldNames = Array();
    protected $translationsTable;
    protected $primaryKey;
    /** @var \Nette\Callback */
    protected $onFormSubmitted;


    /** @var String Following variables are used by sprintf function to produce form  message */
    protected $messageMandatory = "Nevyplnili jste povinné pole '%s'.";
    protected $messageMaxLength = "Pole '%s' nesmí být delší než %d znaků.";
    /////////////////////////////////////////////// RENDER
    public function render() {
	
    }
    /////////////////////////////////////////////// Components
    protected function createComponentDataGrid($name){
	$grido = new \Grido\Grid($this, $name);
	$model = $this->repository->getAllMultilingual($this->multilingualFieldNames);
	$f = $model->fetch();
	flog($f->headline);
	$grido->setModel($model);
	$fields = $this->getFields();
	foreach($fields as $field) {
	    if($field->useInGrid()) {
		$column = $grido->addColumn($field->getName(), $field->getLabel(), $field->getGridType());
		//if($field->isMultilingual()) $column->setMultilingual();
		if($field->isSortable()) $column->setSortable();
		if($field->useFilter()) $column->setFilter();
	    }
	}
	$grido->addAction('edit', 'Upravit')->setIcon('wrench');
	$grido->addAction('delete', 'Smazat')->setIcon('trash');
	return $grido;
    }
    
    protected function createComponentAdminForm($name){
	$form = new Form;
	foreach($this->getFields() as $field){
	    $label = $field->getLabel();
	    
	    $callback = callback(Array($form, $field->getFormFunctionName()));
	    $control = $callback->invokeArgs(Array($field->getName(), $label));
	    $control->setValue($field->getValue());
	    
	    
	    if($field instanceof Fields\Text) {
		if($field->isMandatory()) $control->addRule(Form::FILLED, sprintf($this->messageMandatory, $label));
		//if($length = $field->getMaxLength()) $control->addRule(Form::MAX_LENGTH, sprintf($this->messageMaxLength, $label, $length));
	    }
	    if($field instanceof Fields\Textarea){
		if($field->getUseEditor()){
		    $control->setAttribute('class', "ckeditor");
		}
	    }
	    if($field instanceof Fields\Lang){
		$control->setItems($field->getLanguages())
			->setDefaultValue($field->getDefaultLanguage());
	    }
	}
        $form->addSubmit("send", "Uložit formulář");
	$form->onSuccess[] = callback($this, "formSubmitted");
	
        return new \Natty\FormRenderer($form, $this, $name);  
    }
    public function formSubmitted($form){
	$this->isReady();
	if($this->onFormSubmitted) {//user callback
	    $this->onFormSubmitted->invokeArgs(array($form, $preparedValues));
	    return null;
	}

	    $preparedValues = array();
	    foreach($this->getFields() as $field){
		$preparedValues[$field->getName()] = $form[$field->getName()]->getValue();
	    }
	    $this->repository->create($preparedValues);
    }
    /////////////////////////////////////////////// Fields  
    /**
     * Add new field to Manager
     * Fields are used for generating administration forms and grids
     * @param String $type field types can be found in the Natty\Fields\Field class Field::TYPE_TEXT etc.
     * @param String $name     
     * @param String $label
     * @param boolean $mandatory
     * @param int $maxLength
     * @return \Natty\type
     */  
    public function addField($name, $label, $type){
	$field = new $type($this, $name);
	$field->setLabel($label);
	return $field;
    }
    /**
     * returns array of components which are Natty\Fields\Field descendant
     * @return Array 
     */
    public function getFields($deep = true){
	return $this->getComponents($deep, "Natty\AdminFramework\Fields\Field");
    }
    
   public function getGridSelection(){
       foreach($this->multilingualFields as $mField){
	   $this->repository->getAll()->select('contracts.*, clients.name as client_name, branches.name as branch_name');
       }
   }
    /**
     * Checks wheter this component is setted up correctly
     * @return boolean
     * @throws \Exception
     */
    public function isReady()
    {
        if(false) {
            throw new \Exception("DataGrid is not setted up correctly.");
        }
        return true;
    }
    public function setOnFormSubmitted($callback){
	$this->onFormSubmitted = \Natty::validateCallback($callback);
	return $this;
    }
    /**
     * @param \Natty\Repositories\Repository $repository
     * @return NULL
     */
    public function setRepository(\Natty\Repositories\Repository $repository){
	$this->repository = $repository;
	return $this;
    }
    
    public function setPrimaryKey($key){
	$this->primaryKey = new Fields\PrimaryKey($this, $key);
	return $this;
    }   
    /**
     * Sets component to multilingual mode
     * @param boolean $multi
     * @return Natty\AdminFramework\Multilingual|null 
     *	    Returns Lang component for necessary settings 1. setLanguages() 2.setDefaultLanguage())
     *	    You must keep the order of those settings
     */
    public function setMultilingualMode($multi = true) {
	$this->multilingualMode = $multi;
	if($multi = true) {
	    return new Fields\Lang($this, "lang");
	} else {
	    unset($this["lang"]);
	}
	return null;
    }
    public function registerMultilingualField(&$field){
	$this->multilingualFieldNames[] = $field->getName();
    }
    public function Multilingual($defaultLanguage, array $languages){
	$this->setMultilingualMode()
		->setDefaultLanguage($defaultLanguage)
		->setLanguages($languages);
    }
    public function setTranslationsTable($table){
	$this->translationsTable = $table;
    }
    /**
     * @param String $message
     */
    public function setMessageMandatory($message){
	$this->messageMandatory = $message;
	return $this;
    }
    
    
    /**
     * @param String $message
     */
    public function setMessageMaxLength($message){
	$this->messageMaxLength = $message;
	return $this;
    }    
}

