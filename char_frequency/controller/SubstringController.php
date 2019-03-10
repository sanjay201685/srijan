<?php
// Includeing Model class.
include_once 'model/SubstringModel.php';

class SubstringController {
  // Defining variables.
  private $model;
  
  public function __construct() {
    $this->model = new SubstringModel();
  }
  
  public function index() {
   $getForm = $this->model->index();

   // If form not submit then display form else result. 
   if (!empty($getForm) && $getForm === 'get_form') {
     include 'view/SubstringForm.php';
   }
   else {
     include 'view/SubstringSubmit.php';
   }
  }
}