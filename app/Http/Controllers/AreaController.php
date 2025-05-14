<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index()
    {
        return view('area.index');
    }

    public function create()
    {
        return view('area.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombreArea' => 'required|string|max:100',
            'estado'     => 'nullable|boolean',
        ]);
        $data['estado'] = $request->has('estado');
        Area::create($data);

        return redirect()->route('area.index')
                         ->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('area.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'nombreArea' => 'required|string|max:100',
            'estado'     => 'nullable|boolean',
        ]);
        $data['estado'] = $request->has('estado');
        $area->update($data);

        return redirect()->route('area.index')
                         ->with('success', 'Área actualizada.');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return back()->with('success', 'Área eliminada.');
    }
}
