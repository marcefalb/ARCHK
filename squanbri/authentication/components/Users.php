<?php namespace Squanbri\Authentication\Components;

use Response;
use Redirect;
use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Models\Users as UsersModal;
use Squanbri\Authentication\Models\Summaries as Summaries;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;

class Users extends ComponentBase {

  public $user;

  public function componentDetails() 
  {
    return [
      'name' => 'Пользователи',
      'description' => 'Пользователь, пользователи'
    ];
  }

  public function onRun() {
    $page = $this->page->url;
    $id = $this->param('id');

    if ($page === '/polzovatel/:id') {
      $this->user = $this->getUser($id);
    }
  }

  public function getUser($id) {
    return (new UsersModal)->getUser($id);
  }
}
?>