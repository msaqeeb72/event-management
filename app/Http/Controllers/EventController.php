<?php

namespace App\Http\Controllers;

use App\Domain\Repo\EventRepository;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\QueryBuilders\FilterEventQueryBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    private EventRepository $eventRepository;
    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }
    public function createEvent(EventRequest $request)
    {
        $user = $request->user();
        $file = $request->file("image");
        $fileName = $this->uploadImage($file,$request->input("title"));

        if(!$fileName)
            return $this->respondFailed(message:"Unable to upload image");
        $filePath = "images/".$fileName;
        $event = $this->eventRepository->createEvent([
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "start_datetime" => $request->input("start_datetime"),
            "end_datetime" => $request->input("end_datetime"),
            "venue" => $request->input("venue"),
            "city" => $request->input("city"),
            "state" => $request->input("state"),
            "country" => $request->input("country"),
            "organizer_id" => $user->id,
            "image_url" => $filePath
        ]);
        if($event){
            $this->respondSuccess(message:"Event Created Successfully.");
        }
        $this->respondFailed(message:"Unable to creae event.");
    }

    public function getEvent($id,EventRequest $request)
    {
        $user = $request->user();
        $event = $user->organizedEvents()->where("id",$id)->first();

        if($event){
            return $this->respondSuccess($event,message:"Event Fetch Successfully.");
        }
        $this->respondFailed(message:"Unable to fetch event.");
    }

    public function updateEvent($id, EventRequest $request)
    {
        $user = $request->user();
        $event = $user->organizedEvents()->where("id", $id)->first();

        if (!$event) {
            return $this->respondFailed(message: "Event not found or unauthorized.");
        }

        $data = $request->only([
            'title', 'description', 'start_datetime', 'end_datetime',
            'venue', 'city', 'state', 'country', 'status', 'is_active'
        ]);

        if ($request->hasFile('image')) {
            $fileName = $this->uploadImage($request->file('image'), $request->input('title'));

            if (!$fileName) {
                return $this->respondFailed(message: "Image upload failed.");
            }

            $data['image_url'] = 'images/' . $fileName;
        }

        $updatedEvent = $this->eventRepository->updateEvent($id, $data);

        return $this->respondSuccess($updatedEvent, message: "Event Updated Successfully.");
    }
    public function deleteEvent($id, EventRequest $request)
    {
        $user = $request->user();
        $event = $user->organizedEvents()->where("id", $id)->first();

        if (!$event) {
            return $this->respondFailed(message: "Event not found or unauthorized.");
        }

        $deleted = $this->eventRepository->deleteEvent($id);

        if ($deleted) {
            return $this->respondSuccess(message: "Event deleted successfully.");
        }

        return $this->respondFailed(message: "Failed to delete event.");
    }
    public function filterEvent(Request $request)
    {
        $user = $request->user();

        $result = (new FilterEventQueryBuilder())
        ->setPagination($request->input("page"),$request->input("per_page"))
            ->setStatus($request->input("status"))
            ->setCity($request->input("city"))
            ->paginate();

        if($result){
            return $this->respondSuccess($result,"Filtered Successfully");
        }
        return $this->respondFailed(message: "Failed to delete event.");
    }

    private function uploadImage($file, $name){
        $fileName = $name."_".$file->getClientOriginalName();
        $isSuccess = Storage::disk("public")->put("images/".$fileName,file_get_contents($file));
        if($isSuccess)
            return $fileName;
        else
            return null;
    }
}
