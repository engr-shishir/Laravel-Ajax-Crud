<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;


class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.index');
    }

    public function allData()
    {
        $data = Teacher::orderBy('id','DESC')->get();
        return response()->json($data);
    }

    public function storeData(Request $request)
    {
        $request->validate([
          'name' => 'required',
          'title' => 'required',
          'institute' => 'required',
        ]);

       $data = Teacher::insert([
           'name' => $request->name,
           'title' => $request->title,
           'institute' => $request->institute,
       ]);

       return response()->json($data);
    }



    public function editData($id)
    {
      $data = Teacher::findOrFail($id);
      return response()->json($data);
    }

    
    public function updateData(Request $request, $id)
    {
        $request->validate([
          'name' => 'required',
          'title' => 'required',
          'institute' => 'required',
        ]);

        $data = Teacher::findOrFail($id)->update([
            'name' => $request->name,
            'title' => $request->title,
            'institute' => $request->institute,
        ]);
 
        return response()->json($data);
    }



    public function deleteData($id)
    {
      $teacher = Teacher::findOrFail($id);
      $teacher->delete();
      return response()->json(['success'=>'Delete rtecord Successfully']);
    }
}
