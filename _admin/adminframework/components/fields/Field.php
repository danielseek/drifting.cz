<?php
/*
 * This file is part of the Natty CMS (http://nattycms.org), based on the Nette Framework (http://nette.org)
 *  Copyright (c) 2013 Daniel Sýkora (http://danielsykora.com)
 */

namespace Natty\AdminFramework\Fields;

use Nette;
use Grido\Components\Columns\Column;

/**
 * Description of Field
 *
 * @author Daniel Sýkora
 */
abstract class Field extends Nette\Application\UI\PresenterComponent {
    /** @var Natty\AdminFramework */
    protected $admin;
    /**
     * Name of add function in \Nette\Application\UI\Form
     * To be overridden by descendant
     * @var String
     */    
    protected $formFunctionName; 
    
    public $isMultilinagual = false;
    
    //dataGrid
    public $useInGrid = false;
	public $sortable = false;
	public $filter = false;
	
    //adminForm
    public $isMandatory = false;
    public $label = null;
    public $value = null;
    
    const TYPE_TEXT = "Natty\AdminFramework\Fields\Text",
	  TYPE_TEXTAREA = "Natty\\AdminFramework\Fields\Textarea",
	    TYPE_HIDDEN = "Natty\AdminFramework\Fields\Hidden";
    
    
    /**
     * 
     * @param Nette\ComponentModel\IContainer $parent
     * @param String $name
     * @param int $type
     */
    public function __construct(Nette\ComponentModel\IContainer $parent, $name) {
	$this->admin = $parent;
	parent::__construct($parent, $name);
    }
    
    public function getGridType(){
	flog(get_class($this));
	switch (get_class($this)) {
	case Field::TYPE_TEXT : return Column::TYPE_TEXT;
		break;
	case Field::TYPE_TEXTAREA : return Column::TYPE_TEXT;
		break;
	default: return Column::TYPE_TEXT;
		break;
	}
    }
    public function isSortable(){
	return $this->sortable;
    }
    public function useFilter(){
	return $this->filter;
    }
    public function setLabel($label){
	$this->label = $label;
	return $this;
    }
    public function getLabel(){
	return $this->label;
    }
    public function getValue(){
	return $this->value;
    }
    public function setValue($value){
	$this->value = $value;
	return $this;
    }
    /**
     * if mandatory set to true, form will require this field to be filled
     * @param boolean $man
     * @return Provides fluent interface
     */
    public function setMandatory($man = true){
	$this->isMandatory = $man;
	return $this;
    }
    public function isMandatory(){
	return $this->isMandatory;
    }
    
    public function setUseInGrid($use = true){
	$this->useInGrid = $use;
	return $this;
    }
    public function useInGrid(){
	return $this->useInGrid;
    }
    /**
     * Sets field as multilingual and registers it in parent component admin
     * @param boolean $isMulti
     * @return \Natty\AdminFramework\Fields\Field Fluent interface
     */
    public function setMultilingual($isMulti = true){
	$this->admin->registerMultilingualField($this);
	$this->isMultilinagual = $isMulti;
	return $this;
    }
    /**
     * @return boolean
     */
    public function isMultilingual(){
	return $this->isMultilinagual;
    }
    /**
     * Return function name for Nette\Application\UI\Form
     * @return string
     */
    public function getFormFunctionName(){
	return $this->formFunctionName;
    }
}

