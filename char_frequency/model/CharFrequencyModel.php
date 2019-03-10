<?php
class CharFrequencyModel {
  private $char_count = [];
    
  public function index() {
    // Checking form is submitted or not. If submitted then display result else form.
    if (!empty($_REQUEST) && !empty($_REQUEST['submit']) && $_REQUEST['submit'] === 'Submit') {
      $result = $this->countCharFrequency($_REQUEST['string']);
    
      return $result;
    }
    else {
      return 'get_form';
    }
  }
  
  /**
   * Count total no of frequency of char.
   */
  public function countCharFrequency($string) {
    if (strpos($string, '?')) {
      // PHP_EOL is ostensibly used to find the newline character.
      $exp_string = explode(PHP_EOL, $string);
      
      // Excu
      for ($i = 0; $i < count($exp_string); $i++) {
        if (substr_count($exp_string[$i], '?') > 0) {
          $match_text = trim(str_replace('?', '', $exp_string[$i]));
          
          // Excute loop till total no of element.
          $total_occ = 0;
          for ($j = 0; $j < count($exp_string); $j++) {
            if (substr_count(trim($exp_string[$j]), '?') == 0 && 
              substr_count(trim($exp_string[$j]), $match_text) >  0) {
              $total_occ += 1; 
            }
          }
          $char_count[] = $total_occ;
        }
      }
      return $char_count;  
    }
  }
}