<?php

namespace Thtg88\MmCms\Http\Resources;

interface ResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array;
}
