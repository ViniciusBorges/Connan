<?php
	
	class Connan_User_Model extends Connan_Application_Model
	{
		public function construct()
		{
			$this->addPrefix('#{users}', '#__users');
		}
		
		public function hasEmail($email)
		{
			return $this->getNumRows("SELECT * FROM #{users} WHERE email = '$email'");
		}
		
		public function hasUsername($username)
		{
			return $this->getNumRows("SELECT id FROM #{users} WHERE username = '$username'");
		}
		
		public function registerUser($user)
		{
			$default = (object) array(
				'username' => $user->username,
				'password' => $user->password,
				'email' => $user->email,
				'name' => $user->name,
				'published' => $user->published,
				'type' => $user->type
			);
			$query = $this->query("
				INSERT INTO #{users}
				(username, password, email, name, published, type)
				VALUES(
					'$default->username',
					'$default->password',
					'$default->email',
					'$default->name',
					'$default->published',
					'$default->type'
				)
			");
			if(!$query)
			{
				return false;
			}
			$user = $this->getInsertId();
			
			$default = (array) $default;
			foreach($user as $k => $v)
			{
				if(!isset($default[$k]))
				{
					$field = $this->getUserFieldByName($k)->id;
					$this->addUserValue($user, $field, $v);
				}
			}
			return $user;
		}
		
		public function deleteUser($id)
		{
			return
			$this->query("
				DELETE FROM #{users}_values WHERE user_id = '$id'
			") &&
			$this->query("
				DELETE FROM #{users} WHERE id = '$id'
			");
		}
		
		public function getUserValue($id)
		{
			return $this->loadObject("
				SELECT * FROM #{users}_values WHERE id = '$id'
			");
		}
		
		public function getUserValues($user)
		{
			return $this->loadObjectList("
				SELECT * FROM #{users}_values WHERE user_id = '$user'
			");
		}
		
		public function hasUserValue($user, $field)
		{
			return $this->getNumRows("
				SELECT id FROM #{users}_values WHERE user_id = '$user' AND field_id =  '$field'
			");
		}
		
		public function addUserValue($user, $field, $value)
		{
			return $this->query("
				INSERT INTO #{users}_values
				(user_id, field_id, value)
				VALUES('$user', '$field', '$value')
			");
		}
		
		public function editUserValue($id, $value)
		{
			return $this->query("
				UPDATE #{users}_values
				SET value = '$value'
				WHERE id = '$id'
			");
		}
		
		public function deleteUserValue($id)
		{
			return $this->query("
				DELETE FROM #{users}_values WHERE id = '$id'
			");
		}
		
		public function getUserField($id)
		{
			return $this->loadObject("
				SELECT * FROM #{users}_fields WHERE id = '$id'
			");
		}
		
		public function getUserFieldByName($name)
		{
			return $this->loadObject("
				SEELCT * FROM #{users}_fields WHERE name = '$name'
			");
		}
		
		public function getUserFields()
		{
			return $this->loadObjectList("
				SELECT * FROM #{users}_fields
			");
		}
		
		public function hasUserField($id)
		{
			return count($this->getUserField($id));
		}
		
		public function addUserField($field)
		{
			return $this->query("
				INSERT INTO #{users}_fields
				(title, type, required, area, default, options)
				VALUES(
					'$field->title',
					'$field->type',
					'$field->required',
					'$field->area',
					'$field->default',
					'$field->options'
				)
			");
		}
		
		public function editUserField($field)
		{
			return $this->query("
				UPDATE #{users}_fields
				SET title = '$field->title',
					type = '$field->type',
					required = '$field->required',
					area = '$field->area',
					default = '$field->default',
					options = '$field->options'
				WHERE id = '$field->id'
			");
		}
		
		public function deleteUserField($id)
		{
			return $this->query("
				DELETE FROM #{users}_fields WHERE id = '$id'
			");
		}
	}