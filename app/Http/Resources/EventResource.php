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
            'judul' => $this->judul,
            'tanggal' => $this->tanggal,
            'lokasi' => $this->lokasi,
            'kuota' => $this->kuota,
            'deskripsi' => $this->deskripsi,
        ];
    }
}
