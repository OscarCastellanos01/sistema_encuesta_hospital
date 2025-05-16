<?php

namespace App\Livewire\Encuesta;

use App\Models\Encuesta;
use App\Models\EncuestaPregunta;
use App\Models\EncuestaRespuesta;
use App\Models\EncuestaRespuestaDetalle;
use App\Models\Especialidad;
use App\Models\nivel_satisfaccion;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public $encuesta;
    public $especialidad;
    public $edadPaciente;
    public $sexoPaciente;
    public array $answers = [];
    public bool $terms = false;
    
    protected function rules(): array
    {
        $rules = [
            'especialidad' => 'required',
            'edadPaciente' => 'required|integer|min:0',
            'sexoPaciente' => 'required|in:1,2',
            'terms'        => 'accepted',
        ];

        // Obtengo los IDs de las preguntas de esta encuesta
        $preguntaIds = EncuestaPregunta::query()
            ->where('idEncuesta', $this->encuesta->id)
            ->where('estadoPregunta', 1)
            ->pluck('id');

        foreach ($preguntaIds as $pid) {
            $rules["answers.{$pid}"] = 'required';
        }

        return $rules;
    }

    public function mount(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    public function toggleAnswer(int $preguntaId, int $nivel): void
    {
        // Si ya está seleccionado lo quitamos
        if (
            isset($this->answers[$preguntaId]) &&
            $this->answers[$preguntaId] === $nivel
        ) {
            unset($this->answers[$preguntaId]);
        } else {
            // Si no esta seleccionado lo asignamos
            $this->answers[$preguntaId] = $nivel;
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $ultimaEmision = EncuestaRespuesta::max('id') + 1;

            $encuestaRespuesta = EncuestaRespuesta::create([
                'codigoEncuestaRespuesta' => 'ER-' . str_pad($ultimaEmision, 5, '0', STR_PAD_LEFT),
                'idEncuesta' => $this->encuesta->id,
                'idFacilitador' => 1,
                'idEspecialidad' => $this->especialidad,
                'edadPaciente' => $this->edadPaciente,
                'sexoPaciente' => $this->sexoPaciente
            ]);

            $detalleRespuesta = [];

            foreach ($this->answers as $preguntaId => $nivel)
            {
                $detalleRespuesta[] = [
                    'idEncuestaRespuesta' => $encuestaRespuesta->id,
                    'idPregunta' => $preguntaId,
                    'idNivelSatisfaccion' => $nivel,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            EncuestaRespuestaDetalle::insert($detalleRespuesta);

            $this->resetForm();
            session()->flash('success', 'Guardado correctamente');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' .  $th->getMessage());
        }
    }
    
    public function resetForm()
    {
        $this->reset(['answers', 'terms', 'especialidad', 'edadPaciente', 'sexoPaciente']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $preguntas = EncuestaPregunta::where([
            'idEncuesta'      => $this->encuesta->id,
            'estadoPregunta'  => 1,
        ])->get();

        $satisfactions = nivel_satisfaccion::all();

        $especialidades = Especialidad::all();

        return view('livewire.encuesta.view', [
            'preguntas' => $preguntas,
            'satisfactions' => $satisfactions,
            'especialidades' => $especialidades,
        ]);
    }
}
