<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Bottle extends Model
{
    protected $table = 't_bottle';

    protected $fillable = [
        'use_type', 'amount', 'shop_id', 'customer_id', 'goods',
    ];

    // $type 1: input , 2: use, 3: delete
    public static function get_data($type, $customer_id, $shop_id) {
        if ($shop_id != 0)
            return DB::table('t_bottle')
                ->select('t_bottle.*', 't_shop.name')
                ->join('t_shop', 't_bottle.shop_id', '=', 't_shop.id')
                ->where('customer_id', $customer_id)
                ->where('shop_id', $shop_id)
                ->where('use_type', $type)
                ->latest()
                ->get();
        else
            return DB::table('t_bottle')
                ->select('t_bottle.*', 't_shop.name')
                ->join('t_shop', 't_bottle.shop_id', '=', 't_shop.id')
                ->where('customer_id', $customer_id)
                ->where('use_type', $type)
                ->latest()
                ->get();
    }

    public static function get_limit_data($type, $customer_id, $shop_id) {
            return DB::table('t_bottle')
                ->select('t_bottle.*', 't_shop.name')
                ->join('t_shop', 't_bottle.shop_id', '=', 't_shop.id')
                ->where('customer_id', $customer_id)
                ->where('shop_id', $shop_id)
                ->where('use_type', $type)
                ->latest()
                ->limit(3)
                ->get();
    }

    public static function get_remain($customer_id, $shop_id)
    {
        $input = DB::table('t_bottle')
            ->where('customer_id', $customer_id)
            ->where('shop_id', $shop_id)
            ->where('use_type', 1)
            ->sum('amount');
        $use = DB::table('t_bottle')
            ->where('customer_id', $customer_id)
            ->where('shop_id', $shop_id)
            ->where('use_type', 2)
            ->sum('amount');
        return $input-$use;
    }
}
