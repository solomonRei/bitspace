<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\UserRepository;
use App\Traits\Languages;

class ReviewService
{
    use Languages;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getCommentsAll($id, $count = 5)
    {
        return Review::where('user_id', $id)->paginate($count);
    }

    public function getCommentsLast($count = 6)
    {
        $data = [];
        if ($reviews = Review::approved()->limit($count)->get()){
            foreach ($reviews as $review) {
                if ($review->userStrings()->first() !== null && $usersStrings = $review->userStrings()->first()->getUsersString($this->getLangId(), $review->user_id))
                    $data[] = [
                        'review' => $review,
                        'usersString' => ($review->userStrings()->first() !== null && $review->userStrings()->first()->getUsersString($this->getLangId(), $review->user_id)) ? $usersStrings : null
                    ];
            }
        }
        return $data;
    }
}
