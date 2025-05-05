<?php

namespace App\Livewire;

use App\Models\ChatDetalle;
use App\Models\ChatHeader;
use App\Models\LevelQuestionOption;
use App\Models\LevelQuestion;
use App\Models\PersonLevelQuestionOption;
use App\Models\Level;
use App\Models\Person;
use Auth;
use DB;
use Livewire\Component;

class LevelComponent extends Component
{
    public $level = 1;
    public $lastLevel = 1;
    public $person_selecionado = 0;
    public $respuestas = [];
    public $validacionNivel = '';
    public $message = '';
    public $verPreguntas = false;

    public function seeQuestion()
    {
        $this->verPreguntas = true;

        // Refrescar el video
        $this->dispatch('cargarVideo');
    }

    public function chooseOption($levelId, $questionId, $optionId)
    {
        $existeSeleccion = PersonLevelQuestionOption::where('person_id', $this->person_selecionado)
            ->where('level_id', $levelId)
            ->where('level_question_id', $questionId)
            ->exists();

        if ($existeSeleccion) {
            $seleccion = PersonLevelQuestionOption::where('person_id', $this->person_selecionado)
                ->where('level_id', $levelId)
                ->where('level_question_id', $questionId)
                ->first();
        } else {
            $seleccion = new PersonLevelQuestionOption();
            $seleccion->person_id = $this->person_selecionado;
            $seleccion->level_id = $levelId;
            $seleccion->level_question_id = $questionId;
        }
        $seleccion->level_question_option_id = $optionId;
        $seleccion->save();
    }

    public function sendQuestion()
    {
        // Validar todas las respuestas selecionadas
        $totalPreguntasNivel = LevelQuestion::where('level_id', $this->level)->count();
        $totalPreguntasRespondidasNivel = PersonLevelQuestionOption::where('level_id', $this->level)->where('person_id', $this->person_selecionado)->count();
        if ($totalPreguntasNivel !== $totalPreguntasRespondidasNivel) {
            $this->validacionNivel = 'Se debe responder a todas las preguntas';

            $this->dispatch('show-swal-alert', [
                'title' => '¡Ups!',
                'text' => 'Se debe responder a todas las preguntas.',
                'icon' => 'error', // Puedes usar: 'success', 'error', 'warning', 'info', etc.
                'timer' => 3000,
            ]);


            return false;
        }

        // Validar que que cumpla con el minimo del nivel
        $contadorRespuestasCorrectas = 0;
        $respuestasPersonas = PersonLevelQuestionOption::where('level_id', $this->level)->where('person_id', $this->person_selecionado)->get();
        foreach ($respuestasPersonas as $key => $respu) {
            if (LevelQuestionOption::find($respu->level_question_option_id)->correct) {
                $contadorRespuestasCorrectas++;
            }
        }

        // Calificacion minima del nivel
        $minimoAciertos = Level::find($this->level)->minim_calification;
        if (intval($minimoAciertos) <= intval($contadorRespuestasCorrectas)) {
            // validar si nivel existe
            $nivelNuevo = $this->level + 1;
            if (Level::where('id', $nivelNuevo)->exists()) {
                // $this->verPreguntas = false;
                // $this->level = ($this->level+1);
                // $this->validacionNivel = '';
                return redirect('/levels/' . $this->person_selecionado);
            } else {
                return redirect('/certificado-final/' . $this->person_selecionado);
            }
        } else {
            $this->validacionNivel = 'La cantidad mínima de aciertos es: ' . $minimoAciertos . ' y tus aciertos son: ' . $contadorRespuestasCorrectas;
            $this->verPreguntas = false;

            $this->dispatch('show-swal-alert', [
                'title' => '¡Ups!',
                'text' => 'La cantidad mínima de aciertos es: ' . $minimoAciertos . ' y tus aciertos son: ' . $contadorRespuestasCorrectas,
                'icon' => 'error', // Puedes usar: 'success', 'error', 'warning', 'info', etc.
                'timer' => 3000,
            ]);

            // Refrescar el video
            $this->dispatch('cargarVideo');

            return false;
        }
    }

