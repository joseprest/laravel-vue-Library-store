<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // all libraries
    public function index()
    {
        $libraries = Library::all()->toArray();
        return array_reverse($libraries);
    }

    // add library
    public function add(Request $request)
    {
        $library = new Library([
            'name' => $request->name
        ]);
        $library->save();

        return response()->json('The library successfully added');
    }

    // edit library
    public function edit($id)
    {
        $library = Library::with('books')->find($id);
        return response()->json($library);
    }

    // update library
    public function update($id, Request $request)
    {
        $library = Library::find($id);
        $library->update($request->all());

        return response()->json('The library successfully updated');
    }

    // delete library
    public function delete($id)
    {
        $library = Library::find($id);
        $library->delete();

        return response()->json('The library successfully deleted');
    }
}
