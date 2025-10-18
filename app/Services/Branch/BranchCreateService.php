<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchCreateService
{
    public function execute(array $data)
    {
        return Branch::create($data);
    }
}
