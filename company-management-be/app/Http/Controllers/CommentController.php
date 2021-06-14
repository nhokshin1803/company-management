<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CommentResource::collection($this->commentRepo->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        return $this->commentRepo->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CommentResource::collection($this->commentRepo->find($id));
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
        return $this->commentRepo->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('comments')->where('id', $id)->update(['is_disabled' => 1]);
    }

    /**
     * Display resource those have card_id equal to param card_id.
     *
     * @param  int $card_id
     * @return \Illuminate\Http\Response
     */
    public function search($card_id)
    {
       return CommentResource::collection($this->commentRepo->getByConditions('card_id', $card_id));
    }
}
