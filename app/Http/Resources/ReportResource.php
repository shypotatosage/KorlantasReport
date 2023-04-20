<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'location' => $this->location,
            'time' => $this->time,
            'report' => $this->report,
            'picture' => $this->picture,
            'status' => $this->status,
            'user' => User::findOrFail($this->user_id)->first(),
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
