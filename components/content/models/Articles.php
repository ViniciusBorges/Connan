<?php

	class Connan_ArticlesModel extends Connan_Application_Model
	{
		public function construct()
		{
			$this->addPrefix('#{content}', '#__content');
		}
		
		public function getArticles()
		{
			return $this->loadObjectList("SELECT * FROM #{content}");
		}
	}