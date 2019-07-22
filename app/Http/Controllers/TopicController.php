<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topics;
use App\Materials;
use App\Problems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $topics = Topics::all();
        $materials = Materials::orderBy('difficulty','asc')->get();
        return view('topics.index')->with('topics',$topics)->with('materials',$materials);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|unique:topics'
        ]);
        $topic = new Topics();
        $topic->title = $request->input('title');
        $topic->slug = str_slug($request->input('title'));
        $topic->save();
        return redirect('/topics')->with('success','Topic Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $topics = Topics::where('slug','=',$slug)->first();
        return view('topics.edit')->with('topics',$topics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $topic = Topics::find($id);
        $topic->title = $request->input('title');
        $topic->slug = str_slug($request->input('title'));
        $topic->save();
        return redirect('/topics')->with('success', 'Topic Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topics::find($id);
        $materialTopicRelations = DB::delete('delete from material__topic__relations where topic_id = ?', [$id]);
        $problemTopicRelations = DB::delete('delete from problem__topic__relations where topic_id = ?', [$id]);
        $topic->delete();
        return redirect('/topics')->with('success', 'Topics Removed');
    }
}
