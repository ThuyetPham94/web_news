<?php
namespace App\Http\Services;

use App\User;
use App\Http\Services\BaseService as Base;
use Illuminate\Support\Facades\Cache;
use App\Models\Topic;
use App\Models\Words;
use App\Models\WordLevel;

class UserService extends Base
{
	public $model;

	public function __construct(User $model)
	{
		$this->model = $model;
	}

	public function masterData()
	{
		if (!Cache::has('masterData')) {
			$masterData = [
				'words' => Words::all(),
				'word_level' => WordLevel::all(),
				'topics' => Topic::all(),
				'users' => User::all()
			];
			Cache::put('masterData', $masterData, now()->addMinutes(60));
		}
		return Cache::get('masterData');
	}
	/**
	 * create a new user
	 * @param array userInfo
	 */
	function createUser($userInfo)
	{
		$user = User::create($userInfo);

		return $user;
	}

	/**
	 * function get User by id
	 * @param integer $id
	 */
	function getUserById($id)
	{
		try{
			$user = User::findOrFail($id);
		}catch(\Exception $e) {
			$user = collect();
		}
		return $user;
	}

	/**
	 * function get User by collum name
	 * @param string $nameCollum
	 * @param string value
	 */
	function getUserByName($nameCollum, $value)
	{
		try{
			$user = User::where($nameCollum, $value)->first();
		}catch(\Exception $e) {
			$user = collect();
		}
		return $user;
	}
}

?>
