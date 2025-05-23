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
use Http;
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
    public $notificaciones = 0;
    public bool $sendingMessage = true;


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

        // Verficar si esta equivocado
        $option = LevelQuestionOption::find($optionId);
        if (!$option->correct) {
            $this->notificaciones = $this->notificaciones + 1;
            // dd('te quivocaste' . $total);
            $this->recomendarRevision($questionId);
        }
    }

    public function abrirModal()
    {
        // Aqui enceramos las notificaciones ya que esta abriendo el modal
        $this->notificaciones = 0;
        $this->dispatch('scrollToBottom');
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

    public function respuestasSimuladasGPT()
    {
        return $respuestas = [
            "📌 Te recomiendo revisar el minuto :time del video. Ahí se explica justo lo que necesitas. ¡No te lo pierdas! 🎥",
            "👀 Dale una mirada al minuto :time, seguro aclara tus dudas. Es un punto clave del video. 🚀",
            "🎬 En el minuto :time del video encontrarás una explicación muy útil. ¡Échale un vistazo! ✅",
            "🕒 Ve directamente al minuto :time del video, ahí está la parte importante. Te ayudará bastante. 😉",
            "🧐 Mira el minuto :time, es justo donde se toca ese tema. Luego me cuentas qué te parece. 🎥",
            "💡 En el minuto :time está la clave. Te animo a verlo, seguro te despeja esa inquietud. 🔍",
            "⏳ El minuto :time del video tiene justo la información que estás buscando. ¡Dale play! ▶️",
            "📺 Puedes ir al minuto :time para ver esa parte en detalle. Es muy útil. ¡Cuéntame qué piensas luego! 💬",
            "🔎 Si vas al minuto :time, encontrarás justo lo que necesitas entender. Es muy claro ahí. 🎓",
            "🧠 En el video, el minuto :time toca ese tema. Vale la pena revisarlo. ¡Te va a servir! 👍",
            "📖 El minuto :time es como una mini clase magistral. ¡Imperdible! ✨",
            "📹 Todo se aclara en el minuto :time. Revisa ese momento del video. 🎯",
            "💬 Ese tema lo abordan justo en el minuto :time. Dale una mirada. 👁️",
            "🌟 No te pierdas el minuto :time, es oro puro. 🪙",
            "🤓 En el minuto :time está la explicación detallada. ¡Te va a encantar! 📚",
            "🔥 El minuto :time tiene justo lo que buscás. ¡Está muy bien explicado! 💯",
            "🎯 Ve al minuto :time y despeja esa duda en segundos. Rápido y claro. ✅",
            "📍 Minuto :time: ahí se resuelve todo. ¡No te lo pierdas! 💥",
            "🎧 Escucha atentamente el minuto :time, ahí lo dicen clarito. 🔊",
            "📝 Toma nota del minuto :time, es muy importante. 📒",
            "🌈 Si tienes dudas, el minuto :time puede iluminarte. Dale una vuelta. 💡",
            "👂 Presta atención al minuto :time, seguro te resuena. 🎵",
            "🏹 El punto exacto que buscas está en el minuto :time. 🎯",
            "🔑 La clave está en el minuto :time. Sin duda. 🗝️",
            "🎯 Lo que preguntas se responde justo en el minuto :time. ¡Perfecto! 🫶",
            "🗓️ En el minuto :time se habla de ese tema en profundidad. ✔️",
            "🥇 Minuto :time = respuesta top. Te va a servir mucho. 🙌",
            "💬 Lo explican claramente en el minuto :time. No te lo pierdas. 📢",
            "🧭 Te recomiendo ir al minuto :time. Esa parte es muy útil. 📌",
            "🌟 Te lo explican paso a paso en el minuto :time. Muy claro. 🔍",
            "🧩 Esa pieza encaja en el minuto :time. Revísalo. 🧠",
            "🚀 Todo hace clic en el minuto :time. Es brillante. 💫",
            "📚 Aprende más revisando el minuto :time. Es muy revelador. 📖",
            "🌍 Justo en el minuto :time hablan de eso. ¡Dale play! 📺",
            "🧠 Si ves el minuto :time, vas a tenerlo todo claro. No falla. ✨",
            "🎥 La parte más clara está en el minuto :time. Revísala. ✅",
            "🔍 Esa duda la resuelven en el minuto :time. Súper útil. 📌",
            "💭 Minuto :time = menos dudas, más claridad. 🧘‍♂️",
            "🧪 Lo explican con detalle en el minuto :time. Ideal para entender. 🧬",
            "⚙️ En el minuto :time todo encaja. Revisa ese segmento. 🧠",
            "🌟 Si tienes poco tiempo, ve al minuto :time. Es lo que necesitas. ⌛",
            "📢 Escucha bien el minuto :time, ahí está la explicación. 👂",
            "🔧 Revisa el minuto :time si quieres entender bien ese concepto. 🛠️",
            "🏆 Minuto :time = explicación ganadora. 🔝",
            "🤩 Vas a entender todo si vas al minuto :time. ¡Recomendado! 🧭",
            "🧠 Mucho más claro en el minuto :time. Échale un ojo. 👀",
            "💬 ¿Tienes dudas? Mira el minuto :time. Es justo lo que buscas. 🧾",
            "🧵 Todo el hilo se conecta en el minuto :time. ¡Súper claro! 🪡",
            "📍 En el minuto :time está la explicación que necesitas. Ve ahí. 🔎",
            "🎓 Esa parte del tema se cubre justo en el minuto :time. 🎥",
            "🎈 Para entender mejor, ve al minuto :time. Está genial explicado. 🧸",
            "🪄 Si algo no te queda claro, el minuto :time lo deja todo mágico. ✨",
            "📅 Ese punto exacto se cubre en el minuto :time del video. ⏱️",
            "🌱 Dale un vistazo al minuto :time, es una semilla de aprendizaje. 🌿",
            "🔦 Ilumina tu duda con el minuto :time. Te va a ayudar. 💡",
            "🎲 Tu mejor jugada es mirar el minuto :time. ¡Hazlo! 🎯",
            "🎠 Gira hacia el minuto :time y verás todo más claro. 🎡",
            "🧮 Para comprender, empieza por el minuto :time. ¡Funciona! 📏",
            "🔔 No dejes pasar el minuto :time. Es crucial. 🔕",
            "🧊 El momento más claro es el minuto :time. Directo y al punto. 📌",
            "🚦El minuto :time es la luz verde para tu comprensión. 💡",
            "🪤 Tu duda queda atrapada y resuelta en el minuto :time. ¡Zas! ⚡",
            "📍 Revisa el minuto :time, es el centro del asunto. 🧠",
            "🖥️ Minuto :time: explicación clara y directa. Recomendado. ✅",
            "🧗 El minuto :time es el punto más alto. Desde ahí, todo es bajada. 🏔️",
            "🪁 Vuela directo al minuto :time. Es el corazón del tema. ❤️",
            "🛸 Aborda el minuto :time para una mejor perspectiva. 🛰️",
            "📼 En el minuto :time hay una parte muy útil. ¡Ve ahí! 🧷",
            "🥽 Ponte las gafas y mira el minuto :time. Todo se aclara. 🔎",
            "🛎️ Llama a tu atención el minuto :time. ¡Vale la pena! 🧠",
            "🧵 El hilo conductor se encuentra en el minuto :time. 📍",
            "🧠 ¿Confundido? Minuto :time te da claridad. Hazle caso. 🗺️",
            "📺 Ponle pausa, avanza al minuto :time y sigue desde ahí. 🎬",
            "🗂️ Lo más relevante está en el minuto :time. ¡Revisa! 🔎",
            "🌐 Si hay algo que no entendiste, míralo en el minuto :time. 🧭",
            "🧑‍🏫 El profe lo explica muy bien en el minuto :time. ¡Escúchalo! 🎤",
            "🧲 El minuto :time atrae todas las respuestas. Ve ahí. 🔮",
            "🗃️ Ese tema lo desarrollan justo en el minuto :time. 🎓",
            "🚀 Si quieres despegar en este tema, ve al minuto :time. 🌌",
            "🏁 Empieza por el minuto :time si quieres ir al grano. 🏃‍♂️",
            "🔂 Repite el minuto :time hasta que todo esté claro. 💭",
            "🛎️ Atención especial al minuto :time. Es clave. ☝️",
            "🫧 Las dudas se disuelven en el minuto :time. Revisa. 🌊",
            "📍 Encuentra el núcleo de la explicación en el minuto :time. 🎯",
            "🔋 Recarga tu comprensión viendo el minuto :time. ⚡",
            "🔭 Enfócate en el minuto :time, ahí está todo. 🧠",
            "🚨 ¡Importante! Minuto :time tiene justo lo que preguntas. 👇",
            "🧰 El minuto :time es una herramienta poderosa. ¡Úsala! 🔨",
            "🏗️ Construye tu conocimiento desde el minuto :time. 🧱",
            "🌄 Todo empieza a tener sentido en el minuto :time. Ve allá. 🌞",
            "🧙‍♂️ Minuto :time: donde ocurre la magia del entendimiento. 🪄",
            "🧭 Si estás perdido, el minuto :time es tu guía. Sigue ese rumbo. 🗺️",
            "📽️ Todo cobra sentido cuando ves el minuto :time. ¡Compruébalo! 🎞️",
            "💫 Dale una oportunidad al minuto :time. Podría sorprenderte. 🌠",
        ];
    }

    public function recomendarRevision($questionId)
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

        $question = LevelQuestion::find($questionId);

        // Simular respuesta del bot
        $respuestas = $this->respuestasSimuladasGPT();

        $randomRespuesta = $respuestas[array_rand($respuestas)];
        $respuestaFinal = str_replace(':time', $question->time_response, $randomRespuesta);

        $chatDetalleBot = new ChatDetalle();
        $chatDetalleBot->chat_header_id = $chatHeader->id;
        $chatDetalleBot->mensaje = $respuestaFinal;
        $chatDetalleBot->bot = true;
        $chatDetalleBot->save();
    }

    public function enviarMensaje()
    {
        $this->sendingMessage = true; // Bloquear input y botón
        $this->dispatch('$refresh'); // Forzar actualización inmediata


        // Procesar el mensaje y guardarlo
        if (ChatHeader::where('user_id', Auth::user()->id)->where('estado', 'ABIERTO')->exists()) {
            $chatHeader = ChatHeader::where('user_id', Auth::user()->id)->where('estado', 'ABIERTO')->first();
        } else {
            $chatHeader = new ChatHeader();
            $chatHeader->user_id = Auth::user()->id;
            $chatHeader->estado = 'ABIERTO';
            $chatHeader->save();
        }

        $chatDetalle = new ChatDetalle();
        $chatDetalle->chat_header_id = $chatHeader->id;
        $chatDetalle->mensaje = $this->message;
        $chatDetalle->bot = false;
        $chatDetalle->save();

        // Simular respuesta del bot
        $respuesta = $this->obtenerRespuesta($this->message, $chatHeader->id, $this->message);
        
        $chatDetalleBot = new ChatDetalle();
        $chatDetalleBot->chat_header_id = $chatHeader->id;
        $chatDetalleBot->mensaje = $respuesta;
        $chatDetalleBot->bot = true;
        $chatDetalleBot->save();
        

        $this->message = '';

        $this->sendingMessage = false;
        $this->dispatch('$refresh');
        $this->dispatch('scrollToBottom');
    }

    public function obtenerRespuesta($prompt, $chatId, $message)
    {
        try {
            $mainUrl = 'http://186.101.189.104:5010/';
            $chatbotUrl = 'api/chatbot';


            $postArray = [
                "question" => empty($message) ? 'Hola' : $message,
                "user_id" => (string) $chatId,
                "max_histories" => 10,
                "name_space" => "index_55",
                "index" => "233"
            ];

            $post = Http::withHeaders([
                "Content-Type" => "application/json"
            ])
                ->timeout(120)
                ->post($mainUrl . $chatbotUrl, $postArray);

            if ($post->successful()) {
                $response = json_decode($post->body(), true);
                return $response['respuesta'];
            } else {
                return '';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // $apiKey = "";
        // $url = "https://api.openai.com/v1/chat/completions";
        // $data = [
        //     "model" => "gpt-4o-mini",
        //     "messages" => [
        //         ["role" => "system", "content" => "Eres un asistente ayuda a responder cuestionarios."],
        //         ["role" => "user", "content" => $prompt]
        //     ]
        // ];

        // $response = Http::withHeaders([
        //     "Authorization" => "Bearer $apiKey",
        //     "Content-Type" => "application/json"
        // ])->post($url, $data);
        // return $response->json()['choices'][0]['message']['content'] ?? 'Sin respuesta';
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
