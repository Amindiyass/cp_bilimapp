<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreProgressRequest;
use App\Models\Video;

class VideoController extends BaseController
{
    public function storeProgress(Video $video, StoreProgressRequest $request)
    {
        $video->completedRate()->updateOrCreate(['user_id' => auth()->id()],
            [
                'rate' => $request->input('rate')
            ]
        );
        return $this->sendResponse($video->completed_rate);
    }
}
