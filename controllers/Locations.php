<?php
namespace Gigafeed\Locations\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Locations extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        return redirect('/backend/offline/openinghours/locations');
    }
}