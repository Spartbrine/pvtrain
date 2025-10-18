<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchUpdateService
{
    public function execute($id, array $data)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($data);
        return $branch;
    }
}
