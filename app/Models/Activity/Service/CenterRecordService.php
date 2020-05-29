<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\CenterRecordRepository as CenterRecordRepository;
use Auth;
use DB;

class CenterRecordService
{
	public static function update($filter, $updateData)
	{
		CenterRecordRepository::update($filter, $updateData);
	}
}