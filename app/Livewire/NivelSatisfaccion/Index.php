<?php

namespace App\Livewire\NivelSatisfaccion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Nivel_Satisfaccion;

class Index extends Component
{
    use WithPagination;

    public $nombreNivelSatisfaccion = '';
    public $selectedCodigo;
    public $estadoNivelSatisfaccion = true;
    public $satisfaccionId = null;

    public $options = [
        1 => ['label'=>'Muy insatisfecho', 'emoji'=>'😡'],
        2 => ['label'=>'Insatisfecho',      'emoji'=>'😔'],
        3 => ['label'=>'Neutral',           'emoji'=>'😐'],
        4 => ['label'=>'Satisfecho',        'emoji'=>'😊'],
        5 => ['label'=>'Muy satisfecho',    'emoji'=>'😁'],
    ];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nombreNivelSatisfaccion' =>'required|string|max:100',
        'selectedCodigo' => 'required|in:1,2,3,4,5',
        'estadoNivelSatisfaccion'             => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $ultimaEmision = Nivel_Satisfaccion::max('id') + 1;
        $data = [
            'codigoNivelSatisfaccion' => $this->selectedCodigo,
            'nombreNivelSatisfaccion' => $this->nombreNivelSatisfaccion,
            'emojiSatisfaccion'       => $this->options[$this->selectedCodigo]['emoji'],
            'estadoNivelSatisfaccion' => $this->estadoNivelSatisfaccion,
        ];

        if ($this->satisfaccionId) {
            Nivel_Satisfaccion::find($this->satisfaccionId)
                ->update($data);
            session()->flash('message', 'Nivel actualizado.');
        } else {
            Nivel_Satisfaccion::create($data);
            session()->flash('message', 'Nivel creado.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $nivel = Nivel_Satisfaccion::findOrFail($id);
        $this->satisfaccionId     = $id;
        $this->nombreNivelSatisfaccion =$nivel->nombreNivelSatisfaccion;
        $this->selectedCodigo   = $nivel->codigoNivelSatisfaccion;
        $this->estadoNivelSatisfaccion = (bool)$nivel->estadoNivelSatisfaccion;
    }

    private function resetForm()
    {
        $this->nombreNivelSatisfaccion = '';       
        $this->selectedCodigo          = null;
        $this->estadoNivelSatisfaccion = true;
        $this->satisfaccionId          = null;
    }

    public function render()
    {
        $niveles = Nivel_Satisfaccion::orderBy('id', 'desc')->paginate(10);

        return view('livewire.nivel-satisfaccion.index', [
            'niveles' => $niveles,
        ]);
    }
}
