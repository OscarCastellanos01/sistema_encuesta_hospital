<?php

namespace App\Livewire\Area;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nombreArea = '';
    public $estado = true;
    public $area_id = null;
    public $perPage = 10;
    public $search = '';

    protected $paginationTheme = 'tailwind';
    protected $rules = [
        'nombreArea' => 'required|string|max:100',
        'estado'     => 'boolean',
    ];

    // Resetea paginación cuando cambias la búsqueda
    public function updatedSearch() { $this->resetPage(); }

    // Cuando haces clic en “Crear” (o editar), llenamos el formulario
    public function edit($id)
    {
        $area = Area::findOrFail($id);
        $this->area_id = $id;
        $this->nombreArea = $area->nombreArea;
        $this->estado     = $area->estado;
    }

    // Guarda nueva área
    public function store()
    {
        $this->validate();
        Area::create([
            'nombreArea' => $this->nombreArea,
            'estado'     => $this->estado,
        ]);
        session()->flash('message', 'Área creada.');
        $this->resetForm();
    }

    // Actualiza existente
    public function update()
    {
        $this->validate();
        Area::find($this->area_id)
            ->update([
                'nombreArea' => $this->nombreArea,
                'estado'     => $this->estado,
            ]);
        session()->flash('message', 'Área actualizada.');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->nombreArea = '';
        $this->estado     = true;
        $this->area_id    = null;
    }

    public function render()
    {
        $areas = Area::query()
            ->when($this->search, fn($q) => $q->where('nombreArea','like','%'.$this->search.'%'))
            ->orderBy('id','desc')
            ->paginate($this->perPage);

        return view('livewire.area.index', ['areas' => $areas]);
    }
}
