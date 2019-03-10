<?php

class SubstringModel {
  private $char_count = [], $cnt = 1, $exp_string = [], $str = '', $substr = '', $status = 0, $len = 0, $result = [];
    
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
  
  public function countCharFrequency($string) {
    if (!empty($string)) {
      // PHP_EOL is ostensibly used to find the newline character.
      $exp_string = explode(PHP_EOL, $string);
      
      for ($i = 0; $i <= count($exp_string); $i++) {
        if($this->cnt === 5) {
          $this->str    = trim($exp_string[$i - 4]);
          $this->substr = trim($exp_string[$i - 3]);
          $this->status = trim($exp_string[$i - 2]);
          $this->len    = trim($exp_string[$i - 1]);
           
          // Match string and return string position or No Worries!!. 
          $result[] = $this->match_string($this->str, $this->substr, $this->status, $this->len);
          $this->cnt = 1;
        }
        else {
          $this->cnt++;
        }
      }
      return $result;  
    }
    else {
      return 'Please enter string.';
    }
  }
  
  public function match_string($str, $substr, $status, $len) {
    // Match string and return string position or No Worries!!.
    $this->rest_of_str = substr($this->str, $this->len);
    if(!empty($this->status) && trim($this->status) == 'Y') {
      if(preg_match('/\s' . $this->substr .'\s/', $this->rest_of_str )){
        $this->match_str_pos = ($this->len + strpos($this->rest_of_str, $this->substr));
        return $this->match_str_pos;
      }
      else {
        return 'No Worries!!';
      }
    }
    elseif (!empty($this->status)) {
      if(preg_match('/' . $this->substr .'/', $this->rest_of_str)){
        $this->match_str_pos = ($this->len + strpos($this->rest_of_str, $this->substr));
        return $this->match_str_pos;
      }
      else {
        return 'No Worries!!';
      }
    }
    else {
      return 'Please enter string.';
    }
  }
}