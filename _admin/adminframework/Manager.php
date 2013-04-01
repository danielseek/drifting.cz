<?php
namespace Natty;
use Nette\Application\UI\Form;
use Natty\NattyDataGrid;
use AdminModule\BaseAdminPresenter;
use \Nette\Application\UI\Control;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Manager
 *
 * @author Daniel
 */
abstract class Manager extends BaseAdminPresenter {
    public function beforeRender(){
    }
    public function renderDefault() {
	
	$template = $this->template->setFile(__DIR__."/templates/default.latte");
	$template->headline = isset($this->headline["default"]) ? $this->headline["default"] : null;
    }
    public function renderAdd(){
	$template = $this->template->setFile(__DIR__."/templates/add.latte");
	$template->headline = isset($this->headline["add"]) ? $this->headline["add"] : null;
    }
    public function renderEdit(){
	$template = $this->template->setFile(__DIR__."/templates/edit.latte");
	$template->headline = isset($this->headline["edit"]) ? $this->headline["edit"] : null;
    }
    public function actionDelete($id){
	$this->model->delete($id);
    }
    protected function createComponentSubMenu($name) {
	try {
	    $control = $this['topMenu']->getMenuFromChildrenById($this->menuId, $name);
	} catch (NotFoundException $exc){
	    return $control;
	}
	return $control;
    } 
    /**
     *Overrides original presenter function to return different template path fot certain views* 
     * @return array
     *
    public function formatTemplateFiles()
    {
	if(in_array($this->view, array("default","edit","delete"))) {
	    return array(
		    __DIR__."/$this->view.latte"
	    );
	}
	return parent::formatTemplateFiles();  
    }*/   
    
    abstract protected function createComponentAdmin($name);
    abstract public function formSubmitted($form,$preparedValues);
}