<?php

namespace App\Services\Branch;

use App\Models\Branch;

class BranchIndexService
{
    public function execute($filters)
    {

        $filters = array_filter($filters);
        $paginationFilters = [];

        if (is_array($filters) && count($filters) > 0) {
            foreach ($filters as $field => $value) {
                if ($field == 'limit') {
                    $paginationFilters['limit'] = $value;
                    unset($filters[$field]);
                }

                if ($field == 'page') {
                    $paginationFilters['page'] = $value;
                    unset($filters[$field]);
                }
            }

            $query = Branch::query();

            foreach ($filters as $field => $value) {
                if ($field == 'name') {
                    $query->where($field, 'LIKE', '%' . $value . '%');
                    continue;
                }

                $query->where($field, '=', $value);
            }

            if (isset($paginationFilters['limit']) && isset($paginationFilters['page'])) {
                $limit = (int) $paginationFilters['limit'];
                $page = (int) $paginationFilters['page'];
                $offset = ($page - 1) * $limit;
                return $query->offset($offset)->limit($limit)->get();
            }

            return $query->get();

        }
    }
}
