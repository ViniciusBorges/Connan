<?php

	class Connan_ArticlesController extends Connan_Application_Controller
	{
		public function construct()
		{
		}
		
		public function blogView()
		{
			$this->set('title', 'Controller title');
		}
	}