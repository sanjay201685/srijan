<a href="/char_frequency/index.php?p=1">Problem1</a>
<a href="/char_frequency/index.php?p=2">Problem2</a>

<?php
// Including requried classes.
include_once 'controller/CharFrequencyController.php';
include_once 'controller/SubstringController.php';

// Calling controller on the basis of click on above menu.
if (!empty($_REQUEST['p']) && $_REQUEST['p'] == 1) {
  $char_frequency_obj = new CharFrequencyController();
  $char_frequency_obj->index();    
}
elseif (!empty($_REQUEST['p']) && $_REQUEST['p'] == 2)  {
  $char_frequency_obj = new SubstringController();
  $char_frequency_obj->index();
}