<?php
namespace Natty;
abstract  class BaseContentComponent extends \Nette\Application\UI\Control {
    public $isAdmin = false;
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
	parent::__construct($parent, $name);
    }    
    public function render(){
	$tpl = $this->template;
	$tpl->isAdmin = $this->isAdmin;
	$tpl->render();	
    }
    protected function  getTemplatePath(){
	return __DIR__."/".str_replace("Presenter", null, lcfirst(join('', array_slice(explode('\\', get_class($this->parent)), -1))).".latte");
    }
}