<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login {

    public function isLoginOut()
    {
		
		
		if(!isset($_SESSION['login'])){
			redirect(site_url('Welcome/login'));
		}
    }
	public function isLogin()
    {
		if(!isset($_SESSION['login'])){
			echo'<script>parent.openLogin(); </script>';
		}
    }
	public function isLoginAjax()
    {
		if(!isset($_SESSION['login'])){
			return true;
		}
		return false;
    }
}