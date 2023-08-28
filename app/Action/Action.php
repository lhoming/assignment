<?php
namespace App\Action;

class Action
{
    protected $config;
    function __construct()
    {
        include  project_path().'/config/app.php';
        $this->config = $config;
    }
}