<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchShowService
{
    public function execute($id)
    {
        return Branch::findOrFail($id);
    }
}
