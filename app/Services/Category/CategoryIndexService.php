<?php

namespace App\Services\Category;

use App\Models\Category;

class CategoryIndexService
{
    public function execute($filters)
    {
        $filters = array_filter($filters);
        $paginationFilters = [];

        if (is_array($filters) && count($filters) > 0) {
            foreach ($filters as $filter) {
                if ($filter == 'limit') {
                    $paginationFilters['limit'] = $filter;
                    unset($filters[$filter]);
                }

                if ($filter == 'page') {
                    $paginationFilters['page'] = $filter;
                    unset($filters[$filter]);
                }
            }
        }

        $query = Category::query();

        foreach ($filters as $field => $value) {
            $query->where($field, 'LIKE', '%' . $value . '%');
        }

        if (isset($paginationFilters['limit']) && isset($paginationFilters['page'])) {
            $limit = (int) $paginationFilters['limit'];
            $page = (int) $paginationFilters['page'];
            $offset = ($page - 1) * $limit;
            return $query->offset($offset)->limit($limit)->get();
        }

        return $query;

    }
}
