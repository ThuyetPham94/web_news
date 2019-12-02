<?php
namespace App\Http\Controllers\Utils;

use Carbon\Carbon;
/**
 * Class JsonResponse
 * Simple response object for Laravue application
 * Response format:
 * {
 *   'success': true|false,
 *   'data': [],
 *   'error': ''
 * }
 *
 * @package Ultis
 */
class FilterDate
{
    /**
	 * get list bill by filter date
	 * @param $q query
	 * @param <string> $numDay number date for filter(7 day or 1 month)
	 * 
	 * @return where
	 */
	static function filterByDate($numDay = 7, $q) {
		$dt = Carbon::now();
		$now = $dt->addDay()->isoFormat('YYYY-MM-DD');
		$last = $dt->subDays($numDay)->isoFormat('YYYY-MM-DD');
		$query = $q->whereDate('created_at', '<', $now)->whereDate('created_at', '>=', $last);
		return $query;
	}

	static function formatDateTime($value, $parten) {
        return Carbon::parse($value)->setTimezone('Asia/Ho_Chi_Minh')->format($parten);
    }
}
