<?php
namespace App\Livewire;

use App\Models\LevelQuestionOption;
use App\Models\LevelQuestion;
use App\Models\PersonLevelQuestionOption;
use App\Models\Level;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Component;

class CertificateComponent extends Component
{
    public $person_selecionado = 0;


    public function generatePDF(){
        $nick = Person::find($this->person_selecionado)->nick;
        $puntaje = 0;
        $todasPreguntas = LevelQuestion::get()->count();

        // Calcula puntos
        $totalPuntos = DB::table('person_level_question_option')
                ->select([
                    'person_level_question_option.id',
                    'person.nick',
                ])
                ->leftJoin('person', 'person_level_question_option.person_id', '=', 'person_level_question_option.id')
                ->leftJoin('level_question_option', 'person_level_question_option.level_question_option_id', '=', 'level_question_option.id')
                ->where('person_level_question_option.person_id', $this->person_selecionado)
                ->where('level_question_option.correct', true)
                ->get();

        $totalPuntos = count($totalPuntos);

        $data = [
            'nick' => $nick,
            'fecha' => date('Y-m-d'),
            'totalPuntos' => $totalPuntos,
            'todasPreguntas' => $todasPreguntas
        ];

        $pdf = Pdf::loadView('pdf.certificado', $data);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "certificado-$nick.pdf"
        );

    }

    public function mount($personId){
        $this->person_selecionado = $personId;
    }

    public function render()
    {
        $person = Person::find($this->person_selecionado);

        $personas = Person::get();
        foreach ($personas as $key => $per) {
            $totalPuntos = DB::table('person_level_question_option')
                ->select([
                    'person_level_question_option.id',
                    'person.nick',
                ])
                ->leftJoin('person', 'person_level_question_option.person_id', '=', 'person_level_question_option.id')
                ->leftJoin('level_question_option', 'person_level_question_option.level_question_option_id', '=', 'level_question_option.id')
                ->where('person_level_question_option.person_id', $per->id)
                ->where('level_question_option.correct', true)
                ->get();

            $per->totalPuntos = count($totalPuntos);
        }
        
        $personas = $personas->sortByDesc('totalPuntos');

        return view('livewire.certificate-component', compact('person', 'personas'));
    }
}
