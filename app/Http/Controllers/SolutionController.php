<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Problems;
use App\Solutions;

use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $problems = Problems::where('slug','=',$slug)->first();
        $solutions = Solutions::where('problems_id','=',$problems->id)->orderBy('created_at','asc')->get();
        return view('problems.solutions.show')->with('problems',$problems)->with('solutions',$solutions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        if(Auth::guest()){
            return redirect('/problems')->with('error', 'Unauthorized Page');
        }
        $problems = Problems::where('slug','=',$slug)->first();
        return view('problems.solutions.create')->with('problems',$problems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $problems = Problems::where('slug','=',$slug)->first();
        $solutions = new Solutions;
        $solutions->problems_id = $problems->id;
        $solutions->user_id = Auth::user()->id;
        $solutions->content = $request->input('content');
        $solutions->save();
        return redirect('/problems')->with('success', 'Solution Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/problems');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, $id)
    {
        $problems = Problems::where('slug','=',$slug)->first();
        $solutions = Solutions::find($id);
        if(Auth::guest() || (Auth::user()->authentication < 1 && Auth::user()->authentication != $solutions->user_id)){
            return redirect('/problems')->with('error', 'Unauthorized Page');
        }
        return view('problems.solutions.edit')->with('problems',$problems)->with('solutions',$solutions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $solutions = Solutions::find($id);
        $solutions->content = $request->input('content');
        $solutions->save();
        return redirect('/problems')->with('success', 'Solution Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $solutions = Solutions::find($id);
        $solutions->delete();
        return redirect('/problems')->with('success', 'Solution Removed');
    }
}
