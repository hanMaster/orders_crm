<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\User;
use Illuminate\Http\Request;

class BuildObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $starters = User::where('role_id', 1)->get();
        $approves = User::where('role_id', 2)->get();
        return view('bo.create', compact(['starters', 'approves']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'approve_id' => 'required|numeric',
            'starter_id' => 'required|numeric',
        ]);

        BuildObject::create([
           'name'=> $request->name,
           'approve_id' => $request->approve_id,
           'starter_id' => $request->starter_id,
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\buildObject  $bo
     * @return \Illuminate\Http\Response
     */
    public function show(BuildObject $bo)
    {
        return view('bo.show', compact('bo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\buildObject  $bo
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildObject $bo)
    {
        $starters = User::where('role_id', 1)->get();
        $approves = User::where('role_id', 2)->get();
        return view('bo.edit', compact(['bo','starters', 'approves']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\buildObject  $bo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuildObject $bo)
    {
        $request->validate([
            'name' => 'required|min:2',
            'approve_id' => 'required',
            'starter_id' => 'required',
        ]);

        $bo->name = $request->name;
        $request->approve_id==='null' ? $bo->approve_id = NULL: $bo->approve_id = $request->approve_id;
        $request->starter_id==='null' ? $bo->starter_id = NULL: $bo->starter_id = $request->starter_id;

        $bo->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\buildObject  $bo
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildObject $bo)
    {
        //
    }
}
