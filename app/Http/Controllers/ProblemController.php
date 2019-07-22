<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Problems;
use App\Topics;
use App\Solutions;
use App\Problem_Topic_Relation;
use App\Material_Problem_Relation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if(Arr::exists($req,'onlinejudge') == false && Arr::exists($req,'problemid') == false && Arr::exists($req,'title') == false ) {
            $req->onlinejudge = '';
            $req->problemid = '';
            $req->title = '';
        }
        $user_difficulty = 5;
        if(!Auth::guest()) $user_difficulty = Auth::user()->level;
        $user_difficulty = ($user_difficulty/10 + 1) * 10 - 1;    
        $problems = Problems::where('difficulty','<=',$user_difficulty)->where('problemid','like','%'.$req->problemid.'%')->where('title','like','%'.$req->title.'%')->where('onlinejudge','like','%'.$req->onlinejudge.'%')->sortable()->paginate(20);
        $topics = Topics::all();
        return view('problems.index')->with('problems',$problems)->with('topics',$topics);
    }

    public function tags(Request $req,$slug)
    {
        if(Arr::exists($req,'onlinejudge') == false && Arr::exists($req,'problemid') == false && Arr::exists($req,'title') == false ) {
            $req->onlinejudge = '';
            $req->problemid = '';
            $req->title = '';
        }
        $user_difficulty = 5;
        $topic = Topics::where('slug','=',$slug)->first();
        if(!Auth::guest()) $user_difficulty = Auth::user()->level;
        $user_difficulty = ($user_difficulty/10 + 1) * 10 - 1;
        $problems = Problems::where('difficulty','<=',$user_difficulty)->where('problemid','like',$req->problemid.'%')->where('title','like',$req->title.'%')->where('onlinejudge','like','%'.$req->onlinejudge.'%')->whereIn('id', Problem_Topic_Relation::select('problem_id')->where('topic_id','=',$topic->id))->sortable()->paginate(20);
        $topics = Topics::all();
        return view('problems.tags')->with('problems',$problems)->with('topics',$topics)->with('choosentopic_slug',$slug)->with('choosentopic_title',$topic->title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/problems')->with('error', 'Unauthorized Page');
        }
        $topics = Topics::all();
        return view('problems.create')->with('topics',$topics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function searchProblem($OJ, $problemid) {
        //Check for UVA OJ
        $result = (object) [
            'link' => '',
            'title' => ''
        ];
        if($OJ == 'UVA') {
            $lenid = strlen($problemid);
            for($i = 0;$i < $lenid;$i++) {
                if($problemid[$i] < '0' || $problemid[$i] > '9') return $result;
            }
            //Fetch json from problem
            $json = file_get_contents('https://uhunt.onlinejudge.org/api/p/num/'.$problemid);
            //Check whether problem exist or not
            if(count(json_decode($json,true)) != 22) return $result;
            $obj = json_decode($json);
            $result->link = 'https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem='. $obj->pid;
            $result->title = $obj->title;
        }
        //Check for CodeforcesOJ
        else if($OJ == 'Codeforces') {
            //Parsing Problem ID
            $contestId = '';
            $index = '';
            $lenproblemid = strlen($problemid);
            for($x = 0; $x < $lenproblemid - 1; $x++) {
                $contestId = $contestId . $problemid[$x];
            }
            if($problemid[$lenproblemid - 1] == '0') $problemid[$lenproblemid - 1] = 'A';
            $problemid[$lenproblemid - 1] = strtoupper($problemid[$lenproblemid - 1]);
            $index = $problemid[$lenproblemid - 1];

            //Get problem link
            $link = 'https://codeforces.com/problemset/problem/'.$contestId.'/'.$index;

            //Check whether problem exists or not
            $findtitle = '<title>Codeforces</title>';
            $content = file_get_contents($link);
            $pos = strpos($content,$findtitle);
            if($pos != false) return $result; 

            //Parse title
            $lencontent = strlen($content);
            $find = 'class="title">';
            $pos = strpos($content, $find);
            $title = "";
            for($i = $pos + strlen($find) + 3; $i != $lencontent && $content[$i] != '<';$i++) {
                $title = $title . $content[$i];
            }
            $result->link = $link;
            $result->title = $title;
        }
        //Check for SPOJ
        else if($OJ == 'SPOJ') {
            $lenproblemid = strlen($problemid);
            for($x = 0; $x < $lenproblemid; $x++) {
                $problemid[$x] = strtoupper($problemid[$x]);
            }
            //Get problem link
            $link = 'https://www.spoj.com/problems/'.$problemid.'/';
            //Check whether problem exists or not
            $findtitle = 'SPOJ.com - Problem ';
            $content = file_get_contents($link);
            $pos = strpos($content,$findtitle);
            if($pos == false) return $result; 

            //Parse title
            $lencontent = strlen($content);
            $find = '<h2 id="problem-name" class="text-center">' .$problemid.' - ';
            $pos = strpos($content, $find);
            $title = "";
            for($i = $pos + strlen($find); $i != $lencontent && $content[$i] != '<';$i++) {
                $title = $title . $content[$i];
            }
            $result->link = $link;
            $result->title = $title;
        }
        else if($OJ == 'Kattis') {
            $lenproblemid = strlen($problemid);
            for($x = 0; $x < $lenproblemid; $x++) {
                $problemid[$x] = strtolower($problemid[$x]);
            }
            //Get problem link
            $link = 'https://open.kattis.com/problems/'.$problemid;
            //Check whether problem exists or not
            $findtitle = $problemid;
            $content = file_get_contents($link);
            $pos = strpos($content,$findtitle);
            if($pos == false) return $result; 

            //Parse title
            $lencontent = strlen($content);
            $find = '<h1>';
            $pos = strpos($content, $find);
            $title = "";
            for($i = $pos + strlen($find); $i != $lencontent && $content[$i] != '<';$i++) {
                $title = $title . $content[$i];
            }
            $result->link = $link;
            $result->title = $title;
        }
        return $result;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'onlinejudge' => 'required',
            'problemid' => 'required',
            'difficulty' => 'required|integer|between:1,29'
        ]);
        //Check if Problem already exists or not
        $problems = Problems::all();
        foreach($problems as $problem){
            if($problem->onlinejudge == $request->input('onlinejudge') && $problem->problemid == $request->input('problemid')) return redirect('/problems/create')->with('error', 'Problem Exists');
        }

        //Check Connection
        $connected = @fsockopen("www.example.com", 80); 
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
            return redirect('/problems')->with('error', 'Connection Problem');
        }

        $search = $this->searchProblem($request->input('onlinejudge'),$request->input('problemid'));
        if($search->title == '') return redirect('/problems')->with('error', 'Problem not Exists');
        //Create Problems
        
        $problem = new Problems;
        $problem->onlinejudge = $request->input('onlinejudge');
        $problem->problemid = $request->input('problemid');
        $problem->difficulty = $request->input('difficulty');
        $problem->title = $search->title;
        $problem->link = $search->link;
        $slug = $request->input('onlinejudge') . ' '.$request->input('problemid');
        $problem->slug = str_slug($slug);
        $problem->save();
        //Create Tags
        if(count($request->input('tags')) > 0) {
            foreach($request->input('tags') as $tag) {
                $problemTopicRelation = new Problem_Topic_Relation;
                $problemTopicRelation->problem_id = $problem->id;
                $problemTopicRelation->topic_id = $tag;
                $problemTopicRelation->save();
            }
        }
        return redirect('/problems')->with('success', $problem->onlinejudge . '-' . $problem->problemid . ' ' . $problem->title . ' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
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
            return redirect('/problems')->with('error', 'Unauthorized Page');
        }
        $problems = Problems::where('slug','=',$slug)->first();
        $topics = Topics::all();
        $relation = Problem_Topic_Relation::where('problem_id','=',$problems->id)->get();
        return view('problems.edit')->with('problems',$problems)->with('relation',$relation)->with('topics',$topics);
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
            'onlinejudge' => 'required',
            'problemid' => 'required',
            'difficulty' => 'required|integer|between:1,29'
        ]);
        //Edit Problems
        $problems = Problems::all();
        foreach($problems as $problem){
            if($problem->id == $id) continue;
            if($problem->onlinejudge == $request->input('onlinejudge') && $problem->problemid == $request->input('problemid')) return redirect('/problems/create')->with('error', 'Problem Exists');
        }

        $problem = Problems::find($id);
        if($request->input('onlinejudge') != $problem->onlinejudge || $request->input('problemid') != $problem->problemid) {
            //Check connection
            $connected = @fsockopen("www.example.com", 80); 
            if ($connected){
                $is_conn = true; //action when connected
                fclose($connected);
            }else{
                $is_conn = false; //action in connection failure
                return redirect('/problems')->with('error', 'Connection Problem');
            }

            $search = $this->searchProblem($request->input('onlinejudge'),$request->input('problemid'));
            if($search->title == '') return redirect('/problems')->with('error', 'Problem not Exists');
            $problem->title = $search->title;
            $problem->link = $search->link;
        }
        $problem->onlinejudge = $request->input('onlinejudge');
        $problem->problemid = $request->input('problemid');
        $problem->difficulty = $request->input('difficulty');
        $slug = $request->input('onlinejudge') . ' '.$request->input('problemid');
        $problem->slug = str_slug($slug);
        $problem->save();
        $problemTopicRelations = DB::delete('delete from problem__topic__relations where problem_id = ?', [$problem->id]);
        if(count($request->input('tags')) > 0) {
            foreach($request->input('tags') as $tag) {
                $problemTopicRelation = new Problem_Topic_Relation;
                $problemTopicRelation->problem_id = $problem->id;
                $problemTopicRelation->topic_id = $tag;
                $problemTopicRelation->save();
            }
        }
        return redirect('/problems')->with('success', $problem->onlinejudge . '-' . $problem->problemid . ' ' . $problem->title . ' edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solutions = Solutions::where('problems_id','=',$id)->get();
        foreach($solutions as $solution) {
            $solution->delete();
        }
        $problemTopicRelations = DB::delete('delete from problem__topic__relations where problem_id = ?', [$id]);
        $materialProblemRelation = DB::delete('delete from material__problem__relations where problem_id = ?',[$id]);
        $problem = Problems::find($id);
        $onlinejudge = $problem->onlinejudge;
        $problemid = $problem->problemid;
        $title = $problem->title;
        $problem->delete();
        return redirect('/problems')->with('success', $onlinejudge . '-' . $problemid . ' ' . $title . ' deleted');
    }
}
