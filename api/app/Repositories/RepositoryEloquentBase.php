<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RepositoryBaseInterface;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryEloquentBase implements RepositoryBaseInterface
{
    public function __construct(private Model $model)
    {
    }

    public function index($id)
    {
        return $this->model->whereUserId($id)
            ->latest()
            ->paginate(10);

    }

    public function create($data)
    {
        try {
            return $this->model->create((array) $data);
        } catch(\Exception) {
            throw new \App\Exceptions\RepositoryException();
        }
    }

    public function getById($id)
    {
        try {
            return $this->model->whereId($id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            throw new \App\Exceptions\RepositoryExceptionNotFound();
        } catch(\Exception) {
            throw new \App\Exceptions\RepositoryException();
        }
    }

    public function update($id, $data)
    {
        $model = $this->getById($id);

        try {
            $model->updateOrFail((array) $data);
        } catch(\Exception) {
            throw new \App\Exceptions\RepositoryException();
        }
    }

    public function destroy($id)
    {
        $model = $this->getById($id);

        try {
            $model->delete();
        } catch(\Exception) {
            throw new \App\Exceptions\RepositoryException();
        }
    }
}
