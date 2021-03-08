<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todoList = Todo::with('user')->get();
        return response()->json($todoList);

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
        $data = $request->all();

        // validar os dados
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'user_id' => 'required|exists:App\Models\User,id',
            'todo_priority_id' => 'required|exists:App\Models\TodoPriority,id',
            'deadline_at' => 'required|date'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        // armazenar os dados
        $todo = Todo::create($data);

        return [response()->json($todo)];
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
        $user_id = $request->input('user_id');
        $todo_priority_id = $request->input('todo_priority_id');
        $deadline_at = $request->input('deadline');

        $todo = Todo::find($id);
        $todo->title = $title;
        $todo->description = $description;
        $todo->user_id = $user_id;
        $todo->todo_priority_id = $todo_priority_id;
        $todo->deadline_at = $deadline_at;

        $todo->save();

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function conclude(Request $request, $id)
    {
        $completed_at = $request->input('completed_at');

        $todo = Todo::find($id);
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
