<?php

namespace App\Repo;

use App\Domain\Repo\EventRepository;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventRepositoryImpl implements EventRepository
{
    public function getEvent($id): Event
    {
        return Event::findOrFail($id);
    }

    public function createEvent($data): Event
    {
        return Event::create($data);
    }

    public function updateEvent($id, $data): Event
    {
        $event = Event::findOrFail($id);
        unset($data['organizer_id']);
        $event->update($data);
        return $event;
    }

    public function deleteEvent($id): int
    {
        return Event::destroy($id);
    }
}
