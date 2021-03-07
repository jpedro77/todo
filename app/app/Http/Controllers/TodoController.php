<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Redirect;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);

    }

    public function paginate()
    {
        return Todo::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $id_user = $request->input('id_user');
        $id_todo_priority = $request->input('id_todo_priority');
        $deadline_at = $request->input('deadline');

        $data = [
            'title' => $title,
            'description' => $description,
            'id_user' => $id_user,
            'id_todo_priority' => $id_todo_priority,
            'deadline_at' => $deadline_at,
            'completed_at' => date("Y-m-d h:i:s")
        ];

        $todo = Todo::create($data);

        return Redirect::to('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json($todo);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $id_user = $request->input('id_user');
        $id_todo_priority = $request->input('id_todo_priority');
        $deadline_at = $request->input('deadline_at');
        $completed_at = $request->input('completed_at');

        $todo = Todo::find($id);
        $todo->title = $title;
        $todo->description = $description;
        $todo->id_user = $id_user;
        $todo->id_todo_priority = $id_todo_priority;
        $todo->deadline_at = $deadline_at;
        $todo->completed_at = $completed_at;

        $todo->save();

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Todo::destroy($id);
    }
}
