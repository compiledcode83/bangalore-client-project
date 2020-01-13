<div>

    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div>
    </div>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> ITC Promotions, Inc.
                    <small class="pull-right">Date: 2/10/2014</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
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
                            <td>{{$item->productAttributeValue->sku}}</td>
                            <td>{{$item->productAttributeValue->product->description_en}}</td>
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
                <p class="lead">Payment Methods:</p>
                <img src="../../dist/img/credit/visa.png" alt="Visa">
                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="../../dist/img/credit/american-express.png" alt="American Express">
                <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead"> Amount Due 2/22/2014 </p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{$order->total}} KWD</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>0</td>
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
