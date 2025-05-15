<?php

namespace App\Livewire\TipoEncuesta;

use App\Models\tipo_encuesta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $tipoId = null;
    public $nombreTipoEncuesta = '';
    public $estado = true;

    protected $rules = [
        'nombreTipoEncuesta' => 'required|string|max:255',
        'estado' => 'boolean',
    ];

    public function edit($id)
    {
        $tipo = tipo_encuesta::findOrFail($id);
        $this->tipoId = $tipo->id;
        $this->nombreTipoEncuesta = $tipo->nombreTipoEncuesta;
        $this->estado = (bool)$tipo->estado;
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            
            $this->validate();

            tipo_encuesta::updateOrCreate(
                ['id' => $this->tipoId],
                [
                    'nombreTipoEncuesta' => $this->nombreTipoEncuesta,
                    'estado' => $this->estado,
                ]
            );

            $this->reset(['tipoId', 'nombreTipoEncuesta', 'estado']);

            session()->flash('success', 'Guardado correctamente');

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' .  $th->getMessage());
        }
    }

    public function render()
    {
        $tipos = tipo_encuesta::paginate(10);

        return view('livewire.tipo-encuesta.index', [
            'tipos' => $tipos,
        ]);
    }
}
