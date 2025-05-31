<?php

namespace App\Livewire\Area;

use App\Models\Area;
use App\Models\Bitacora;
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
        
        // Contar áreas existentes antes de crear la nueva
        $totalAreasAntes = Area::count();

        // Crear el área y guardar la instancia
        $area = Area::create([
            'nombreArea' => $this->nombreArea,
            'estado'     => $this->estado,
        ]);

        // Contar áreas después de la creación
        $totalAreasDespues = Area::count();

        // Registrar en bitácora(acción de creación: tipo 1)
        Bitacora::create([
            'idRegistro'   => $area->id, // ID del área recién creada
            'descripcion'  => "Creación de área. Nombre: {$this->nombreArea}, Nuevo estado: ".($this->estado != null ? '1' : '0'),
            'tipoAccion'   => 1, // 1 = Creación
            'idUsuario'    => auth()->id(),
            'created_at'   => now(),
            'updated_at'   => now(),
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

            
        // Registrar en bitácora (acción de actualización: tipo 2)
        Bitacora::create([
            'idRegistro'   => $this->area_id,     // ID del área actualizada
            'descripcion'  => "Actualización de área: {$this->nombreArea}, Nuevo estado: ".($this->estado != null ? '1' : '0'),
            'tipoAccion'   => 2,                  // 2 = Actualización
            'idUsuario'    => auth()->id(),       // ID del usuario autenticado
            'created_at'   => now(),
            'updated_at'   => now(),
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
