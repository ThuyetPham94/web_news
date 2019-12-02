<?php

namespace App\Http\Controllers\ApiWeb;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\Utils\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiWeb\BaseController as Base;

class UserController extends Base
{

    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function masterData()
    {
        try {
            $result = $this->service->masterData();
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($restaurant_id, Request $request)
    {
        $param = $request->only('page');
        $type = $request->type;
        if ($type === 'all') {
            $type = ['waiter', 'cashier', 'chef'];
        } else {
            $type = [$type];
        }
        $users = $this->userService->getList(
            $request->input('limit', 0),
            $type,
            $request->input('level', ''),
            $request->input('date', '7'),
            $restaurant_id
        );
        $totalUsers = $this->userService->getList(0, $type, 0, '', $restaurant_id);

        $data = array(
            'userNumber' => $users->count(),
            'list' => $users,
            'total' => $totalUsers->count()
        );
        return response()->json(new JsonResponse($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $user = $this->userService->findUser($id);
    //     return response()->json(new JsonResponse($user));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $data = $request->only('birthday', 'sex', 'address', 'people_id', 'phone');
    //     $status = $this->userService->updateUser($data, $id);
    //     return response()->json(new JsonResponse($status));
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
