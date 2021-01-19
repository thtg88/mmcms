<?php

namespace Thtg88\MmCms\Services\Concerns;

use Thtg88\MmCms\Http\Requests\Contracts\PublishRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UnpublishRequestInterface;

trait WithPublish
{
    /**
     * Publish a model instance with given request, and id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\PublishRequestInterface $request
     * @param int                                                           $id      The id of the model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function publish(PublishRequestInterface $request, $id)
    {
        return $this->repository->update($id, [
            'published_at' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Remove a model instance from publish, from a given request, and id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\UnpublishRequestInterface $request
     * @param int                                                             $id      The id of the model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unpublish(UnpublishRequestInterface $request, $id)
    {
        return $this->repository->update($id, ['published_at' => null]);
    }
}
