<?php namespace Squanbri\Authentication\Classes;

use Input;

class Filters 
{ 
  public $array;

  function __construct($array) {
    $this->array = $array;
  }

  function filter() {

    $city = Input::get('city');
    $salary = Input::get('salary');
    $min_salary = intval(Input::get('min_salary'));
    $max_salary = intval(Input::get('max_salary'));
    $industry = Input::get('industry');
    $schedules = ['schedule_full', 'schedule_part', 'schedule_watchkeeper'];
    $experiences = ['experience_none', 'experience_without', 'experience_1-3', 'experience_3-6', 'experience_6'];


    foreach ($this->array as $key => $item) {
      if ($item->city !== $city && $city !== NULL) // CITY
      { 
        unset($this->array[$key]);
        continue;
      } 

      if ($salary === 'Свой диапазон') // SALARY
      {
        if (intval($item->salary) < $min_salary || intval($item->salary) > $max_salary) 
        {
          unset($this->array[$key]);
          continue;
        }
      }

      if ($item->industry !== $industry  && $industry !== NULL) // INDUSTRY
      {
        unset($this->array[$key]);
        continue;
      }

      $checkboxsActive = []; // SCHEDULE
      foreach ($schedules as $schedule) { 
        if (!is_null(Input::get($schedule))) {
          $checkboxsActive[] = Input::get($schedule);
        }
      }
      if(!empty($checkboxsActive)) 
      {
        if (!in_array($item->schedule, $checkboxsActive)) {
          unset($this->array[$key]);
          continue;
        }
      }

      $checkboxsActive = []; // EXPERINCE
      foreach ($experiences as $experience) { 
        if (!is_null(Input::get($experience))) {
          $checkboxsActive[] = Input::get($experience);
        }
      }
      if(!empty($checkboxsActive)) 
      {
        if (!in_array($item->experience, $checkboxsActive)) {
          unset($this->array[$key]);
          continue;
        }
      }
    }
    
    return $this->array;
  }
}

?>