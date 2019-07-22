<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Materials;
use App\Topics;
use App\Problems;
use App\Solutions;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest() || Auth::user()->level < 10) {
            $materials = Materials::where('difficulty','<',10)->orderBy('updated_at','desc')->take(5)->get();
            $topics = Topics::all();
            $problems = Problems::where('difficulty','<',10)->orderBy('created_at','desc')->take(5)->get();
            $solutions = Solutions::whereIn('problems_id',Problems::select('id')->where('difficulty','<',10))->orderBy('created_at','desc')->take(5)->get();
            return view('pages.pages')->with('materials',$materials)->with('topics',$topics)->with('problems',$problems)->with('solutions',$solutions);
        }
        else if(Auth::user()->level < 20) {
            $materials = Materials::where('difficulty','<',20)->orderBy('updated_at','desc')->take(5)->get();
            $topics = Topics::all();
            $problems = Problems::where('difficulty','<',20)->orderBy('created_at','desc')->take(5)->get();
            $solutions = Solutions::whereIn('problems_id',Problems::select('id')->where('difficulty','<',20))->orderBy('created_at','desc')->take(5)->get();
            return view('pages.pages')->with('materials',$materials)->with('topics',$topics)->with('problems',$problems)->with('solutions',$solutions);
        }
        else {
            $materials = Materials::orderBy('updated_at','desc')->take(5)->get();
            $topics = Topics::all();
            $problems = Problems::orderBy('created_at','desc')->take(5)->get();
            $solutions = Solutions::orderBy('created_at','desc')->take(5)->get();
            return view('pages.pages')->with('materials',$materials)->with('topics',$topics)->with('problems',$problems)->with('solutions',$solutions);        
        }
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
