<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::select([
                    'id',
                    'title',
                    'body',
                    DB::raw("CAST(posts.created_at AS DATE) as start"),
                    DB::raw("CAST(posts.updated_at AS DATE) as end"),
                ]);

            return Datatables::of($posts)
                ->filter(function ($query) use ($request) {
                    if ($request->has('start')) {
                        return $query->where('posts.created_at', '>=', $request->get('start'));
                    }
                    if ($request->has('end')) {
                        return $query->where('posts.updated_at', '<=', $request->get('end'));
                    }
                })
            ->make(true);
        }
    	return view('backend.post.index');
    }
}
