<?php

namespace Thtg88\MmCms\Http\Resources\ContentField;

use Thtg88\MmCms\Http\Resources\Resource;

class PaginateResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'content_model_id' => $this->content_model_id,
            // TODO: replace once ready
            'content_type' => new Resource($this->content_type),
            'content_type_id' => $this->content_type_id,
            'created_at' => $this->created_at,
            'display_name' => $this->display_name,
            'helper_text' => $this->helper_text,
            'id' => $this->id,
            'is_mandatory' => $this->is_mandatory,
            'is_resource_name' => $this->is_resource_name,
            'name' => $this->name,
        ];
    }
}
