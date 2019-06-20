<?php

namespace App\Traits;

/**
 * Trait FilterBuilder
 */
trait FilterBuilder
{

    /**
     * Applied filters
     *
     * @var array
     */
    private $appliedFilter = [];

    /**
     * Apply filter
     *
     * @param mixed $request     Request
     * @param mixed $builder     Builder
     * @param mixed $queryIgnore Query Ignore List
     *
     * @return mixed
     */
    private function applyFilter($request, $builder, $queryIgnore = [])
    {
        $requestData = $request->except(['page', 'clear_filter']);

        $where = [];

//        if (!$request->has('clear_filter') && empty($requestData)) {
//            $requestData = session($request->route()->getName() . 'filter');
//        }

        foreach (self::FILTER_FIELDS as $field => $condition) {
            $filterValue = isset($requestData[$field]) ? $requestData[$field] : false;

            if ($filterValue !== false) {
                $this->appliedFilter[$field] = $filterValue;
                if (!in_array($field, $queryIgnore)) {
                    switch ($condition) {
                        case 'equal':
                            $where[] = [$field, '=', $filterValue];
                            break;

                        case 'like':
                            $where[] = [$field, 'like', '%' . $filterValue . '%'];
                            break;

                        case 'like_right':
                            $where[] = [$field, 'like', $filterValue . '%'];
                            break;

                        case 'in':
                            $builder->whereIn($field, (array) $filterValue);
                            break;

                        case 'numbers':
                            $numbers = array_filter(preg_split('/\D+/', $filterValue));
                            if ($numbers) {
                                $builder->whereIn($field, $numbers);
                            }
                            break;
                        
                        case 'manual':
                            $methodName = 'apply'
                            . str_replace('_', '', mb_convert_case($field, MB_CASE_TITLE, "UTF-8"))
                            . 'Filter';
                            if (method_exists($this, $methodName)) {
                                $builder = $this->{$methodName}($request, $builder);
                            }
                            break;
                    }
                }
            }
        }
        
//        session([$request->route()->getName() . 'filter' => $this->appliedFilter]);
        
        if ($where) {
            $builder->where($where);
        }

        return $builder;
    }

    /**
     * Get filter
     *
     * @return array
     */
    private function getFilter()
    {
        return $this->appliedFilter;
    }
}
