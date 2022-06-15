<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EventRequest;

class CalendarController extends Controller
{

public function index()
{
    $calendars = Event::all();
    return response()->json([
        "success" => true,
        "message" => "Event List",
        "data" => $calendars
]);
}

public function store(Request $request)
{
    $input = $request->all();
    $validator  = Validator::make($input, [
        'title' => 'required',
        'description' => 'required',
        'date_start' => 'required',
        'date_end' => 'required'
]);
    // if($user = auth()->user()){
        $calendar = Event::create($input);
        return response()->json([
            "success" => true,
            "message" => "Event created successfully.",
            "data" => $calendar
        ]);
    // }else{
    //    $calendars = Event::where('date_start', '<=', $input['date_start'])
    //    ->where('date_start', '>=', $input['date_start'])
    //    ->where('date_end', '<=', $input['date_end'])
    //    ->where('date_end', '>=', $input['date_end'])->get();
    //    if($user != auth()->user()){
    //         return response() ->json([
    //             "success" => false,
    //             "message" => "Event no updated successfully.",
    //             "data" => $calendars
    //         ]);
    //     }
    // }
} 

public function update(Request $request, Event $calendar)
{
    $input = $request->all();
    $validator = Validator::make($input, [
        'title' => 'required',
        'description' => 'required',
        'date_start' => 'required',
        'date_end' => 'required'
    ]);
        $calendar->id = $input['id'];
        $calendar->title = $input['title'];
        $calendar->description = $input['description'];
        $calendar->date_start = $input['date_start'];
        $calendar->date_end = $input['date_end'];
        $calendar->save();
            return response()->json([
            "success" => true,
            "message" => "Event updated successfully.",
            "data" => $calendar
            ]);
    // if($validator->fails()){
    //     return response()->json([
    //         "success" => true,
    //         "message" => "Event updated successfully.",
    //         "data" => $calendar
    //         ]);       
    //     }
}

public function destroy(Event $calendar, $id)
{
    $calendar = Event::destroy($id);
    return response()->json([
        "success" => true,
        "message" => "Event deleted successfully.",
        "data" => $calendar
    ]);
}
}