<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->judul,
            'date' => $this->tanggal,
            'location' => $this->lokasi,
            'quota' => $this->kuota,
            'description' => $this->deskripsi,
        ];
    }
}
