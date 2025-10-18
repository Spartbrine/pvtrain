<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchDestroyService
{
    public function execute($id)
    {
        $branch = Branch::findOrFail($id);
        return $branch->delete();

    }
}
