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
    public function destroy($id)
    {
        //
        $this->boardRepo->delete($id);
    }

    public function searchByBoardId($id) {
        return BoardResource::collection($this->boardRepo->getByConditions('id', $id));
    }

    public function last() {
        return new BoardResource($this->boardRepo->last());
    }
}
