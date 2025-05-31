<?php

namespace App\Livewire\Especialidad;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Especialidad;

class Index extends Component
{
     use WithPagination;

    public $nombreEspecialidad = '';
    public $estadoEspecialidad = true;
    public $especialidadId = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nombreEspecialidad' => 'required|string|max:100',
        'estadoEspecialidad'             => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        if ($this->especialidadId) {
            Especialidad::find($this->especialidadId)
                ->update([
                    'nombreEspecialidad' => $this->nombreEspecialidad,
                    'estadoEspecialidad'             => $this->estadoEspecialidad,
                ]);
            session()->flash('message', 'Especialidad actualizada.');
        } else {
            Especialidad::create([
                'nombreEspecialidad' => $this->nombreEspecialidad,
                'estadoEspecialidad'             => $this->estadoEspecialidad,
            ]);
            
            session()->flash('message', 'Especialidad creada.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $e = Especialidad::findOrFail($id);
        $this->especialidadId    = $id;
        $this->nombreEspecialidad = $e->nombreEspecialidad;
        $this->estadoEspecialidad             = (bool)$e->estadoEspecialidad;
    }

    private function resetForm()
    {
        $this->nombreEspecialidad = '';
        $this->estadoEspecialidad = true;
        $this->especialidadId = null;
    }

    public function render()
    {
        $items = Especialidad::orderBy('id','desc')->paginate(10);

        return view('livewire.especialidad.index', [
            'items' => $items,
        ]);
    }
}
