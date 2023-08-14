<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $users = Instructor::all();
        return view('Instructor.index', compact('users'));
    }

    public function create()
    {
        return view('Instructor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'InstructorName' => 'required',
            'Age' => 'required',
            'Gender' => 'required',
            'ExpYear' => 'required',
            'ExpDesc' => 'required',
        ]);
    
        if ($request->hasFile('gambar_Instructor')) {
            $gambarInstructor = $request->file('gambar_Instructor')->store('public/gambar_Instructor');
            $data['gambar_Instructor'] = $gambarInstructor;
        }
        // dd($data);
        Instructor::create($data);

        return redirect()->route('Instructor.index')->with('success', 'Data staff berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Instructor::findOrFail($id);
        return view('Instructor.edit' , compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'InstructorName' => 'required',
            'Age' => 'required',
            'Gender' => 'required',
            'ExpYear' => 'required',
            'ExpDesc' => 'required',
        ]);
    
        if ($request->hasFile('gambar_Instructor')) {
            $gambarInstructor = $request->file('gambar_Instructor')->store('public/gambar_Instructor');
            $data['gambar_Instructor'] = $gambarInstructor;
        }
        Instructor::where('id',$id)->update($data);

        return redirect()->route('Instructor.index')->with('success', 'Data Instructor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Instructor::findOrFail($id);
        $user->where('id',$user->id)->delete();

        return redirect()->route('Instructor.index')->with('success', 'Data Instructor berhasil dihapus.');
    }
}
