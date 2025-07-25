<?php

namespace App\Livewire\Encuesta;

use App\Models\Encuesta;
use App\Models\EncuestaPregunta;
use App\Models\EncuestaRespuesta;
use App\Models\EncuestaRespuestaDetalle;
use App\Models\Especialidad;
use App\Models\nivel_satisfaccion;
use App\Models\RegistroFacilitador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public $encuesta;
    public $especialidad;
    public $edadPaciente;
    public $sexoPaciente;
    public array $answers = [];
    
    protected function rules(): array
    {
        $rules = [
            'especialidad' => 'required',
            'edadPaciente' => 'required|integer|min:0',
            'sexoPaciente' => 'required|in:1,2',
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
                'idFacilitador' => Auth::id(),
                'idEspecialidad' => $this->especialidad,
                'edadPaciente' => $this->edadPaciente,
                'sexoPaciente' => $this->sexoPaciente
            ]);

            $detalleRespuesta = [];

            foreach ($this->answers as $preguntaId => $valor)
            {
                // logger("Procesando -> preguntaId: " . $preguntaId . " | valor: " . json_encode($valor));
                $pregunta = EncuestaPregunta::find($preguntaId);
                $detalle = [
                    'idEncuestaRespuesta' => $encuestaRespuesta->id,
                    'idPregunta' => $preguntaId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $detalle['idNivelSatisfaccion'] = null;
                $detalle['respuestaTexto'] = null;
                $detalle['respuestaEntero'] = null;
                $detalle['respuestaFecha'] = null;
                $detalle['respuestaHora'] = null;
                $detalle['respuestaFechaHora'] = null;
                $detalle['respuestaOpcion'] = null;

                switch ($pregunta->tipoPregunta) {
                    case 'nivel_satisfaccion':
                        $detalle['idNivelSatisfaccion'] = $valor;
                        break;
                    case 'texto':
                        $detalle['respuestaTexto'] = $valor;
                        break;
                    case 'numero':
                        $detalle['respuestaEntero'] = intval($valor);
                        break;
                    case 'fecha':
                        $detalle['respuestaFecha'] = $valor;
                        break;
                    case 'hora':
                        $detalle['respuestaHora'] = $valor;
                        break;
                    case 'fecha_hora':
                        $detalle['respuestaFechaHora'] = $valor;
                        break;
                    case 'select':
                        $opcion = collect($pregunta->opciones)
                            ->firstWhere('valor', $valor);
                        $detalle['respuestaOpcion'] = $opcion ? $opcion->etiqueta : $valor;
                        break;
                }

                $detalleRespuesta[] = $detalle;
            }

            EncuestaRespuestaDetalle::insert($detalleRespuesta);

            RegistroFacilitador::create([
                'idUsuario' => Auth::id(),
                'idEncuesta' => $encuestaRespuesta->id
            ]);
            
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
        $this->reset(['answers', 'especialidad', 'edadPaciente', 'sexoPaciente']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $preguntas = EncuestaPregunta::where([
            'idEncuesta'      => $this->encuesta->id,
            'estadoPregunta'  => 1,
        ])->get();

        $satisfactions = nivel_satisfaccion::where('estadoNivelSatisfaccion', 1)->get();
        $especialidades = Especialidad::orderBy('nombreEspecialidad')->where('estadoEspecialidad', 1)->get();

        return view('livewire.encuesta.view', [
            'preguntas' => $preguntas,
            'satisfactions' => $satisfactions,
            'especialidades' => $especialidades,
        ]);
    }
}
