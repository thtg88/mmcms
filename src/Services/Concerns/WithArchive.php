<?php

namespace Thtg88\MmCms\Services\Concerns;

use Thtg88\MmCms\Http\Requests\Contracts\ArchiveRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UnarchiveRequestInterface;

trait WithArchive
{
    /**
     * Archive a model instance with given request, and id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\ArchiveRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function archive(ArchiveRequestInterface $request, $id)
    {
        return $this->repository->update($id, [
            'archived_at' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Remove a model instance from archive, from a given request, and id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\UnarchiveRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unarchive(UnarchiveRequestInterface $request, $id)
    {
        return $this->repository->update($id, ['archived_at' => null]);
    }
}
