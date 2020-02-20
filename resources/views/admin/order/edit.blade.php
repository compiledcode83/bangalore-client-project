<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Order Details</h3>
    </div>
    <form method="POST" action="{{route('admin.order.updateDetails')}}" >
        @csrf
        <!-- /.box-header -->
        <div class="box-body">
                <!-- text input -->
            <div class="row">
                <div class="form-group col-xs-4">
                    <label style="font-weight: normal">Buyer</label>
                    @if($order->user->type == '1')
                        <label>Individual Name</label>
                        <input type="text" class="form-control" value="{{$order->user->first_name.' '.$order->user->last_name}}" disabled>
                    @elseif($order->user->type == '2')
                        <label>Company Name</label>
                        <input type="text" class="form-control" value="{{$order->user->company}}" disabled>
                    @endif
                </div>
                <div class="form-group col-xs-4">
                    <label>Order Code</label>
                    <input type="text" class="form-control" value="{{$order->order_code}}" disabled>
                    <input type="hidden" class="form-control" name="order" value="{{$order->id}}">
                </div>
                <div class="form-group col-xs-4">
                    <label>Address</label>
                    <input type="text" class="form-control" value="{{$order->address}}" name="address">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-4">
                    <label>Total</label>
                    <input type="text" class="form-control" value="{{$order->total}}" disabled>
                </div>
                <div class="form-group col-xs-4">
                    <label>Order Status</label>
                    <select class="input-lg" name="status">
                        <option> Select Order status</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}" @if($order->final_status == $status->name_en) selected @endif>{{$status->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @foreach($order->orderItems as $item)
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Product: {{$item->productAttributeValue->product->name_en}}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product Image</th>
                                    <th>To be printed on</th>
                                    <th>Unit Price</th>
                                    <th>Color</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$item->qty}}</td>
                                    <td><img width="100px" src="/uploads/{{$item->productAttributeValue->main_images[0]}}"></td>
                                    <td>
                                        @if($item->print_image)
                                            <a href="/{{$item->print_image}}" target="_blank">
                                                <img width="100px" src="/{{$item->print_image}}">
                                            </a>
                                            <select name="print_image_{{$item->id}}" style="display: block;"
                                                    @if($item->is_print_image_accepted) required @else required @endif>
                                                <option>Image Approval</option>
                                                <option value="approved" @if($item->is_print_image_accepted == 1) selected @endif>Approve Print Image</option>
                                                <option value="rejected" @if($item->is_print_image_accepted == 2) selected @endif>Reject Print Image</option>
                                            </select>
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>{{$item->unit_price}}</td>
                                    <td>
                                        {{$item->productAttributeValue->attributeValue->value_en}}
                                        <div title="{{$item->productAttributeValue->attributeValue->value_en}}" style="'margin-bottom: 2px;width: 20px; height: 20px; background-color:'.{{$item->productAttributeValue->attributeValue->other_value}}"></div>
                                    </td>
                                    <td>{{$item->qty * $item->unit_price}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @endforeach
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-warning btn-lg">Save</button>
        </div>
    </form>
</div>
