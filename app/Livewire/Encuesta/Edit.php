<?php

namespace App\Livewire\Encuesta;

use App\Models\Area;
use App\Models\Encuesta;
use App\Models\EncuestaPregunta;
use App\Models\TipoCita;
use App\Models\tipo_encuesta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public Encuesta $encuesta;

    public $tituloEncuesta;
    public $descripcionEncuesta;
    public $idArea;
    public $idTipoEncuesta;
    public $idTipoCita;

    public array $questions = [];

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
            'questions.*.tipoPregunta' => 'required|string|in:texto,numero,select,nivel_satisfaccion,fecha,hora,fecha_hora',
            'questions.*.opciones' => 'nullable|array',
            'questions.*.opciones.*.valor' => 'required_with:questions.*.opciones|string',
            'questions.*.opciones.*.etiqueta' => 'required_with:questions.*.opciones|string',
        ];
    }

    public function mount(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
        $this->tituloEncuesta = $encuesta->tituloEncuesta;
        $this->descripcionEncuesta = $encuesta->descripcionEncuesta;
        $this->idArea = $encuesta->idArea;
        $this->idTipoEncuesta = $encuesta->idTipoEncuesta;
        $this->idTipoCita = $encuesta->idTipoCita;

        $this->questions = $encuesta->preguntas()->with('opciones')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'titulo' => $p->tituloPregunta,
                'estado' => (bool) $p->estadoPregunta,
                'tipoPregunta' => $p->tipoPregunta,
                'opciones' => $p->tipoPregunta === 'select'
                    ? $p->opciones->map(fn($o) => ['valor' => $o->valor, 'etiqueta' => $o->etiqueta])->toArray()
                    : [],
            ];
        })->toArray();
    }

    public function addQuestion(): void
    {
        $this->questions[] = [
            'id' => null,
            'titulo' => '',
            'estado' => true,
            'tipoPregunta' => 'nivel_satisfaccion',
            'opciones' => [],
        ];
    }

    public function addOption($idx)
    {
        if (!isset($this->questions[$idx]['opciones'])) {
            $this->questions[$idx]['opciones'] = [];
        }

        $this->questions[$idx]['opciones'][] = [
            'valor' => Str::uuid()->toString(),
            'etiqueta' => '',
        ];
    }

    public function removeOption($preguntaIdx, $opcionIdx)
    {
        if (isset($this->questions[$preguntaIdx]['opciones'][$opcionIdx])) {
            unset($this->questions[$preguntaIdx]['opciones'][$opcionIdx]);
            $this->questions[$preguntaIdx]['opciones'] = array_values($this->questions[$preguntaIdx]['opciones']);
        }
    }
    
    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction(); 

            $this->encuesta->update([
                'tituloEncuesta' => $this->tituloEncuesta,
                'descripcionEncuesta' => $this->descripcionEncuesta,
                'idArea' => $this->idArea,
                'idTipoEncuesta' => $this->idTipoEncuesta,
                'idTipoCita' => $this->idTipoCita,
            ]);

            $existingIds = collect($this->questions)
                ->pluck('id')
                ->filter()
                ->all();

            EncuestaPregunta::where('idEncuesta', $this->encuesta->id)
                ->whereNotIn('id', $existingIds)
                ->delete();

            foreach ($this->questions as $q) {
                if ($q['id']) {
                    $pregunta = EncuestaPregunta::find($q['id']);
                    $pregunta->update([
                        'tituloPregunta' => $q['titulo'],
                        'estadoPregunta' => $q['estado'] ? 1 : 0,
                        'tipoPregunta'   => $q['tipoPregunta'],
                    ]);
                    if ($q['tipoPregunta'] === 'select') {
                        $pregunta->opciones()->delete();
                        foreach ($q['opciones'] as $opt) {
                            $pregunta->opciones()->create([
                                'valor' => $opt['valor'],
                                'etiqueta' => $opt['etiqueta'],
                            ]);
                        }
                    }
                } else {
                    $pregunta = EncuestaPregunta::create([
                        'idEncuesta' => $this->encuesta->id,
                        'tituloPregunta' => $q['titulo'],
                        'estadoPregunta' => $q['estado'] ? 1 : 0,
                        'tipoPregunta' => $q['tipoPregunta'],
                    ]);
                
                    if ($q['tipoPregunta'] === 'select') {
                        foreach ($q['opciones'] as $opt) {
                            $pregunta->opciones()->create([
                                'valor' => $opt['valor'],
                                'etiqueta' => $opt['etiqueta'],
                            ]);
                        }
                    }
                }                
            }

            DB::commit();
            session()->flash('success', 'Encuesta actualizada correctamente');

            return to_route('encuesta.edit', $this->encuesta->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar: '.$e->getMessage());
        }
    }

    public function render() 
    {
        $areas = Area::orderBy('nombreArea')->where('estado', 1)->get();
        $tiposEncuesta = tipo_encuesta::orderBy('nombreTipoEncuesta')->where('estado', 1)->get();
        $tiposCita = TipoCita::orderBy('nombreTipoCita')->where('estadoTipoCita', 1)->get();

        return view('livewire.encuesta.edit', [
            'areas' => $areas,
            'tiposEncuesta' => $tiposEncuesta,
            'tiposCita' => $tiposCita,
        ]);
    }
}
