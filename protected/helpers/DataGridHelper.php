<?php

class DataGridHelper {

    public static $_ar_non_filterable_vars = array(
        'page' => 'pageNumber',
        'rows' => 'pageSize',
        'order' => 'order',
        'sort' => 'sortBy'
    );

    public static function processFilterableVars($query_object, $ar_filterable, $ar_filter_keys, $tab_prefix = 't', $sub_query_object = NULL) {

        foreach ($ar_filterable as $key => $where) {

            if ($ar_filterable[$key] != '') {
                if (in_array($key, $ar_filter_keys)) {

                    if ($key == 'status') {
                        $query_object->andWhere($tab_prefix . '.' . $key . '=:' . $key, array(':' . $key => $where));

                        if (!empty($sub_query_object)) {
                            $sub_query_object->andWhere($tab_prefix . '.' . $key . '=:' . $key, array(':' . $key => $where));
                        }
                    }

                    if (is_numeric($where) && $key != 'status') {
                        $query_object->andWhere($key . '=:' . $key, array(':' . $key => $where));

                        if (!empty($sub_query_object)) {
                            $sub_query_object->andWhere($key . '=:' . $key, array(':' . $key => $where));
                        }
                    }

                    if (!is_numeric($where)) {
                        $query_object->andWhere(array('like', $key, '%' . $where . '%'));
                        if (!empty($sub_query_object)) {
                            $sub_query_object->andWhere(array('like', $key, '%' . $where . '%'));
                        }
                    }
                }
            }
        }
        return array($query_object, $sub_query_object);
    }

}
