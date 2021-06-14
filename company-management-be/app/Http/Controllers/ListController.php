<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreListRequest;
use App\Repositories\List\ListRepositoryInterface;
use App\Http\Resources\ListResource;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    protected $listRepo;

    public function __construct(ListRepositoryInterface $listRepo)
    {
        $this->listRepo = $listRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ListResource::collection($this->listRepo->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListRequest $request)
    {
        return $this->listRepo->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ListResource::collection($this->listRepo->find($id));
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
        return $this->listRepo->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('list_cards')->where('id', $id)->update(['is_disabled' => 1]);
    }

    /**
     * Display resource those have board_id equal to param board_id.
     *
     * @param  $board_id
     * @return \Illuminate\Http\Response
     */
    public function search($board_id)
    {
        return ListResource::collection($this->listRepo->getByConditions('board_id', $board_id));
    }
}
