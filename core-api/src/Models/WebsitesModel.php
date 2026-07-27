<?php

namespace App\Models;

use System\Database\Model;

class WebsitesModel extends Model 
{

    protected ?string $table = "websites";

    protected ?array $columns = [
        'id',
        "name",
        "domain",
        "code_script"  
    ];

}