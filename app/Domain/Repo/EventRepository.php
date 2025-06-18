<?php

namespace App\Domain\Repo;

use App\Models\Event;

interface EventRepository
{
    public function getEvent($id): Event;

    public function createEvent($data): Event;

    public function updateEvent($id, $data): Event;

    public function deleteEvent($id): int;

}
