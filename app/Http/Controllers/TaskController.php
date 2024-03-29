<?php

namespace App\Http\Controllers;
use datatables;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        if(request()->ajax()){
            return datatables()->of(Task::select('*'))
            ->addColumn('action','take-actions')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function store(Request $request){
        $taskId = $request->id;
        $task = Task::updateOrCreate(
            ['id'=>$taskId],
            ['task'=>$request->task]
        );
        return Response()->json($task);
    }

    public function edit(Request $request){
        $where = array('id'=>$request->id);
        $task = Task::where($where)->first();
        return Response()->json($task);
    }

    public function delete(Request $request){
        $task = Task::where('id',$request->id)->delete();
        return Response()->json($task);
    }
    // public function store2(Request $request){
    //     $employeeId = $request->id;

    //     $employee = Task::updateOrCreate(
    //         ['id' => $employeeId],
    //         [
    //             'task' => $request->task
    //         ]
    //         );
    //     return Response()->json($employee);
    // }
}
