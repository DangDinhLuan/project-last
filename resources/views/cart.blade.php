@extends('layouts.app_client')
@section('content')
<style type="text/css" media="screen">
.empty-cart-image {
  display: block;
  margin: auto;
}
</style>
<div id="breadcrumb">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="/">Trang chủ</a></li>
      <li class="active">Thanh toán</li>
    </ul>
  </div>
</div>
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      <div class="col-md-12">
        @if(count($carts))
        <div class="order-summary clearfix">
          <div class="section-title">
            <h3 class="title">Thông tin sản phẩm đã mua</h3>
          </div>
          <table class="shopping-cart-table table">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th></th>
                <th class="text-center">Giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-right"></th>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0; ?>
              @foreach($carts as $cart)
              <?php $total+= $cart['item']['product']->price * $cart['item']['quantity']; ?>
              <tr>
                <td class="thumb"><img width="75"
                  src="{{ asset('images/products/' . $cart['item']['product']->image) }}"></td>
                  <td class="details">
                    <a href="{{ route('client.product.detail', ['id' => $cart['item']['product']->id]) }}">{{ $cart['item']['product']->name }}</a>
                    <ul>
                      <li><span>Size: {{ $cart['item']['size'] }}</span></li>
                      <li><span>Màu: {{ $cart['item']['color'] }}</span></li>
                    </ul>
                  </td>
                  <td class="price text-center"><strong>{{ number_format($cart['item']['product']->price) . ' ₫' }}</strong></td>
                  <td class="qty text-center"><input data-id="{{ $cart['key'] }}" class="input quantity" min="1" max="99" type="number" value="{{ $cart['item']['quantity'] }}"></td>
                  <td class="total text-center"><strong class="primary-color">{{ number_format($cart['item']['product']->price * $cart['item']['quantity']) . ' ₫' }}</strong></td>
                  <td class="text-right">
                    <a href="{{ route('user.cart.delete', ['key' => $cart['key']]) }}"  class="main-btn icon-btn"  data-id="{{ $cart['key'] }}"><i class="fa fa-close"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th class="empty" colspan="3"></th>
                  <th>Tổng tiền</th>
                  <th colspan="2" class="total">{{ number_format($total) . ' ₫' }}</th>
                </tr>
                <tr>
                  <th class="empty" colspan="3"></th>
                  <th>SHIPING</th>
                  <td colspan="2">Free Shipping</td>
                </tr>
                <tr>
                  <th class="empty" colspan="3"></th>
                  <th>Thành tiền</th>
                  <th colspan="2" class="total">{{ number_format($total) . ' ₫' }}</th>
                </tr>
              </tfoot>
            </table>

          </div>
          <form id="form-checkout" class="clearfix">
            @csrf
            <div class="col-md-6">
              <div class="billing-details">
                <p>Bạn đã là một khách hàng ? <a href="#">Đăng nhập</a></p>
                <div class="section-title">
                  <h3 class="title">Thanh toán</h3>
                </div>
                <div class="form-group">
                  <label for="receiver">Người nhận:</label>
                  <input type="text" class="form-control" id="checkout-receiver" name="receiver" placeholder="Receirver">
                </div>
                <div class="form-group">
                  <label for="place">Địa điểm:</label>
                  <input type="text" class="form-control" id="checkout-place" name="place"
                  placeholder="Place">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" class="form-control" id="checkout-email" name="email"
                  placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="phone">Số điện thoại:</label>
                  <input type="text" class="form-control" name="phone" id="checkout-phone"
                  placeholder="Phone">
                </div>
                <div class="form-group">
                  <label for="note">Chú thích:</label>
                  <textarea class="form-control" name="note" id="checkout-note"
                  placeholder="Note"></textarea>
                </div>
                <div class="pull-right">
                  <button class="primary-btn" id="btn_checkout">Thanh Toán</button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="shiping-methods">
                <div class="section-title">
                  <h4 class="title">Shiping Methods</h4>
                </div>
                <div class="input-checkbox">
                  <input type="radio" name="shipping" id="shipping-1" checked="">
                  <label for="shipping-1">Free Shiping -  $0.00</label>
                  <div class="caption">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                    </p>
                  </div>
                </div>
                <div class="input-checkbox">
                  <input type="radio" name="shipping" id="shipping-2">
                  <label for="shipping-2">Standard - $4.00</label>
                  <div class="caption">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                    </p>
                  </div>
                </div>
              </div>
              <div class="payments-methods">
                <div class="section-title">
                  <h4 class="title">Payments Methods</h4>
                </div>
                <div class="input-checkbox">
                  <input type="radio" name="payments" id="payments-1" checked="">
                  <label for="payments-1">Direct Bank Transfer</label>
                  <div class="caption">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                    </p>
                  </div>
                </div>
                <div class="input-checkbox">
                  <input type="radio" name="payments" id="payments-2">
                  <label for="payments-2">Cheque Payment</label>
                  <div class="caption">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                    </p>
                  </div>
                </div>
                <div class="input-checkbox">
                  <input type="radio" name="payments" id="payments-3">
                  <label for="payments-3">Paypal System</label>
                  <div class="caption">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </form>
          @else
          <div>
            <img class="empty-cart-image" src="{{ asset(config('asset.image_path.public') . 'empty-cart.png') }}" alt="Your Cart Is Empty">
          </div>
          @endif
        </div>
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  @endsection
