<?php
// Includeing Model class.
include_once 'model/CharFrequencyModel.php';

class CharFrequencyController {
  // Defining variables.
  private $model;
  
  public function __construct() {
    $this->model = new CharFrequencyModel();
  }
  
  public function index() {
   $getForm = $this->model->index();
   
   // If form not submit then display form else result.
   if (!empty($getForm) && $getForm === 'get_form') {
     include 'view/CharFrequencyForm.php';
   }
   else {
     include 'view/CharFrequencySubmit.php';
   }
  }
}