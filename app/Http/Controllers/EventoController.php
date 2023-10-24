<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Evento;
use App\Models\User;
use PhpParser\Node\Expr\New_;

class EventoController extends Controller
{

    public function index()
    {

        $search = request('search');

        if ($search) {

            $eventos = Evento::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $eventos = Evento::all();
        }

        return view('welcome', ['eventos' => $eventos, 'search' => $search]);
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {

        $evento = new Evento;

        $evento->title = $request->title;
        $evento->city = $request->city;
        $evento->date = $request->date;
        $evento->private = $request->private;
        $evento->description = $request->description;
        $evento->items = $request->items;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $imageName = md5($requestImage->getclientOriginalName() . strtotime("now")) . "." . $request->image->getClientOriginalExtension();

            $requestImage->move(public_path('assets/img/eventos'), $imageName);

            $evento->image = $imageName;
        }


        $user = auth()->user();
        $evento->user_id = $user->id;

        $evento->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {

        $evento = Evento::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {

            $userEventos = $user->eventosParticipantes->toArray();

            foreach ($userEventos as $userEvento) {
                if ($userEvento['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        $eventoOwner = User::where('id', $evento->user_id)->first()->toArray();

        return view('eventos.show', ['evento' => $evento,
         'eventoOwner' => $eventoOwner,
         'hasUserJoined' => $hasUserJoined]);
    }

    public function dashboard()
    {

        $user = auth()->user();

        $eventos = $user->eventos;

        $eventosParticipantes = $user->eventosParticipantes;

        return view('eventos.dashboard', ['eventos' => $eventos, 'eventosParticipantes' => $eventosParticipantes]);
    }

    public function destroy($id)
    {

        $user = auth()->user();
        $evento = Evento::findOrFail($id);


        if ($user->id != $evento->user->id) {
            return redirect('/dashboard');
        }

        Evento::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    public function edit($id)
    {

        $user = auth()->user();

        $evento = Evento::findOrFail($id);

        if ($user->id != $evento->user->id) {
            return redirect('/dashboard');
        }

        return view('eventos.edit', ['evento' => $evento]);
    }

    public function update(Request $request)
    {

        Evento::findOrFail($request->id)->update($request->all());

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    public function joinEvento($id)
    {

        $user = auth()->user();

        $user->eventosParticipantes()->attach($id);

        $evento = Evento::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $evento->title);
    }

    public function leaveEvent($id)
    {

        $user = auth()->user();

        $user->eventosParticipantes()->detach($id);

        $evento = Evento::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $evento->title);
    }
}
