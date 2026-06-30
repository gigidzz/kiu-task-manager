<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'subject'     => $this->subject,
            'status'      => $this->status,
            'status_label'   => $this->isDone() ? 'Done' : 'Pending',
            'priority'    => $this->priority,
            'priority_label' => $this->priorityLabel(),
            'deadline'    => $this->deadline?->toDateString(),
            'attachment_url' => $this->attachment ? asset('storage/' . $this->attachment) : null,
            'tags'        => $this->whenLoaded('tags', fn () => $this->tags->map(fn ($tag) => [
                'id'    => $tag->id,
                'name'  => $tag->name,
                'color' => $tag->color,
            ])),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
