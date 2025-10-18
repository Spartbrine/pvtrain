<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchSearchService
{
    public function execute($name)
    {
        return Branch::where('name', 'like', '%' . $name . '%')->get();
    }
}
