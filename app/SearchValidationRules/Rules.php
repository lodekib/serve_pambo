<?php

namespace App\SearchValidationRules;

class Rules
{
    public static function rules(){
        return [
            'search_title'=>['string','max:50','nullable'],
            'search_price_range'=>['string','max:50','nullable'],
            'search_location'=>['string','max:50','nullable']
        ];
    }

    public static function reviewValidation(){
        return [
            'review'=>['string','required'],
            'post_id'=>['required']
        ];
    }
}
