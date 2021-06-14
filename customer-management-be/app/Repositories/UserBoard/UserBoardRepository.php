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
}
