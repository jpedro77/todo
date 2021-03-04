<?php

namespace App\Http\Controllers;

use App\Models\TodoPriority;
use Illuminate\Http\Request;

class TodoPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todoPriorities = TodoPriority::all();
        return response()->json($todoPriorities);
    }

    public function paginate()
    {
        return TodoPriority::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        $data = [
            'name' => $name,
        ];

        $todoPriority = TodoPriority::create($data);

        return response()->json($todoPriority);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todoPriority = TodoPriority::find($id);
        return response()->json($todoPriority);
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
        $name = $request->input('name');

        $todoPriority = TodoPriority::find($id);
        $todoPriority->name = $name;
        $todoPriority->save();

        return response()->json($todoPriority);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return TodoPriority::destroy($id);
    }
}
