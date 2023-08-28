<?php
namespace App\Model;

class User extends Model
{
    protected $table='users';
    function __construct()
    {
        parent::__construct();
    }
    public function getUserByUsername($username)
    {
        return $this->read(['username' => $username]);
    }
}