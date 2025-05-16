<?php

namespace App\Livewire\TipoCita;

use App\Models\TipoCita;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $tipoId = null;
    public $nombreTipoCita;
    public $estadoTipoCita = true;

    protected $rules = [
        'nombreTipoCita' => 'required|string|max:100',
        'estadoTipoCita' => 'boolean',
    ];

    public function edit($id)
    {
        $tipo = TipoCita::findOrFail($id);
        $this->tipoId = $tipo->id;
        $this->nombreTipoCita = $tipo->nombreTipoCita;
        $this->estadoTipoCita = (bool)$tipo->estadoTipoCita;
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            
            $this->validate();

            TipoCita::updateOrCreate(
                ['id' => $this->tipoId],
                [
                    'nombreTipoCita' => $this->nombreTipoCita,
                    'estadoTipoCita' => $this->estadoTipoCita,
                ]
            );

            $this->reset(['tipoId', 'nombreTipoCita', 'estadoTipoCita']);

            session()->flash('success', 'Guardado correctamente');

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' .  $th->getMessage());
        }
    }

    public function render()
    {
        $tipoCitas = TipoCita::paginate(10);

        return view('livewire.tipo-cita.index', [
            'tipoCitas' => $tipoCitas
        ]);
    }
}
