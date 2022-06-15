<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{

public function index(Request $request)
{
    $input = $request->all();
    $calendars = Event::where('date_start', '>=', $input['date_start'])
    ->where('date_end', '<=', $input['date_end'])->get();
    return response()->json([
        "success" => true,
        "message" => "Event List",
        "data" => $calendars
]);
}

public function store(CreateEventRequest $request)
{
    $input = $request->all();
        
    if($user = auth()->user()){
        $calendar = Event::create($input);
        return response()->json([
            "success" => true,
            "message" => "Event created successfully.",
            "data" => $calendar
        ]);
    }else{
       $calendars = Event::where('date_start', '<=', $input['date_start'])
       ->where('date_start', '>=', $input['date_start'])
       ->where('date_end', '<=', $input['date_end'])
       ->where('date_end', '>=', $input['date_end'])->get();
       if(!$calendars){
        return response() ->json([
            "success" => true,
            "message" => "Event no updated successfully.",
            "data" => $calendars
        ]);
       }else{
            return response() ->json([
                "success" => false,
                "message" => "Event no updated successfully."
            ]);
        }
            
    }
} 

public function update(UpdateEventRequest $request, Event $event)
{
    $input = $request->all();
        $event->update($input);
            return response()->json([
            "success" => true,
            "message" => "Event updated successfully.",
            "data" => $event
            ]);
}

public function destroy(Event $event)
{
    $event = Event::destroy($event->id);
    return response()->json([
        "success" => true,
        "message" => "Event deleted successfully.",
        "data" => $event
    ]);
}
}