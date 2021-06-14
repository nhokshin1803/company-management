<?php

namespace App\Repositories\Board;

use App\Repositories\BaseRepository;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Board::class;
    }
}
