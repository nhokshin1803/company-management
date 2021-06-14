<?php

namespace App\Repositories\List;

use App\Repositories\BaseRepository;

class ListRepository extends BaseRepository implements ListRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ListCard::class;
    }

}
