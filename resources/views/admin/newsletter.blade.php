<div>
    <div class="col-lg-offset-1 col-md-10" style="padding-top: 2%;">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Send NewsLetter</h3>
            </div>
            <!-- /.box-header -->
            <form method="POST" action="{{route('admin.newsletter.send')}}" >
                @csrf
            <div class="box-body">
                <div class="form-group">
                    <label>
                        <input type="checkbox" class="minimal" checked name="only_subscribed">
                        To all subscribed Accounts
                    </label>
                    <div class="form-group">
                        <label>Select Users</label>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                                style="width: 100%;" disabled="true" name="custom_users[]">
                            @foreach($usersAccounts as $userAccount)
                                <option value="{{$userAccount->id}}">{{$userAccount->first_name . ' ' .$userAccount->last_name}}</option>
                            @endforeach
                        </select>
                        <label>Select Companies</label>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                                style="width: 100%;" disabled="true" name="custom_company[]">
                            @foreach($companiesAccounts as $companyAccount)
                                <option value="{{$companyAccount->id}}">{{$companyAccount->company}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Subject:" name="subject">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 300px" name="body"></textarea>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                </div>
            </div>
            <!-- /.box-footer -->
            </form>
        </div>
        <!-- /. box -->
    <!-- /.content -->
    <div class="clearfix"></div>
    </div>
</div>
<script src="http://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    $(function(){
        $('#compose-textarea').ckeditor();
    });

    $(':checkbox').click(function(){
    // alert('asd');
        console.log(this.checked);
        $('.select2').attr('disabled',this.checked)
    });
</script>
