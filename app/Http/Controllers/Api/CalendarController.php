<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CalendarController extends Controller
{

public function get()
{
$calendars = Event::all();
return response()->json([
"success" => true,
"message" => "Product List",
"data" => $calendars
]);
}

public function post(Request $request)
{
$input = $request->all();
$validatedData  = Validator::make($input, [
'title' => 'required',
'description' => 'required',
'date_start' => 'required',
'date_end' => 'required'
]);
if($validatedData ->fails()){
return $this->sendError('Validation Error.', $validatedData ->errors());       
}
$calendars = Event::create($input);
return response()->json([
"success" => true,
"message" => "Product created successfully.",
"data" => $calendars
]);
} 

public function patch(Request $request, Event $calendar)
{
$input = $request->all();
$validator = Validator::make($input, [
'title' => 'required',
'description' => 'required',
'date_start' => 'required',
'date_end' => 'required'
]);
if($validator->fails()){
return $this->sendError('Validation Error.', $validator->errors());       
}
$calendar->title = $input['title'];
$calendar->description = $input['description'];
$calendar->date_start = $input['date_start'];
$calendar->date_end = $input['date_end'];
$calendar->save();
return response()->json([
"success" => true,
"message" => "Product updated successfully.",
"data" => $calendar
]);
}

public function delete(Event $calendar)
{
$calendar->delete();
return response()->json([
"success" => true,
"message" => "Product deleted successfully.",
"data" => $calendar
]);
}
}