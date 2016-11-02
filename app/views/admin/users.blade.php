@extends('layouts.main')
@section ('header')
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.4/css/jquery.dataTables.min.css">
@stop
@section('content')

<div class="row">
  <div class="col-md-12">
  <h3>Users</h3>
  {{ $table->render() }}
  {{ $table->script() }}
  </div>
</div>
@stop

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.4/js/jquery.dataTables.min.js"></script>
@stop