    public function estadoNivel($nivelId, $personaId)
    {
        $contadorRespuestasCorrectas = 0;
        $respuestasPersonas = PersonLevelQuestionOption::where('level_id', $nivelId)->where('person_id', $personaId)->get();
        foreach ($respuestasPersonas as $key => $respu) {
            if (LevelQuestionOption::find($respu->level_question_option_id)->correct) {
                $contadorRespuestasCorrectas++;
            }
        }

        $minimoAciertos = Level::find($this->level)->minim_calification;
        if (intval($minimoAciertos) <= intval($contadorRespuestasCorrectas)) {
            return true;
        } else {
            return false;
        }
    }

    public function enviarMensaje()
    {
        // Varificar si tiene chat Abiertos y tomar el primero o crear
        if (ChatHeader::where('user_id', Auth::user()->id)->where('estado', 'ABIERTO')->exists()) {
            $chatHeader = ChatHeader::where('user_id', Auth::user()->id)->where('estado', 'ABIERTO')->first();
        } else {
            $chatHeader = new ChatHeader();
            $chatHeader->user_id = Auth::user()->id;
            $chatHeader->estado = 'ABIERTO';
            $chatHeader->save();
        }

        // Captar en mensaje y guardar
        $chatDetalle = new ChatDetalle();
        $chatDetalle->chat_header_id = $chatHeader->id;
        $chatDetalle->mensaje = $this->message;
        $chatDetalle->bot = false;
        $chatDetalle->save();

        // Simular respuesta del bot
        $chatDetalleBot = new ChatDetalle();
        $chatDetalleBot->chat_header_id = $chatHeader->id;
        $chatDetalleBot->mensaje = "PONG";
        $chatDetalleBot->bot = true;
        $chatDetalleBot->save();

        $this->message = '';
    }

    public function mount($personId)
    {
        $this->person_selecionado = $personId;

        // Determinar el nivel en el que se encuentra
        $todosNiveles = Level::get()->pluck('id');
        foreach ($todosNiveles as $key => $nivel) {
            $estadoNivel = $this->estadoNivel($nivel, $this->person_selecionado);
            if (!$estadoNivel) {
                $this->level = $nivel;
                break;
            } else {
                $this->lastLevel = $nivel;
            }
        }

        // Verificar si esta en el ultimo nivel
        if (count($todosNiveles) == $this->lastLevel) {
            // Redirigir a certificado
            return redirect('/certificado-final/' . $this->person_selecionado);
        }
    }

    public function render()
    {
        $person = Person::find($this->person_selecionado);
        $levelsCompleted = Level::with('questions.options')->find($this->level);

        // Determinar opciones ya seleccionadas
        foreach ($levelsCompleted->questions as $question) {
            $resExiste = PersonLevelQuestionOption::where('person_id', $this->person_selecionado)
                ->where('level_id', $question->level_id)
                ->where('level_question_id', $question->id)
                ->exists();

            if ($resExiste) {
                $res = PersonLevelQuestionOption::where('person_id', $this->person_selecionado)
                    ->where('level_id', $question->level_id)
                    ->where('level_question_id', $question->id)
                    ->first();

                $this->respuestas[$question->id] = [
                    'option' => $res->level_question_option_id
                ];
            } else {
                $this->respuestas[$question->id] = [
                    'option' => null
                ];
            }
        }

        // $chat = ChatDetalle::
        // Calcula puntos
        $historial = DB::table('chat_detalle')
            ->select([
                'chat_detalle.mensaje',
                'chat_detalle.bot',
                'chat_detalle.created_at',
            ])
            ->leftJoin('chat_header', 'chat_detalle.chat_header_id', '=', 'chat_header.id')
            ->where('chat_header.estado', 'ABIERTO')
            ->where('chat_header.user_id', Auth::user()->id)
            ->orderBy('chat_detalle.created_at', 'asc')
            ->get();


        return view('livewire.level-component', compact('levelsCompleted', 'person', 'historial'));
    }
}
