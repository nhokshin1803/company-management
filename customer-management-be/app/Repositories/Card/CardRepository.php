<?php

namespace App\Repositories\Card;

use App\Repositories\BaseRepository;

class CardRepository extends BaseRepository implements CardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Card::class;
    }
}
