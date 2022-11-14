<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tags extends Controller
{
    public function getAllTags()
    {
        return response(json_encode(\App\Models\tags::all()));
    }

    public function createTag(Request $request)
    {
        $request->validate([
            'name'=>['required'],
        ]);
        $name=$request['name'];
        $count=\App\Models\tags::where('tag_name',$name)->count();
        if($count>0)
        {
            return response('Tags have to be unique, the tag you enter is duplicate.',403);
        }
        $tag=new \App\Models\tags();
        $tag->tag_name=$name;
        $tag->save();
        return response('Tag created successfully.',200);
    }

    public function updateTag(Request $request)
    {
        $request->validate([
           'oldName'=>['required'],
           'newName'=>['required']
        ]);
        $oldName=$request['oldName'];
        $newName=$request['newName'];



        if($oldName==$newName)
        {return response('The tag name you entered is the same as the old one.',403);}
        $count=\App\Models\tags::where('tag_name',$newName)->count();
        if($count>0)
        {
            return response('Tags have to be unique, the tag you entered is duplicate.',403);
        }
        $tag=\App\Models\tags::where('tag_name',$oldName)->first();

        $tag->tag_name=$newName;
        $tag->save();

        return response($oldName.' tag updated successfully.',200);
    }
    public function deleteTag(Request $request)
    {
        $request->validate([
            'name'=>['required'],
        ]);
        $name=$request['name'];
        $tag=\App\Models\tags::where('tag_name',$name)->first();
        if ($tag==null)
            return response('Tag not found, please make sure that you entered the right name.');
        $tag->delete();

        return response($name.' tag deleted successfully.',200);
    }
}
