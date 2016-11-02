@extends('layouts.main')

@section('content')
  <div class="row-fluid sortable">
    <div>
      <div class="box-header row">
        <div class="col-md-6">
          <h2 class="page_header"><i class="fa fa-user"></i> Manage suppliers</h2>
        </div>

        <div class="col-md-6">
          <div class="box-icon">
            <a href="{{ URL::to('suppliers/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
          </div>
        </div>
      </div>

      <div class="box-content">
        <div class="table-responsive">
          <table class="table table-striped table-bordered datatable">
            <thead>
              <tr>
                <th class="ten">Supplier</th>
                <th class="ten">Contact</th>
                <th class="ten">Email</th>
                <th class="fifteen">Address</th>
                <th class="fifteen">Remarks</th>
                <!--  <th class="fifteen">Date Created</th>
                <th class="fifteen">Date Updated</th>-->
                <th class="ten">Actions</th>
              </tr>
            </thead>

            <tbody>
              <?php
                $i = 0; $names = array(); $emails = array();
              ?>
              @foreach($suppliers as $key => $value)
                <?php $p = 0;  ?>
                <tr>
                  <td>{{ $value->supplier_name }}</td>

                  <td class="center">
                    <?php 
                    echo $value->mobile;
                    echo '<br />';
                    $contacts = DB::table('supplier_contacts')->where('supplier_id','=',$value->id)->get() 
                    ?>
                    @foreach ($contacts as $k=>$v)
                      <?php
                      if ($v->email != "") {
                        $emails[$p] = $v->email;
                        $names[$p++] = $v->name;
                      }
                      if ($v->contact != "")
                        echo "<em>".$v->name."</em> : ".$v->contact."<br>";
                      ?>
                    @endforeach
                  </td>

                  <td class="center">
                    <?php
                    echo $value->email;
                    echo '<br />';
                    for ($m = 0; $m < $p; $m++) {
                      echo "<em>".$names[$m]."</em> : ".$emails[$m]."<br>";
                    }
                    ?>
                  </td>

                  <td class="center">
                    <i>Delivery address</i> :
                    <br>{{ $value->delivery_address }}<br>
                    <br><i>Billing address</i> :
                    <br> {{ $value->billing_address }}
                  </td>

                  <td class="center">
                    {{ $value->remarks }}
                  </td>

                  <!--<td class="center">
                    <?php //echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                  </td>

                  <td class="center">
                    <?php //echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                  </td>-->

                  <td class="center">
                    {{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'SuppliersController@delete_supplier')) }}
                      {{ Form::hidden('id',$value->id) }}
                      <a class="edit_btn" href="{{ URL::to('suppliers/'.$value->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="view_btn" href="{{ URL::to('suppliers/view/'.$value->id) }}">
                        <i class="fa fa-eye"></i>
                      </a>
                      <button type="submit" class="del_btn"><i class="fa fa-trash"></i> </button>
                    {{ Form::close() }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div><!--/span-->
  </div><!--/row-->
@stop

@section ('script')
  <script>
    var no = 0;
    $(".formdel").submit(function(ev) {
      if (no == 0) {
        var id = $(this).attr('id');
        Boxy.confirm("Are you sure?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});
        return false;
      }
    });

   /* $('.datatable').dataTable({
      // Disable initial sort 
      "aaSorting": [],
    });
    $.fn.dataTableExt.sErrMode = 'throw';*/
  </script>
@stop