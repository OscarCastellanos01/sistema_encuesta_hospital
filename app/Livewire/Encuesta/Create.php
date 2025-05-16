<?php

namespace App\Livewire\Encuesta;

use App\Models\Area;
use App\Models\Encuesta;
use App\Models\EncuestaPregunta;
use App\Models\tipo_encuesta;
use App\Models\TipoCita;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $tituloEncuesta;
    public $descripcionEncuesta;
    public $idArea;
    public $idTipoEncuesta;
    public $idTipoCita;

    public array $questions = [
        [
            'titulo' => '', 
            'estado' => true
        ],
    ];

    protected function rules(): array
    {
        return [
            'tituloEncuesta' => 'required|string|max:255',
            'descripcionEncuesta' => 'nullable|string',
            'idArea' => 'required|exists:area,id',
            'idTipoEncuesta' => 'required|exists:tipo_encuesta,id',
            'idTipoCita' => 'required|exists:tipo_cita,id',
            'questions' => 'required|array|min:1',
            'questions.*.titulo' => 'required|string|max:255',
            'questions.*.estado' => 'boolean',
        ];
    }

    public function addQuestion(): void
    {
        $this->questions[] = [
            'titulo' => '', 
            'estado' => true
        ];
    }

    public function removeQuestion(int $idx): void
    {
        if (count($this->questions) > 1) {
            array_splice($this->questions, $idx, 1);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $lastId = Encuesta::max('id') + 1;
            $codigo = 'EN-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

            $encuesta = Encuesta::create([
                'codigoEncuesta' => $codigo,
                'tituloEncuesta' => $this->tituloEncuesta,
                'descripcionEncuesta' => $this->descripcionEncuesta,
                'estadoEncuesta' => 1,
                'idArea' => $this->idArea,
                'idTipoEncuesta' => $this->idTipoEncuesta,
                'idTipoCita' => $this->idTipoCita,
                'idUser' => 1,
            ]);

            foreach ($this->questions as $q) {
                EncuestaPregunta::create([
                    'idEncuesta' => $encuesta->id,
                    'tituloPregunta' => $q['titulo'],
                    'estadoPregunta' => $q['estado'] ? 1 : 0,
                ]);
            }

            DB::commit();

            session()->flash('success', 'Encuesta creada correctamente');
            $this->reset();

        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Error al crear encuesta: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $areas = Area::orderBy('nombreArea')->where('estado', 1)->get();
        $tiposEncuesta = tipo_encuesta::orderBy('nombreTipoEncuesta')->where('estado', 1)->get();
        $tiposCita = TipoCita::orderBy('nombreTipoCita')->where('estadoTipoCita', 1)->get();

        return view('livewire.encuesta.create', [
            'areas' => $areas,
            'tiposEncuesta' => $tiposEncuesta,
            'tiposCita' => $tiposCita,
        ]);
    }
}
