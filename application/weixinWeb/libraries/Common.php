<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {

	public function json($json_arr){
		print_r(json_encode($json_arr));
		exit();

	}

}