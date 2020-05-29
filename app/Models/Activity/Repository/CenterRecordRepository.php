<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\CenterRecord as CenterRecord;
use Auth;
use DB;
use View;
use Redirect;

class CenterRecordRepository
{
	public static function update($filter, $updateData)
	{
		CenterRecord::whereRaw($filter)->update($updateData);
	}
}