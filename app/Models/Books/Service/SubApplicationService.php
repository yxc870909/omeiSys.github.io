<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\SubApplicationRepository as SubApplicationRepository;
use Auth;
use DB;

class SubApplicationService
{
	public static function getApplicationData()
	{
		$data =  SubApplicationRepository::getApplicationData();
		return json_decode(json_encode($data), true);
	}
}