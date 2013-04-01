<?php
namespace AdminModule;
use Nette\Application\UI\Form;
use Natty\EventsComponent;
/**
 * Description of ArticleManager
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
class EventManagerPresenter extends BaseAdminPresenter {
    protected $eventsRepository;
    protected $eventType = Array(
	"race", "other"
    );
    public function startup() {
        parent::startup();
        $this->eventsRepository = $this->context->eventsRepository;
    }
    //Add
    protected function createComponentEventForm(){
        $msg = "Nevyplnili jste povinné pole ";
        $form = new Form;
	$form->getElementPrototype()->addAttributes(Array("class"=>"formee"));
	$form->addHidden("id");
        $form->addText("name", "Název akce:")
		->addRule(Form::FILLED, $msg."'Název akce'.");
	$form->addText("dateFrom","Datum začátku:")->setAttribute("class", "datepicker");
	$form->addText("timeFrom","Čas začátku:")->setAttribute("class", "timepicker");
	$form->addText("dateTo","Datum konce:")->setAttribute("class", "datepicker");
	$form->addText("timeTo","Čas konce:")->setAttribute("class", "timepicker");
	$form->addText("location","Místo konání:");
        $form->addTextArea("description", "Popis akce")->setAttribute('class', "ckeditor");
        $form->addSubmit("send", "Potvrdit");
	$form->onSuccess[] = $this->formSubmitted;
	
        return $form;        
	
    }
    public function formSubmitted($form){
        $vals = $form->form->getValues();
	$timeFrom = $vals->timeFrom;
	$timeTo = $vals->timeTo;
	$dateFrom= $this->template->date($vals->dateFrom,"Y-m-d");
	$dateTo = $this->template->date($vals->dateTo,"Y-m-d");
	if(!$vals->id) {
	    $this->eventsRepository->createEvent($vals->name,  $dateFrom,$timeFrom , $dateTo, $timeTo, $vals->location, $vals->description, $this->user->id);
	    $this->flashMessage('Událost byla přidána.', 'success');
	    $this->redirect("Default");	    
	} else {
	    $this->eventsRepository->updateEvent($vals->id, $vals->name, $dateFrom,$timeFrom , $dateTo, $timeTo, $vals->location, $vals->description, $this->user->id);
	    $this->flashMessage('Událost byla upravena.', 'success');
	    $this->redirect("Default");
	}
    }
    //Edit
    protected function prepareDefaultsEdit($event){
	return Array(
	    "id" =>  $event->id,
	    "name" =>  $event->name,
	    "dateFrom" =>  $this->template->date($event->date_start, "d.m.Y"),
	    "timeFrom" =>  $this->template->date($event->time_start, "H:i"),
	    "dateTo" =>  $this->template->date($event->date_end, "d.m.Y"),
	    "timeTo" =>  $this->template->date($event->time_end, "H:i"),
	    "location" =>  $event->location,
	    "description" =>  $event->description
	);
    }
    public function actionEdit($id){
	$item = $this->eventsRepository->getOne($id);
	$defaults = $this->prepareDefaultsEdit($item);
	$this['eventForm']->setDefaults($defaults);
    }
    //Delete
    public function actionDelete($id){
	$this->eventsRepository->delete($id);
	$this->redirect("Default");
    }
    //Delete
    protected function createComponentEvents($name){
	$events = new EventsComponent($this->eventsRepository, $this,$name);
	$events->isAdmin = true;
	return $events;
    }
    protected function createComponentSubMenu($name) {
	return $this['topMenu']->getMenuFromChildrenById(30, $name);
    }
}

?>
