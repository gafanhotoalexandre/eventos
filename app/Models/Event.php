<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date', 'city', 'private',
        'description', 'items', 'image'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    protected $dates = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

	/**
	* Retornando url completa das imagens, caso
	* não exista, retorna url padrão (event_placeholder)
	* 
	* @return $events
	*/
    public function getImagePathFromArray(Collection $events): object
    {
        foreach ($events as $index => $event) {
            if ($events[$index]->image != '') {
                $events[$index]->image = Storage::url($event->image);
                continue;
            }
            $events[$index]->image = 'img/event_placeholder.jpg';
        }
        return $events;
    }

	/**
	* Retornando url completa da imagem, caso
	* não exista, retorna url padrão (event_placeholder)
	* 
	* @return $events
	*/
    public function getImagePath(Event $event)
    {
        if ($event->image == '') {
            return $event->image = 'img/event_placeholder.jpg';
        }
        return $event->image = Storage::url($event->image);
    }
}
