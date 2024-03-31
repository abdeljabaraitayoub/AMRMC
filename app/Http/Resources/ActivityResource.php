<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // Get all original attributes
        $data = parent::toArray($request);

        // Format the date fields
        $data['created_at'] = $this->created_at->format('d-m-Y H:i:s');
        $data['updated_at'] = $this->updated_at->format('d-m-Y H:i:s');

        return $data;
    }
}
