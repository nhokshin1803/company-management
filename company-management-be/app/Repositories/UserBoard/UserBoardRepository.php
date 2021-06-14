<?php

namespace App\Repositories\UserBoard;

use App\Repositories\BaseRepository;

class UserBoardRepository extends BaseRepository implements UserBoardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\UserBoard::class;
    }

    /**
     * Delete the records that depend on user id and board id.
     *
     * @param  int  $user_id
     * @param  int  $board_id
     * @return boolean
     */
    public function relationshipDelete($user_id, $board_id)
    {
        $result = DB::table('user_boards')->where('user_id', '=', $user_id)->where('board_id', '=', $board_id)->first();
        if ($result->delete()) {
            return true;
        }
        return false;
    }
}
