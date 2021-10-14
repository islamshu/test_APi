<?php

namespace App\Http\Controllers\Api;

use App\Subscribe;
use Validator ;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class SubscribeController extends BaseController
{
    
    public function supscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'url' => 'required|url',
        ]);
    
        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        $subscribe = Subscribe::where('email',$request->email)->where('url',$request->url)->first();
        if($subscribe){
            return $this->sendError('you have already subscribed');
        }
        $subscribe = new Subscribe();
        $subscribe->email = $request->email;
        $subscribe->url = $request->url;
        $subscribe->save();
        return $this->sendResponse('success',$subscribe);


    }
    
}
