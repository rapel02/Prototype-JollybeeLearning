<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Materials;
use App\Topics;
use App\Material_Topic_Relation;
use App\Problems;
use App\Problem_Topic_Relation;
use App\Material_Problem_Relation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $req)
    {
        if(Arr::exists($req,'title') == false ) {
            $req->title = '';
        }
        $materials = Materials::where('title','like','%'.$req->title.'%')->orderBy('difficulty','asc')->get();
        $topics = Topics::all();
        return view('materials.index')->with('materials',$materials)->with('topics',$topics);
    }

    public function tags(Request $req,$slug)
    {
        if(Arr::exists($req,'title') == false ) {
            $req->title = '';
        }
        $user_difficulty = 5;
        $topic = Topics::where('slug','=',$slug)->first();
        if(!Auth::guest()) $user_difficulty = Auth::user()->level;
        $user_difficulty = ($user_difficulty/10 + 1) * 10 - 1;    
        $materials = Materials::where('title','like',$req->title.'%')->whereIn('id', Material_Topic_Relation::select('material_id')->where('topic_id','=',$topic->id))->get();
        $topics = Topics::all();
        return view('materials.tags')->with('materials',$materials)->with('topics',$topics)->with('choosentopic_slug',$slug)->with('choosentopic_title',$topic->title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/materials')->with('error', 'Unauthorized Page');
        }
        $topics = Topics::all();
        return view('materials.create')->with('topics',$topics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:materials',
            'topics' => 'required',
            'difficulty' => 'required|between:1,29',
            'content' => 'required'
        ]);
        //Create post
        $material = new Materials;
        $material->title = $request->input('title');
        $material->difficulty = $request->input('difficulty');
        $material->content = $request->input('content');
        $material->slug = str_slug($request->input('title'));
        $material->save();
        //Create Tags
        if(count($request->input('topics')) > 0) {
            foreach($request->input('topics') as $tag) {
                $materialTopicRelation = new Material_Topic_Relation;
                $materialTopicRelation->material_id = $material->id;
                $materialTopicRelation->topic_id = $tag;
                $materialTopicRelation->save();
            }
        }
        return $this->createproblem($material->id,$request->input('topics'));
    }

    public function createproblem($id,$req) {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/materials')->with('error', 'Unauthorized Page');
        }
        $problems = Problems::whereIn('id', Problem_Topic_Relation::select('problem_id')->whereIn('topic_id',$req))->get();
        return view('materials.addproblem')->with('id',$id)->with('problems',$problems);
    }

    public function storeproblem(Request $request, $id)
    {
        //Create post
        if(Arr::exists($request,'prob') == true ) {
            foreach($request->input('prob') as $prob) {
                $materialProblemRelation = new Material_Problem_Relation;
                $materialProblemRelation->problem_id = $prob;
                $materialProblemRelation->material_id = $id;
                $materialProblemRelation->save();
            }
        }
        $material = Materials::find($id);
        return redirect('/materials')->with('success', $material->title . ' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $materials = Materials::where('slug','=',$slug)->first();
        return view('materials.show')->with('materials',$materials);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //Check authentication
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/materials')->with('error', 'Unauthorized Page');
        }
        $materials = Materials::where('slug','=',$slug)->first();
        $topics = Topics::all();
        $relation = Material_Topic_Relation::where('material_id','=',$materials->id)->get();
        return view('materials.edit')->with('materials',$materials)->with('topics',$topics)->with('relation',$relation);
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
            'topics' => 'required',
            'difficulty' => 'required|between:1,29',
            'content' => 'required'
        ]);
        $tags = array();
        if(count($request->input('topics')) > 0) {
            foreach($request->input('topics') as $tag) {
                $tags[] = $tag;
            }
        }
        $material = Materials::find($id);
        $material->title = $request->input('title');
        $material->difficulty = $request->input('difficulty');
        $material->content = $request->input('content');
        $material->slug = str_slug($request->input('title'));
        $material->save();
        $materialTopicRelations = DB::delete('delete from material__topic__relations where material_id = ?', [$material->id]);
        if(count($request->input('topics')) > 0) {
            foreach($request->input('topics') as $tag) {
                $materialTopicRelation = new Material_Topic_Relation;
                $materialTopicRelation->material_id = $material->id;
                $materialTopicRelation->topic_id = $tag;
                $materialTopicRelation->save();
            }
        }
        return $this->editproblem($material->id,$request->input('topics'));
    }

    public function editproblem($id,$req) {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/materials')->with('error', 'Unauthorized Page');
        }
        $problems = Problems::whereIn('id', Problem_Topic_Relation::select('problem_id')->whereIn('topic_id',$req))->get();
        $relation = Material_Problem_Relation::where('material_id','=',$id)->get();
        return view('materials.editproblem')->with('id',$id)->with('problems',$problems)->with('relation',$relation);
    }

    public function updateproblem(Request $request, $id)
    {
        $problemTopicRelations = DB::delete('delete from material__problem__relations where material_id = ?', [$id]);
        if(Arr::exists($request,'prob') == true ) {
            foreach($request->input('prob') as $prob) {
                $materialProblemRelation = new Material_Problem_Relation;
                $materialProblemRelation->problem_id = $prob;
                $materialProblemRelation->material_id = $id;
                $materialProblemRelation->save();
            }
        }
        $material = Materials::find($id);
        return redirect('/materials')->with('success', $material->title . ' edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materialTopicRelations = DB::delete('delete from material__topic__relations where material_id = ?', [$id]);
        $materialProblemRelations = DB::delete('delete from material__problem__relations where material_id = ?', [$id]);
        $materials = Materials::find($id);
        $title = $materials->title;
        $materials->delete();
        return redirect('/materials')->with('success', $title. ' deleted');
    }
}
