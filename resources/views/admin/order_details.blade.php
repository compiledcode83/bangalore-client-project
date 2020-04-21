<div>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> ITC Promotions, Inc.
                    <small class="pull-right">Date: {{$order->created_at}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong> Shipping Address </strong>
                <address style="width: 50%;">
                    {{$order->address}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <strong>Billing Address</strong>
                <address style="width: 50%;">
                    {{$order->billing_address}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
{{--                <b>Invoice #007612</b><br>--}}
                <b>Order ID:</b> {{$order->order_code}}<br>
                <b>Customer:</b> {{$order->user->full_name}}<br>
                <b>Customer Email:</b> {{$order->user->email}}<br>
                <b>Customer Phone:</b> {{$order->user->phone}}<br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->productAttributeValue->product->name_en}}</td>
                            <td>
                                {{$item->productAttributeValue->sku}}
                                @if($item->print_image && $item->print_image != '')
                                    - Requested print
                                @endif
                            </td>
                            <td>{{Str::substr(strip_tags($item->productAttributeValue->product->short_description_en), 0,20)}}</td>
                            <td>{{($item->unit_price * $item->qty)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead">Payment Methods: {{$order->payment_method}}</p>

            </div>
            <!-- /.col -->
            <div class="col-xs-6">

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{$order->sub_total}} KWD</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>{{$order->delivery_charges}} KWD</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td>{{$order->total_discount}} KWD</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>{{$order->total}} KWD </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="#" onclick="window.print()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
