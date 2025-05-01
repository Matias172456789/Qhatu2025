<?php

namespace App\Livewire;
use App\Models\Person;

use Livewire\Component;

class UserComponent extends Component
{
    public $nick = '';

    public function comenzar()
    {
        // Si existe redirigir 
        $existeNick = Person::where('nick', $this->nick)->exists();
        if($existeNick){
            $personNick = Person::where('nick', $this->nick)->first();
            return redirect('/levels/'.$personNick->id);
        }


        $this->validate([
            'nick' => 'required|min:3|unique:person,nick'
        ],[
            'nick.required' => 'El campo nick es obligatorio.',
            'nick.min' => 'El campo nick debe tener al menos 3 caracteres.',
            'nick.unique' => 'El nick ya está en uso, elige otro.'
        ]);

        // Guardar
        $person = New Person();
        $person->nick = $this->nick;
        $person->save();

        $this->nick = '';

        // Redirigir a levels
        return redirect('/levels/'.$person->id);
    }

    public function render()
    {
        //dd(Person::all());
        return view('livewire.user-component');
    }
}
