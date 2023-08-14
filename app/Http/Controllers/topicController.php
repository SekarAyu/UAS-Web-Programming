<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\topic;
use Illuminate\Http\Request;

class topicController extends Controller
{
    public function index()
    {
        $users = topic::all();
        return view('topic.index', compact('users'));
    }

    public function create()
    {
        return view('topic.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'TopicName' => 'required',
            'TopicDesc' => 'required',
        ]);
    
        topic::create($data);

        return redirect()->route('topic.index')->with('success', 'Data staff berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = topic::findOrFail($id);
        return view('topic.edit' , compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'TopicName' => 'required',
            'TopicDesc' => 'required',
        ]);
    
        topic::where('id',$id)->update($data);

        return redirect()->route('topic.index')->with('success', 'Data topic berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = topic::findOrFail($id);
        $user->where('id',$user->id)->delete();

        return redirect()->route('topic.index')->with('success', 'Data topic berhasil dihapus.');
    }
}
