<?php

namespace App\Http\Controllers;

use App\Models\postsTags;
use Illuminate\Http\Request;

class posts extends Controller
{
    public function getUserPosts()
    {
        $posts=\App\Models\posts::where('user_id',auth()->id())->orderBy('pinned','desc')->get();
        return (json_encode($posts));
    }

    public  function createPost(Request $request)
    {
        $request->validate([
            'title'=>['required','max:255'],
            'body'=>['required','string'],
            'pinned'=>['required:boolean'],
            'cover'=>['required','image']
        ]);
        $post=new \App\Models\posts();
        $post->user_id=auth()->id();
        $post->title=$request['title'];
        $post->body=$request['body'];
        $post->pinned=$request['pinned'];
        $post->cover_img=$request->file('cover');
        $tags=$request['tags'];
        $post->save();
        if($tags!=null)
        {

            $Tags=\App\Models\tags::whereIn('tag_name',$tags)->select('id')->get();

            foreach ($Tags as $tag) {
                $postTag=new postsTags();
                $postTag->tag_id=$tag->id;
                $postTag->post_id=$post->id;
                $postTag->save();
                        }
        }
        return response('Post created successfully.');
    }
    public function getSinglePost(Request $request)
    {
        $id=$request['postId'];
        return (json_encode(\App\Models\posts::where('id',$id)->where('user_id',auth()->id())->first()));
    }

    public function deletePost(Request $request)
    {
        $id=$request['postId'];
        $post=\App\Models\posts::where('id',$id)->first();
        $post->delete();
        return response('Post deleted successfully.',200);
    }
    public function showDeletedPosts()
    {
        $posts=\App\Models\posts::withTrashed()->get();
        return (json_encode($posts));
    }
    public function restoreSingleDeletedPost(Request $request)
    {
        $id=$request['postId'];

        $post=\App\Models\posts::withTrashed()->find($id)->restore();
        return response('Post restored successfully.');
    }
    public function update(Request $request)
    {
//        dd($request);

        $request->validate([
            'title'=>['required','max:255'],
            'body'=>['required','string'],
            'pinned'=>['required:boolean'],
            'cover'=>['image']
        ]);
        $id=$request['postId'];
        $post= \App\Models\posts::find($id);
        $post->title=$request['title'];
        $post->body=$request['body'];
        $post->pinned=$request['pinned'];
        $post->cover_img=$request->file('cover');
        $tags=$request['tags'];
        if($tags!=null)
        {

            $Tags=\App\Models\tags::whereIn('tag_name',$tags)->select('id')->get();

            foreach ($Tags as $tag) {
                $postTag=new postsTags();
                $postTag->tag_id=$tag->id;
                $postTag->post_id=$post->id;
                $postTag->save();
            }
        }
        return response('Post updated successfully.');
    }

}
