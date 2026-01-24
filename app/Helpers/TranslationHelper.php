<?php

if (!function_exists('trans_model')) {
    function trans_model($model, $field, $fallback = '') {
        if (!$model) {
            return __($fallback);
        }
        
        $value = $model->getTranslation($field, app()->getLocale(), false);
        
        if (empty($value)) {
            return __($fallback);
        }
        
        return $value;
    }
}
