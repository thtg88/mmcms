<?php

namespace Thtg88\MmCms\Repositories;

interface RepositoryInterface
{
    public function all();

    public function allCompact();

    public function create(array $data);

    public function destroy($id);

    public function find($id);

    public function findByModelName($model_name);

    public function latest($limit);

    public function paginate($page_size);

    public function search($q);

    public function update($id, array $data);
}
