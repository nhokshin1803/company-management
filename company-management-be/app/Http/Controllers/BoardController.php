<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBoardRequest;
use App\Repositories\Board\BoardRepositoryInterface;
use App\Http\Resources\BoardResource;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    protected $boardRepo;

    public function __construct(BoardRepositoryInterface $boardRepo)
    {
        $this->boardRepo = $boardRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return BoardResource::collection($this->boardRepo->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardRequest $request, $user_id)
    {
        $this->boardRepo->createBoard($request->all(), $user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return BoardResource::collection($this->boardRepo->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->boardRepo->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $board_id)
    {
        return $this->boardRepo->softDelete($user_id, $board_id);
    }

    /**
     * Display the boards that have param user id
     * The relationship shown in table user_board
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function getBoards($user_id)
    {
        return $this->boardRepo->getBoards($user_id);
    }
}
