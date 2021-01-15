<?php

namespace App\Http\Resources;

use App\Http\Resources\Phase as PhaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkApplication extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company' => $this->company,
            'description' => $this->description,
            'phase_id' => $this->phase_id,
            'user_id' => $this->user_id,
            'phase' => new PhaseResource($this->whenLoaded('phase')),
            'application_date' => $this->application_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
