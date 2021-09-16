<?php namespace Squanbri\Authentication\Components;

use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;

class Companies extends ComponentBase {
  
  public function componentDetails() 
  {
    return [
      'name' => 'Компании',
      'description' => 'Компания, Компании'
    ];
  }

  public function onRun() {
    $page = $this->page->url;

    if ($page === '/kompaniya/:id') {
      $this->getCompany();
    }
  }

  public function getCompany() {
    $id = $this->param('id');
    $company = CompanyModal::findOrFail($id);
    $this->page['company'] = $company;
  }

  public function getCompanyName($id) {
    return CompanyModal::findOrFail($id)->name;
  }
}

?>