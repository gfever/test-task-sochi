<?php
/**
 * @author d.ivaschenko
 */

namespace App\Models;


abstract class Model implements ModelInterface
{
    public function getAttributes(): array
    {
        return get_object_vars($this);
    }
}