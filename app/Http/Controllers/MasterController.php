<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Carrying;
use App\Models\Inquiry;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show Customer list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_customer(Request $request)
    {
        $name = $request->input('name');
        $old['name'] = $name;
        $name = "%".$name."%";

        $customer_model = new Customer();
        $customers = $customer_model->get_data($name);

        return view('customer', [
            'customers' => $customers,
            'old' => $old,
            'per_page' => 10
        ]);
    }

    /**
     * Show Carrying list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_carrying(Request $request)
    {
        $date = $request->input('date');
        $goods = $request->input('goods');
        $old['date'] = $date;
        $old['goods'] = $goods;
        $goods = "%".$goods."%";

        $carrying_model = new Carrying();
        $carries = $carrying_model->get_data($date, $goods);

        return view('carrying', [
            'carries' => $carries,
            'old' => $old,
            'per_page' => 10
        ]);
    }

    public function show_inquiry(Request $request)
    {
        $shop_name = $request->input('shop_name');
        $old['shop_name'] = $shop_name;
        $shop_name = "%".$shop_name."%";

        $inquiry_model = new Inquiry();
        $inquiries = $inquiry_model->get_data($shop_name);

        return view('inquiry', [
            'inquiries' => $inquiries,
            'old' => $old,
            'per_page' => 10
        ]);
    }

}
