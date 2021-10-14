<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendMail as JobsSendMail;
use App\Mail\SendMail;
use App\Post;
use Illuminate\Http\Request;
use App\Subscribe;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\BaseController;
use Validator;
class PostController extends BaseController
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'url' => 'required|url',
        ]);
    
        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        $post = new Post();
        $post ->title = $request->title;
        $post->body = $request->body;
        $post->url = $request->url;
        $post->save();
        $subscribes = Subscribe::where('url',$post->url)->chunk(50,function($data) use ($post){
      

            dispatch(new JobsSendMail($data,$post));
        });
      
        return $this->sendResponse('success', 'created post successfuly');

        

        }
    
}
