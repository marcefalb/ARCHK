<?php namespace Squanbri\Authentication\Classes;

use Db;
use Hash;
use Crypt;

class Session 
{ 

  public function findUser($table, $email)
  {
    $table = Db::table($table);
    $user = $table->where('email', $email)->first();

    if($user === NULL) $user = false;
    return (array) $user;
  }

  public function findByValue($table, $email, $value) 
  {
    $table = Db::table($table);
    $result = $table->where('email', $email)->value($value);
    if($result === NULL) $result = false;
    return $result;
  }

  public function register($data)
  { 
    $table = Db::table($data['table']);

    if(!$this->findUser($data['table'], $data['email'])[0]){
      $table->insert(
        [
          'email' => $data['email'], 
          'password' => Hash::make($data['password'])
        ]
      );

      $this->authenticate($data);
    }
  }

  public function authenticate($data) 
  {
    $table = Db::table($data['table']);

    if ($this->findUser($data['table'], $data['email']))
    { 
      if ($this->checkPassword($data['table'], $data['email'], $data['password'])) 
      {
        $key = Crypt::encrypt($data['email']);
        setcookie('key_authenticate', $key, time()+3600*24*30, 'archk', '', 0, 1);
        return 'authenticate';
      }
    }
    return false;
  }

  public function logout() 
  {
    if (isset($_COOKIE['key_authenticate'])) {
      unset($_COOKIE['key_authenticate']); 
      setcookie('key_authenticate', null, -1, '/'); 
      return true;
    } else {
        return false;
    }
  }

  public function checkPassword($tablename, $email, $password) 
  {
    $table = Db::table($tablename);
    $result = Hash::check($password, $this->findByValue($tablename, $email, 'password'));
    return $result;
  }

  public function checkAunticate() {
    if (isset($_COOKIE['key_authenticate'])) 
    {
      $key = Crypt::decrypt($_COOKIE['key_authenticate']);
      $user = (array) $this->findUser('squanbri_authentication_users', $key);
      $company = (array) $this->findUser('squanbri_authentication_companies', $key);

      if (!isset($user[0])) {
        return $user;
      }
      else {
        return $company;
      }
    }

    return false;
  }

  public function checkType() {
    if (isset($_COOKIE['key_authenticate'])) 
    {
      $key = Crypt::decrypt($_COOKIE['key_authenticate']);
      $user = $this->findUser('squanbri_authentication_users', $key);
      $company = $this->findUser('squanbri_authentication_companies', $key);

      if (!isset($user[0])) {
        return 'user';
      }
      else {
        return 'company';
      }
    }

    return false;
  }
}

?>