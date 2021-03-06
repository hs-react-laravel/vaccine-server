<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 't_coupon';

    protected $fillable = [
        'title', 'content', 'from_date', 'to_date', 'shop_id', 'reuse', 'agree', 'thumbnail'
    ];

    public static function get_data() {
        $coupons =  DB::table('v_coupon')
                    ->latest()
                    ->paginate(10);
        return $coupons;
    }

    public static function get_agree_data() {
        $coupons =  self::with('shop')
                    ->where('agree','=',1)
                    ->latest()
                    ->paginate(10);
        return $coupons;
    }

    public static function get_application_data() {
        $coupons =  self::where('agree','=',0)->latest()->paginate(10);
        return $coupons;
    }

    public static function get_coupon($id) {
        $coupon =  DB::table('v_coupon')
                    ->where('id', '=', $id)
                    ->first();
        return $coupon;
    }

    public static function get_coupon_by_shop_id($shopID, $customerID)
    {
        $myShopCoupon = Coupon::where('shop_id', $shopID)
            ->where('from_date', '<=', date('Y-m-d'))
            ->where('to_date', '>=', date('Y-m-d'))
            ->where('agree', 1)
            ->get();
        $commonCoupon = Coupon::where('shop_id', 0)
            ->where('from_date', '<=', date('Y-m-d'))
            ->where('to_date', '>=', date('Y-m-d'))
            ->get();
        $usedCoupon = DB::table('v_customer_coupon')->where('f_customer', $customerID)->where('to_date', '>', date('Y-m-d', time() - 60 * 60 * 24))
            ->get();
        $_usedCoupon = [];
        $_usedCouponState = [];
        $_isExpireList = [];
        if (count($usedCoupon) > 0) {
            foreach ($usedCoupon as $coupon) {
                $_usedCoupon[] = $coupon->f_coupon;
                $_usedCouponState[] = $coupon->f_state;
                $_isExpireList[] = $coupon->f_state == 0 && date('Y-m-d H:i:s', time() - 60 * 60 * 24) >= $coupon ->f_expire_date;
            }
        }
        return array($myShopCoupon, $commonCoupon, $_usedCoupon, $_usedCouponState, $_isExpireList);
    }

    public static function expire_customer_coupon($customerID, $couponID)
    {
        DB::table('t_customer_coupon')
            ->where('f_coupon', $couponID)
            ->where('f_customer', $customerID)
            ->update(['f_state' => 0, 'f_expire_date' => date('Y-m-d H:i:s')]);
    }

    public static function get_coupon_by_customer($customer_id, $shop_id)
    {
        $coupon = DB::table('v_customer_coupon')->where('shop_id', $shop_id)->where('f_customer', $customer_id)
            ->latest()->get();
        return $coupon;
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
