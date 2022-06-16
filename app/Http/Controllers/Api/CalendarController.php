<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\GetEventRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

public function index(GetEventRequest $request)
{
    $input = $request->all();
    $calendars = Event::where('date_start', '>=', $input['date_start'])
    ->where('date_end', '<=', $input['date_end'])->get();
    $calendars = Event::all();
    return response()->json([
        "success" => true,
        "message" => "Event List",
        "data" => $calendars
]);
}

public function store(CreateEventRequest $request)
{
    $input = $request->all();
    $dt = Carbon::create($input['date_start']);
    $date_end = $dt->addMinute($input['duration']);
    $input['date_end'] = $date_end;
    if($user = Auth::guard('api')->check()){
        $calendar = Event::create($input);
        return response()->json([
            "success" => true,
            "message" => "Event created successfully.",
            "data" => $calendar
        ]);
    }elseif(!$user){
       $calendars = Event::where('date_start', '>=', $input['date_start'])
       ->where('date_start', '<=', $input['date_start'])
       ->where('date_end', '>=', $input['date_end'])
       ->where('date_end', '<=', $input['date_end'])->get();
       if(!empty($calendars->isEmpty())){
        $calendar = Event::create($input);
        return response()->json([
            "success" => true,
            "message" => "Event created successfully.",
            "data" => $calendar
        ]);
       }else{
            return response() ->json([
                "success" => false,
                "message" => "Event already exists."
            ]);
        }
            
    }
} 

public function update(UpdateEventRequest $request, Event $event)
{
    $date1 = Carbon::now();
    $st = $date1->addHours(3);
    $date2 = Carbon::parse($event['date_start']);
    $result = $st->gt($date2);
    if(!$result){
        $input = $request->all();
        $dt = Carbon::create($input['date_start']);
        $date_end = $dt->addMinute($input['duration']);
        $input['date_end'] = $date_end;
        $event->update($input);
            return response()->json([
            "success" => true,
            "message" => "Event updated successfully.",
            "data" => $event
            ]);
    }else{
        return response()->json([
            "success" => false,
            "message" => "Event already exists."
            ]);
    }
}

public function destroy(Event $event)
{
    $date1 = Carbon::now();
    $st = $date1->addHours(3);
    $date2 = Carbon::parse($event['date_start']);
    $result = $st->gt($date2);
    if(!$result){
        $event = Event::destroy($event->id);
        return response()->json([
            "success" => true,
            "message" => "Event deleted successfully.",
            "data" => $event
        ]);
    }else{
        return response()->json([
            "success" => false,
            "message" => "Event already exists."
            ]);
    } 
}
}