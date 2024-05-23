<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\TaskModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getTasks(){
        $task = TaskModel::all();// take data from database
        $data = TaskResource::collection($task); // and than we need to cook and after cook already it drop to variable $data 
        return response()->json([// and than it return to client 
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function addTask(Request $request){
        // check validation data from client
        $request->validate([ 
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:task',
            'address' => 'required',

        ]);

        // call function create from model to json form
        TaskModel::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // return success after create
        return response()->json([
            'status' => 200,
            'message' => 'Task added successfully',
        ]);
    }

    public function getTaskId(Request $request, $id){
        $task = TaskModel::find($id);
        if(!empty($task)){
            $data = TaskResource::make($task);
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Task not found',
            ]);
        }
    }

    public function updateTask(Request $request, $id){

        $task = TaskModel::find($id);// take data from database by id 
        $task->update([ // add data that we wanna update it store in variable $task and we take to update
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Task updated successfully',
            'data' => TaskResource::make($task),
        ]);
    }

    public function deleteTask(Request $request, $id){
        $task = TaskModel::find($id);
        $task->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Task deleted successfully',
        ]);
    }
}
