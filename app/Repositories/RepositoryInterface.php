<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;


use App\Models\ModelInterface;

interface RepositoryInterface
{
    public function create(ModelInterface $model);
}