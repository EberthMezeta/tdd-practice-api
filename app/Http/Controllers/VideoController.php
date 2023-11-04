<?php

namespace App\Http\Controllers;

use App\Dtos\VideoPreview;
use App\Http\Requests\ListOfVideosRequest;
use App\Models\Video;
use Illuminate\Http\Request;


class VideoController extends Controller
{
    public function getVideo($id)
    {
        return Video::find($id);
    }

    public function getVideos(ListOfVideosRequest $request)
    {
        $offset = ($request->getPage() - 1) * $request->getLimit();
        return Video::limit($request->getLimit())->offset($offset)->orderBy('created_at', 'DESC')->get()->mapInto(VideoPreview::class);
    }
}
