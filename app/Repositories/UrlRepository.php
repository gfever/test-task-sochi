<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;

use App\Models\Url;

class UrlRepository extends Repository
{
    protected $model = Url::class;
    protected $table = 'urls';



}