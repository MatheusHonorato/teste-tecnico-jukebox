<?php

declare(strict_types=1);

namespace App\Contracts;

interface RepositoryBaseInterface
{
    public function index($id);

    public function create($data);

    public function getById($id);

    public function update($id, $data);

    public function destroy($id);
}
