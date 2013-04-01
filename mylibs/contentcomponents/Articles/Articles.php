<?php
namespace Natty;
use Grido\Components\Columns\Column;
class ArticlesComponent extends \Nette\Application\UI\Control {
    protected $articlesRepository;
    public $edit = false;
    public $isAdmin = false;
    public $isHome = false;
    public $limit = null;
    public function __construct(Repositories\ArticlesRepository $articlesRepository,\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
	parent::__construct($parent, $name);
	$this->articlesRepository = $articlesRepository;
    }    
    public function render(){
	$tpl = $this->template;
	$tpl->setFile(__DIR__."/articles.latte");
	$tpl->isAdmin = $this->isAdmin;
	$tpl->isHome = $this->isHome;
	//$tpl->showAsTable = $this->showAsTable;
	$tpl->articles = $this->articlesRepository->getAll()->limit($this->limit);
	$tpl->render();
    }
    public function renderHome($lim){
	$this->isHome = true;
	$this->limit = $lim;
	$this->render();
    }
    public function renderAdmin(){
	$this->isAdmin = true;
	$this->render();
    }
    protected function createComponentGrid($name)
    {

    }
}