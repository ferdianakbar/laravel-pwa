<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'short_description' => substr(strip_tags($this->description), 0, 150),
            'author' => new UserResource($this->author()),
        ];
        return $data;
    }
}
