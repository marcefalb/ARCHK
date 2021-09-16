<?php namespace Squanbri\Authentication\Components;

use Request;
use Response;
use Redirect;
use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Models\Users as UsersModal;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;
use Squanbri\Authentication\Models\Summaries as SummariesModal;
use Squanbri\Authentication\Models\Favourites as FavouritesModal;

class Favourites extends ComponentBase {

  public $favourites;

  public function componentDetails() 
  {
    return [
      'name' => 'Избранное',
      'description' => 'Просмотр избранного, добавление в избранное'
    ];
  }

  public function onRun() {
    $page = $this->page->url;

    if ($page === '/izbrannoe' && !isset((new Session)->checkAunticate()['email'])) {
      return $this->controller->run('404');
    }
    
    if (isset((new Session)->checkAunticate()['email'])) {
      $email = (new Session)->checkAunticate()['email'];
      $this->favourites = (new FavouritesModal)->getFavourites($email);
    }
  }

  public function onAddFavourite() {
    $email = (new Session)->checkAunticate()['email'];
    $id = Request::input()['id'];
    $type = Request::input()['type'];
    (new FavouritesModal)->addFavourite($email, $type, $id);
  }

  public function onRemoveFavourite() {
    $email = (new Session)->checkAunticate()['email'];
    $id = Request::input('id');
    $type = Request::input()['type'];
    var_dump((new FavouritesModal)->removeFavourite($email, $type, $id));
  }

  public function existInFavourites($id) {
    if (isset((new Session)->checkAunticate()['email'])) {
      $email = (new Session)->checkAunticate()['email'];
      return (new FavouritesModal)->checkSelfFavourite($email, $id);
    }

    return false;
  }
}
?>