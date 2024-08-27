<?php

namespace App\Http\Controllers;

use App\Models\Masterebook;
use Illuminate\Http\Request;

class MasterebookController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterebook = Masterebook::where('judul', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterebook = Masterebook::paginate(10);
        }
        return view('masterebook.index',[
            'masterebook' => $masterebook
        ]);
    }


    public function create()
    {
        return view('masterebook.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
{
    // Validasi permintaan
    $request->validate([
        'cover' => 'nullable|file|mimes:jpg,jpeg,png',
        'filebuku' => 'file|mimes:pdf',
    ]);

    $data = masterebook::create($request->all());
    if($request->hasFile('cover')) {
        $request->file('cover')->move('coverebook/', $request->file('cover')->getClientOriginalName());
        $data->cover = $request->file('cover')->getClientOriginalName();
        $data->save();
    }

    // Menangani file buku jika ada
    if($request->hasFile('filebuku')) {
        $request->file('filebuku')->move('filebuku/', $request->file('filebuku')->getClientOriginalName());
        $data->filebuku = $request->file('filebuku')->getClientOriginalName();
        $data->save();
    }

    // Simpan perubahan pada entri
    $data->save();

    // Redirect dengan pesan sukses
    return redirect()->route('masterebook.index')->with('success', 'Data telah ditambahkan');
}


    public function show($id)
    {

    }


    public function edit(Masterebook $masterebook)
    {
        return view('masterebook.edit', [
            'item' => $masterebook
        ]);
    }


    public function update(Request $request, masterebook $masterebook)
    {
        $data = $request->all();

        $masterebook->update($data);

        //dd($data);

        return redirect()->route('masterebook.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Masterebook $masterebook)
    {
        $masterebook->delete();
        return redirect()->route('masterebook.index')->with('success', 'Data Telah dihapus');
    }
}
