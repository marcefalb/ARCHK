<?php namespace Squanbri\Authentication\Components;

use Request;
use Response;
use Redirect;
use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Classes\Filters as FiltersClass;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;
use Squanbri\Authentication\Models\Pagination as PaginationModal;

class Vacancies extends ComponentBase {

  public $vacancy;
  public $vacancies;
  public $company_id;
  public $pagination;
  public $countVacancies;

  public function componentDetails() 
  {
    return [
      'name' => 'Вакансии',
      'description' => 'Вакансии, похожие вакансии'
    ];
  }

  public function onRun() {
    $page = $this->page->url;
    $id = $this->param('id');
    $vacancies = new VacancyModal();    

    if ($page === '/kompaniya/:id') {
      $this->vacancies = $vacancies->getVacancies($id);
    } else if ($page === '/vakansiya/:id') {
      $this->vacancy = $vacancies->getVacancy($id);
    } else if ($page === '/redaktirovanie-vakansii/:id') {
      if (isset((new Session)->checkAunticate()['id'])) {
        $this->company_id = (new Session)->checkAunticate()['id'];
      }
      $this->getAccess();
      $this->vacancy = $vacancies->getVacancy($id);
    } else if ($page === '/vakansii') {
      $vacancies = (new VacancyModal)->getAllVacancies();
      $filters = new FiltersClass($vacancies);
      $this->vacancies = $filters->filter();
      $filters = new PaginationModal($this->vacancies);
      $this->vacancies = $filters->pagination();
    }
  }

  public function getAccess() {
    $vacancy_id = $this->param('id');
    $vacancy_company_id = VacancyModal::find($vacancy_id)->companies_id;
    $user = (new Session)->checkAunticate();
    
    if ($user !== false && $vacancy_company_id === $user['id'])
    {
      return 123;
    }
    else {
      return $this->controller->run('404');
    }
  }

  public function onAddVacancy() {
    $id = (new Session)->checkAunticate()['id'];
    (new VacancyModal)->addVacancy($id);
  }

  public function onEditVacancy() {
    $vacancy_id = $this->param('id');
    (new VacancyModal)->editVacancy($vacancy_id);
  }

  public function onDeleteVacancy() {
    $vacancy_id = $this->param('id');
    (new VacancyModal)->deleteVacancy($vacancy_id);
  }
}
?>