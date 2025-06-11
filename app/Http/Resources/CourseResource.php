<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'name_cotcher' => $this->name_cotcher,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'image' => $this->image ? 'https://learning.fiye5986.odns.fr/' . $this->image : null,
            'video' => $this->video,
            'purchase_count' => $this->purchase_count,
            'category_name' => $this->categoryRelation ? $this->categoryRelation->name : 'غير معروف',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
