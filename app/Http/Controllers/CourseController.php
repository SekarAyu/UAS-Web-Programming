<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $users = Course::all();
        return view('course.index', compact('users'));
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'CourseName' => 'required',
            'Price' => 'required',
            'Days' => 'required',
            'IsCertificate' => 'required',
            'IsActive' => 'required',
        ]);
    
        if ($request->hasFile('gambar_course')) {
            $gambarcourse = $request->file('gambar_course')->store('public/gambar_course');
            $data['gambar_course'] = $gambarcourse;
        }
        // dd($data);
        Course::create($data);

        return redirect()->route('course.index')->with('success', 'Data staff berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Course::findOrFail($id);
        return view('course.edit' , compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'CourseName' => 'required',
            'Price' => 'required',
            'Days' => 'required',
            'IsCertificate' => 'required',
            'IsActive' => 'required',
        ]);
    
        if ($request->hasFile('gambar_course')) {
            $gambarcourse = $request->file('gambar_course')->store('public/gambar_course');
            $data['gambar_course'] = $gambarcourse;
        }
        Course::where('id',$id)->update($data);

        return redirect()->route('course.index')->with('success', 'Data course berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Course::findOrFail($id);
        $user->where('id',$user->id)->delete();

        return redirect()->route('course.index')->with('success', 'Data course berhasil dihapus.');
    }
}
