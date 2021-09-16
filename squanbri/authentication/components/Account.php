<?php namespace Squanbri\Authentication\Components;

use Flash;
use Input;
use Redirect;
use Validator;
use ValidationException;
use Cms\Classes\ComponentBase;
use Squanbri\Authentication\Classes\Session;
use Squanbri\Authentication\Models\Users as UserModal;
use Squanbri\Authentication\Models\Companies as CompanyModal;
use Squanbri\Authentication\Models\Vacancies as VacancyModal;

class Account extends ComponentBase {
  public $user;
  public $type;
  public $summary;

  public function componentDetails() {
    return [
      'name' => 'Аккаунт',
      'description' => 'Аунтефикая, проверка ауентификации, регистрация'
    ];
  }

  public function onRun() {
    $session = new Session();
    $this->user = $session->checkAunticate();
    $this->type = $session->checkType();

    if ($this->type === 'user') {
      $this->summary = (new UserModal)->getSummary();
    }
  }

  public function onRegistration() 
  { 
    $data = post();

    $attribute = [
      'password' => 'пароль',
      'password_confirmation' => 'подтверждение пароля'
    ];

    $messages = [
      'required' => 'Поле :attribute обязательно для заполнения.',
      'email' => 'Поле email должно содержать адрес электронной почты',
      'same' => 'Поле :attribute должно совподать с полем :other',
      'unique' => 'Такой :attribute уже зарегистрирован'
    ];

    $rules = [
      'email' => 'required|email|unique:squanbri_authentication_users',
      'password' => 'required|min:5',
      'password_confirmation' => 'required|min:5|same:password'
    ];

    $validator = Validator::make($data, $rules, $messages, $attribute);

    if($validator->fails()) {
      throw new ValidationException($validator);
    } else {

      $vars = [
        'table' => Input::get('type_user') === 'user' ? 
          'squanbri_authentication_users' : 
          'squanbri_authentication_companies', 
        'email' => Input::get('email'), 
        'password' => Input::get('password')
      ];

      $user = new Session();
      $user->register($vars);
      return Redirect::to('/');
    }
  }

  public function onAuthentication()
  {
    $data = post();

    $attribute = [
      'password' => 'пароль',
    ];

    $messages = [
      'required' => 'Поле :attribute обязательно для заполнения.',
      'email' => 'Поле email должно содержать адрес электронной почты',
    ];

    $rules = [
      'email' => 'required|email',
      'password' => 'required',
    ];

    $validator = Validator::make($data, $rules, $messages, $attribute);

    if($validator->fails()) {
      throw new ValidationException($validator);
    } else {
      $vars = ['table' => 'squanbri_authentication_users', 'email' => Input::get('email'), 'password' => Input::get('password')];
      $session = new Session();
      $user = $session->authenticate($vars);
      $vars['table'] = 'squanbri_authentication_companies';
      $company = $session->authenticate($vars);

      if($user || $company) {
        return Redirect::to('/');
      }

      Flash::error('Неверный логин или пароль');
      return Redirect::back()->withInput(post());
    }
  }

  public function onLogout() 
  {
    $session = new Session();
    $session->logout();
    return Redirect::to('/');
  }

  public function onEditProfile() 
  {
    $email = (new Session)->checkAunticate()['email'];

    $result = (new UserModal)->editProfile($email);
  }

  public function onEditCompany()
  {
    $email = (new Session)->checkAunticate()['email'];

    $result = (new CompanyModal)->editCompany($email);
  }

  // GETS
  public function getBirthDate() {
    $id = $this->param('id');
    return (new UserModal)->getUser($id)['birth_date'];
  }
}

?>