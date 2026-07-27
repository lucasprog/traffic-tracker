<?php

namespace App\Models;

use System\Database\Model;

class WebSitesModel extends Model 
{

    protected ?string $table = "websites";

    protected ?array $columns = [
        'id',
        "name",
        "domain",
        "created_at",
        "updated_at"
    ];

}