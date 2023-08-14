<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\qualification;
use Illuminate\Http\Request;

class qualificationController extends Controller
{
    public function index()
    {
        $users = qualification::all();
        return view('qualification.index', compact('users'));
    }

    public function create()
    {
        return view('qualification.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'TopicID' => 'required',
            'InstructorID' => 'required',
        ]);
        // dd($data);
        qualification::create($data);

        return redirect()->route('qualification.index')->with('success', 'Data staff berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = qualification::findOrFail($id);
        return view('qualification.edit' , compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'TopicID' => 'required',
            'InstructorID' => 'required',
        ]);
        qualification::where('id',$id)->update($data);

        return redirect()->route('qualification.index')->with('success', 'Data qualification berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = qualification::findOrFail($id);
        $user->where('id',$user->id)->delete();

        return redirect()->route('qualification.index')->with('success', 'Data qualification berhasil dihapus.');
    }
}
