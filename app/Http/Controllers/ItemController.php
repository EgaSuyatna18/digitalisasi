<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;

class ItemController extends Controller
{
    function index() {
        $title = config('app.name') . ' | Item';
        $items = Item::paginate(9);
        return view('dashboard.item', compact('title', 'items'));
    }

    function getQr($id) {
        return QrCode::size(120)->generate(config('app.url') . '/get_item/' . $id);
    }

    function store(Request $request) {
        $validated = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|min:3|max:50|unique:items',
            'info' => 'required|string|not_regex:/[\'"]/'
        ]);

        $validated['id'] = (string) Str::uuid();
        $validated['foto'] = $request->file('foto')->store('foto-item'); 

        Item::create($validated);

        return redirect(route('item_index'))->with('success', 'Berhasil Menambah item.');
    }

    function destroy(Item $item) {
        Storage::delete($item->foto);
        $item->delete();
        return redirect(route('item_index'))->with('success', 'Berhasil menghapus item.');
    }

    function update(Item $item, Request $request) {
        $rules = [
            'nama' => 'required|string|min:3|max:50',
            'info' => 'required|string|not_regex:/[\'"]/',
        ];

        if($request->file('foto')) $rules['foto'] = 'required|image|mimes:jpeg,png,jpg|max:2048';

        $validated = $request->validate($rules);

        if($request->file('foto')) {
            Storage::delete($item->foto);
            $validated['foto'] = $request->file('foto')->store('foto-item');
        }

        $item->update($validated);

        return redirect(route('item_index'))->with('success', 'Berhasil mengubah item.');
    }

    function getItem(Item $item) {
        $title = config('app.name') . ' | Info: ' . $item->nama;
        return view('dashboard.get_item', compact('title', 'item'));
    }

    function search($key) {
        $title = config('app.name') . ' | Item';
        $items = Item::where('nama', 'like', "%$key%")->paginate(9);
        return view('dashboard.item', compact('title', 'items'));
    }
}
