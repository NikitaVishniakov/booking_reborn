<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:42
 */

namespace controllers;
use models\Costs;

class Finance  extends \core\base\Controller
{
  public function incomesAction(){
      if(isset($_GET['ajax'])){
          $this->layout = false;
      }

  }
  public function costsAction(){
      if(isset($_GET['ajax'])){
          $this->layout = false;
      }

  }
  public function loadingAction(){

  }

  public function addCostAction(){
      $this->layout = false;

      if(is_numeric($_POST['cost']['CATEGORY'])){
          $_POST['cost']['CATEGORY'] = Costs::getPropertyList('costs_categories', $_POST['cost']['CATEGORY'], array('NAME'))['NAME'];
      }
      $_POST['cost']['DATE'] = date_format(date_create($_POST['cost']['DATE']), "Y-m-d H:i");

      $save = Costs::save('costs', $_POST['cost']);

      if($save){
          header('location:'.$_SERVER['HTTP_REFERER']);
      }
  }

  public function editCostAction(){
      $this->layout = false;

      if(is_numeric($_POST['cost']['CATEGORY'])){
          $_POST['cost']['CATEGORY'] = Costs::getPropertyList('costs_categories', array('NAME'), $_POST['cost']['CATEGORY'])['NAME'];
      }

      $_POST['cost']['DATE'] = date_format(date_create($_POST['cost']['DATE']), "Y-m-d H:i");
      $save = Costs::update('costs', $_POST['cost']);
      if($save){
          header('location:'.$_SERVER['HTTP_REFERER']);
      }
  }

  public function addCostCategoryAction(){
      $this->layout = false;
      $save = Costs::save('costs_categories', $_POST['category']);
      if($save){
          header('location:'.$_SERVER['HTTP_REFERER']);
      }
  }

  public function addCostSubCategoryAction(){
      $this->layout = false;
      $save = Costs::save('costs_sub_categories', $_POST['subcategory']);
      if($save){
          header('location:'.$_SERVER['HTTP_REFERER']);
      }
  }

  public function ajaxSubCatAction(){
      $this->layout = false;
      $subcategories = selectCostSubCategories($_GET['category']);
      foreach ($subcategories as $cat) echo $cat;
  }
}
