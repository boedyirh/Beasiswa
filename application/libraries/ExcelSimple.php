<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once dirname(__FILE__) . '/Xlsxwriter.class.php';
  
class ExcelSimple extends Xlsxwriter { 
    public function __construct() { 
        parent::__construct(); 
    } 
}