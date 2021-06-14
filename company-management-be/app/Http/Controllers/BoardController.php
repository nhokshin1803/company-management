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
    public function store(StoreBoardRequest $request)
    {
        return $this->boardRepo->create($request->all());
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
        DB::table('boards')->where('id', $board_id)->update(['is_disabled' => 1]);
        DB::table('user_boards')
            ->where('board_id', $board_id)
            ->where('user_id', $user_id)
            ->delete();
    }

    /**
     * Display the boards that have param user id
     * The relationship shown in table user_board
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function getUserBoards($user_id)
    {
        $boards_id = DB::table('user_boards')
            ->select('board_id')
            ->where('user_id', $user_id)
            ->get();
        $boardAmount = sizeof($boards_id);
        for ($i = 0; $i < $boardAmount; $i++) {
            $boards_id[$i] = $boards_id[$i]->board_id;
        }
        $result = DB::table('boards')
            ->whereIn('id', $boards_id)->get();
        return BoardResource::collection($result);
    }
}
