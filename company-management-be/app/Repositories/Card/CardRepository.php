<?php

namespace App\Repositories\Card;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CardResource;

class CardRepository extends BaseRepository implements CardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Card::class;
    }

    public function getByConditions($other, $other_value)
    {
        /**
         * Get card data from database
         * Sort by postion asc
         * @param string $other
         * @param mixed $other_value
         * @return \Illuminate\Http\Response
         */
        $result = DB::table('cards')
            ->where('is_disabled', 0)
            ->where($other, $other_value)
            ->orderBy('position', 'asc')
            ->get();
        return CardResource::collection($result);
    }
}
