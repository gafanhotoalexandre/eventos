<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Cria um tributo com base no objeto model injetado
     * 
     * @param App\Models\Event $event
     */
    public function __construct(Event $event, EventUser $eventUser)
    {
        $this->event = $event;
        $this->eventUser = $eventUser;
    }

    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $events = $this->event->where([
                ['title', 'like', '%'. $search .'%'],
            ])->get();
        } else {
            $events = $this->event->all();
        }

        // recuperando o caminho completo da imagem
        $events = $this->event->getImagePathFromArray($events);

        return view('welcome', [
            'events' => $events,
            'search' => $search
        ]);    
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $event = new Event();

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;
        $event->image = '';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageUrn = $image->store('img/events', 'public');
            $event->image = $imageUrn;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect()
            ->route('events.index')
            ->with('msg', 'Evento criado com sucesso!');
    }

    /**
     * Recebe o ID do evento
     * Apresenta o recurso buscado
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $event = $this->event->with(['user'])->findOrFail($id);

        $this->event->getImagePath($event);

        $user = auth()->user();

        $hasUserJoined = false;

        if ($user) {
            $eventUser = $this->eventUser->where([
                ['user_id', $user->id],
                ['event_id', $id]
            ])->get()->toArray();

            if ($eventUser) {
                $hasUserJoined = true;
            }
        }
        // $userEvents = $user->eventsAsParticipants->toArray();
        // foreach ($userEvents as $userEvent) {
        //     if ($userEvent['id'] == $id) {
        //         $hasUserJoined = true;
        //     }
        // }

        return view('events.show', [
            'event' => $event,
            'hasUserJoined' => $hasUserJoined
        ]);
    }

    /**
     * Retorna dados de usuário e eventos cadastrados por este
     * à view de dashboard
     * 
     * @return Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipants;

        return view('events.dashboard', [
            'events' => $events,
            'eventsAsParticipant' => $eventsAsParticipant,
            'user' => $user
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $user = $request->user();

        $event = $this->event->findOrFail($id);

        $this->event->getImagePath($event);


        if ($user->id != $event->user_id) {
            return redirect()->route('dashboard');
        }

        return view('events.edit', [
            'event' => $event
        ]);
    }

    public function update(Request $request, int $id)
    {
        // dd($request->all());
        
        $event = $this->event->findOrFail($id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Removendo imagem do evento
            Storage::disk('public')->delete($event->image);

            $image = $request->file('image');
            $imageUrn = $image->store('img/events', 'public');
            $event->image = $imageUrn;
        }

        $data = $request->all();
        $data['image'] = $event->image;
        // problema tá aqui
        $event->update($data);

        return redirect()->route('events.index')
            ->with('msg', 'Evento atualizado com sucesso!');
    }

    /**
     * Deleta o evento cadastrado
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $event = $this->event->findOrFail($id);

        // Removendo imagem do evento
        Storage::disk('public')->delete($event->image);
        // Removendo evento
        $event->delete();

        return redirect()->route('dashboard')
            ->with('msg', 'Evento excluído com sucesso!');
    }

    public function joinEvent(Request $request, int $id)
    {
        $user = $request->user();

        $user->eventsAsParticipants()->attach($id);

        $event = $this->event->findOrFail($id);

        return redirect()->route('dashboard')
            ->with('msg', 'Sua presença está confirmada no evento '. $event->title);
    }

    public function leaveEvent(Request $request, int $id)
    {
        $user = $request->user();
        $user->eventsAsParticipants()->detach($id);

        $event = $this->event->findOrFail($id);;

        return redirect()->route('dashboard')
            ->with('msg', 'Sua presença foi removida do evento: '. $event->title);
    }
}
