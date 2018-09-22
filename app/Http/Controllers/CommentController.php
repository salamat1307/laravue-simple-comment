<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function getIndex()
    {
    	$comments = Comment::with('user')->orderByDesc('id')->get();
    	return response()->json(['comments' => $comments]);
    }

    public function postDelete($id)
    {
    	$comment = Comment::find($id);
    	if ($comment) {
    		$comment->delete();
    		return response(null, 204);
    	}
    }

    public function postComment()
    {
		$data = request()->only('text');

		$rules = [
			'text' => 'required'
		];

		$validator = validator()->make($data, $rules);

		if($validator->fails()) {
			return response()->json([				
				'messages' => $validator->messages()
			]);
		} else {
			$data['user_id'] = auth()->user()->id;
			$comment = Comment::create($data);
			$comment = $comment->load('user');

			return response()->json([				
				'comment' => $comment 
			]);
		}
    }

    public function postUpdate($id)
    {
    	$data = request()->only('text');

    	$rules = [
    		'text' => 'required'
    	];

    	$validator = validator()->make($data, $rules);

    	if($validator->fails()) {
    		return response()->json([
    			'message' => $validator->messages()
    		]);
    	} else {
    		$comment = Comment::find($id);

    		if($comment) {
    			$comment->update($data);
    		}

    		$comment = $comment->load('user');

    		return response()->json(['comment' => $comment]);
    	}
    }
}
