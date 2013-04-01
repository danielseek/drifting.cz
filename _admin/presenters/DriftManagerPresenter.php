<?php
namespace AdminModule;
use Nette\Application\UI\Form;
/**
 * Description of ArticleManager
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
class DriftManagerPresenter extends BaseAdminPresenter {
    protected $driftRacesRepository;
    public function startup() {
        parent::startup();
        $this->driftRacesRepository = $this->context->driftRacesRepository;
    }
    public function actionDefault(){
	$this->template;
    }
    //races
    public function renderRaces(){
	$t = $this->template;
	$t->races = $this->driftRacesRepository->getAll();
    }
    public function createComponentRaces($name){
	$r = new \Natty\DriftRacesComponent($this->driftRacesRepository,  $this, $name);
	$r->admin = true;
	return;
    }
    //racesAdd
    protected function createComponentRaceForm() {
	    $f = new Form;
	    $f->addHidden("id");
	    $f->addText("name", "Název")->setRequired("Pole název je povinné.");
	    $f->addText("track","Trať")->setRequired("Pole Trať je povinné.");
	    $f->addText("location","Místo")->setRequired("Pole Místo je povinné.");
	    $f->addCheckbox("is_current", "Právě probíhající závod?");
	    $f->addSubmit("send", "Odeslat");
	    $f->onSuccess[] = $this->raceFormSubmitted;
	    return $f;
    }
    public function raceFormSubmitted($form){
        $vals = $form->form->getValues();
	if(!$vals->id) {
	    $this->driftRacesRepository->createRace($vals->name, $vals->track, $vals->location, $vals->is_current);
	    $this->flashMessage('Závod byl přidán.', 'success');
	    $this->redirect("Default");	    
	} else {
	    $this->driftRacesRepository->updateRace($vals->id, $vals->name, $vals->track, $vals->location, $vals->is_current);
	    $this->flashMessage('Závod byl upraven.', 'success');
	    $this->redirect("Default");
	}
    }
    protected function createComponentSubMenu($name) {
	return $this['driftPanel']->getComponent("menu")->getMenuFromChildrenById(10, $name);
    }
}

?>
