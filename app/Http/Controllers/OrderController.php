<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Image;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Auth;

class OrderController extends Controller
{
    protected $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = new Repository($orderModel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderModel->all();

        return view('admin.order_list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id)
    {
        $orderDetails = OrderDetail::with(['product.images' => function($query) {
            $query->where('active', 1)->get();
        }])->with('size', 'toppings')
        ->where('order_id', $id)
        ->get();

        return $orderDetails;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->orderModel->update([
            'receiver' => $request->receiver,
            'order_phone' => $request->order_phone,
            'order_place' => $request->order_place,
            'note' => $request->note,
            'status' => $request->status,
        ], $id);

        return redirect()->route('admin.order.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id == 2) {
            return response()->json(['errors' => 'Not authorized.'], 403);
        }
        $this->orderModel->delete($id);

        return redirect()->route('admin.order.index');
    }

    public function getALl()
    {
        $orders = $this->orderModel->all();

        return datatables($orders)->make(true);
    }

    public function changStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        if ($order->status == 1 || $order->status == -1) {
            return Response::json(__('Order can not be change'), 500);
        }
        $this->orderModel->update([
            'status' => $request->status,
        ], $request->id);
    }
}
