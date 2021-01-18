<?php

namespace Thtg88\MmCms\Http\Resources;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'email'      => $this->email,
            'id'         => $this->id,
            'name'       => $this->name,
            'role'       => new Resource($this->role),
            'role_id'    => $this->role_id,
        ];
    }
}
