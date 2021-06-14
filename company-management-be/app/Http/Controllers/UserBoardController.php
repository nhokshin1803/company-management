<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserBoard\UserBoardRepositoryInterface;

class UserBoardController extends Controller
{
    protected $userBoardRepo;

    public function __construct(UserBoardRepositoryInterface $userBoardRepo)
    {
        $this->userBoardRepo = $userBoardRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        //
        return $this->userBoardRepo->getByConditions('user_id', $user_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->userBoardRepo->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->userBoardRepo->find($id);
    }

    /**
     * Remove the specified resource from storage.
     * Depend on user id and board id
     * @param  int  $user_id
     * @param  int  $board_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $board_id)
    {
        //
        $this->userBoardRepo->relationshipDelete($user_id, $board_id);
    }
}
