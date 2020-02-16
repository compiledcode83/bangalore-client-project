<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Import Excel File</h3>
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
            @php
                Session::forget('message');
            @endphp
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" action="{{ route('admin.import.products.store') }}" method="POST" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                @csrf
                <input type="file" name="file" class="form-control">
                <br />
                <p class="help-block" style="font-size: 12px;line-height: 0.5;"> * Make sure all products have uniq SkU.</p>
                <p class="help-block" style="font-size: 12px;line-height: 0.5;"> * Upload only excel file.</p>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
