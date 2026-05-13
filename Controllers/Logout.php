<?php
class Logout
{
	public function __construct()
	{
		session_start(OPTION_SESIONCPANEL);
		session_unset();
		session_destroy();
		header('location: ' . base_url() . '/login');
	}
}
?>