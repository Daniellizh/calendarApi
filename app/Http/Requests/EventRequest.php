<?php

namespace App\Http\Requests;

use Illuminate\Http\Resources\Json\JsonResource;

class EventRequest extends JsonResource
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules($request)
    {
        return [
            'title' => $this->id,
            'description' => $this->description,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end
        ];
    }
}
