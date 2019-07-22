<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
        $files = Files::orderBy('name','asc')->paginate(20);
        return view('files.index')->with('files',$files);
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
        return view('files.create');
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
            'fileName' => 'max:100',
            'added_file' => 'required|max:20000'
        ]);
        //Filename with extension
        $fileNamewithExt = $request->file('added_file')->getClientOriginalName();
        $fileName = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
        if($request->filename != "") $fileName = $request->filename;
        $extension = $request->file('added_file')->getClientOriginalExtension();
        $fileNameToStore = time() . $fileName . '.' . $extension;
        //Upload file
        $path = $request->file('added_file')->storeAs('public/materials',$fileNameToStore);
        $file = new Files;
        $file->name = $fileName;
        $file->filename = $fileNameToStore;
        $file->save();
        return redirect('/files')->with('success', 'File Added');
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
    public function edit($id)
    {
        return redirect('/files');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Files::find($id);
        if(file_exists(public_path('storage/materials/'.$file->filename))) {
            @unlink(public_path('storage/materials/'. $file->filename));
            $file->delete();
        }
        return redirect('/files')->with('success','File Deleted');
    }
}
