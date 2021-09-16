<?php namespace Squanbri\Authentication\Components;

use Input;
use Request;
use Response;
use Redirect;
use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Models\Users as UsersModal;
use Squanbri\Authentication\Models\Summaries as SummariesModal;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;

class Resume extends ComponentBase {

  public $resume;
  public $pagination;
  public $countResume;

  public function componentDetails() 
  {
    return [
      'name' => 'Резюме',
      'description' => 'Резюме, похожие резюме'
    ];
  }

  public function onRun() {
    $page = $this->page->url;
    $id = $this->param('id');

    $resume = new SummariesModal();
    if ($page === '/polzovatel/:id') {
      $this->resume = $resume->getResume($id);
    } else if ($page === '/rezyume') {
      $page = Request::input('page');
      $offset = 8;
      $this->resume = $resume->getPageResume($page, $offset);
      $this->pagination = $resume->getPagination($offset);

      $this->countResume = $resume->getCountResume();
    } else if ($page === '/redaktirovanie-profilya') {
      $id = (new Session)->checkAunticate()['id'];
      $this->resume = $resume->getResume($id);
    }
  }

  public function onEditResume() {
    $id = (new Session)->checkAunticate()['id'];
    (new SummariesModal)->editResume($id);
  }
}
?>