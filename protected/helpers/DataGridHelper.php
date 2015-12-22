<?php

class DataGridHelper {

    public static $_ar_non_filterable_vars = array(
        'page' => 'pageNumber',
        'rows' => 'pageSize',
        'order' => 'order',
        'sort' => 'sortBy'
    );
    public static $_ar_button_color_class = array(
        'edit' => 'fa fa-pencil-square-o text-green',
        'update' => 'fa fa-pencil-square-o text-green',
        'view' => 'fa fa-eye text-aqua',
        'delete' => 'fa fa-trash text-red',
        'barcode' => 'fa fa-barcode text-info',
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

    public static function propagateActionLinks($data, $buttons = array()) {

        $url = '/';
        if (isset(Yii::app()->controller->module->id)) {
            $url .= Yii::app()->controller->module->id . '/';
        }
        $url .= Yii::app()->controller->id . '/';
        
        $i = 0;
        $response = [];

        if (!empty($buttons)) {

            foreach ($data as $row) {

                $actions = [];
                foreach ($buttons as $button) {
                    $actions[] = '<a href="' . $url . $button . '/id/' . $row['id'] . '"><i class="' . self::$_ar_button_color_class[$button] . '"></i></a>';
                }

                $row['action'] = implode('&nbsp;&nbsp;', $actions);
                $response[$i] = $row;
                $i++;
            }
        }
        return $response;
    }

}
