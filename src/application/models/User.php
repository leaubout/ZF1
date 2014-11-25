<?php

class Model_User
{
    private $id;
    private $name;
    private $password;
	/**
     * @return the $id
     */
    public function getId()
    {
        return (int) $this->id;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

	/**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}