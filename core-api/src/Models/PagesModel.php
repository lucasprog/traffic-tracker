<?php

namespace App\Models;

use System\Database\Model;

class PagesModel extends Model 
{

    protected ?string $table = "pages";

    protected ?array $columns = [
        'id',
        "name",
        "route",
        "visitor_id",
        "website_id",
        "created_at",
        "updated_at"
    ];

}