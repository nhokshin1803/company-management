<?php

namespace App\Repositories\Board;

use App\Repositories\BaseRepository;
use App\Models\Board;
use App\Models\UserBoard;
use App\Http\Resources\BoardResource;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Board::class;
    }

    /**
     * Create a board and a relationship between it and user
     * @param $attributes
     * @param $user_id
     * @return mixed
     */
    public function createBoard($attributes, $user_id)
    {
        if (isset($attributes['id'])) {
            unset($attributes['id']);
        }
        $result = $this->model->create($attributes);
        $board_id = $this->model
            ->where('name', $attributes['name'])
            ->latest()->first()->id;
        UserBoard::create(['user_id' => $user_id, 'board_id' => $board_id]);
        return $result;
    }

    /**
     * Soft delete a board and delete the relationship (user - board)
     * @param $user_id
     * @param $board_id
     * @return mixed
     */
    public function softDelete($user_id, $board_id)
    {
        $result = $this->model->find($board_id)->update(["is_disabled" => 1]);
        UserBoard::where('user_id', $user_id)->where('board_id', $board_id)->delete();
        return $result;
    }

    /**
     * Get all boards that user have
     * @param $user_id
     * @return mixed
     */
    public function getBoards($user_id)
    {
        $boards_id = UserBoard::where('user_id', $user_id)->get('board_id');
        $boardAmount = sizeof($boards_id);
        for ($i = 0; $i < $boardAmount; $i++) {
            $boards_id[$i] = $boards_id[$i]->board_id;
        }
        $result = $this->model
            ->whereIn('id', $boards_id)->get();
        return BoardResource::collection($result);
    }
}
