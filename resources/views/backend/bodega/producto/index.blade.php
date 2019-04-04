@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection
@push('styles')
    <style type="text/css">
        .bg-gray {
            background-color: #e9edf1 !important;
        }
    </style>

@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                      Administracion de productos <small class="text-muted"> </small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.bodega.producto.form') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i> Nuevo</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                <th> </th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Familia</th>
                                <th>Linea</th>
                                <th>Stock</th>
                                <th>Fecha ingreso</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">

                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">

                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection


@push('scripts')
    <script type="text/javascript">

        jQuery(document).ready(function(){

            //Inicio tabla
            var template = Handlebars.compile($("#details-template").html());
            var table= $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.producto.tabla')}}',
                columns: [
                    {
                       data: 'detalles', name: 'detalles',
                        "className":      'details-control',
                        orderable:      false,
                        searchable:      false,
                        sType: "html",
                    },
                    {data: 'nombre', name: 'nombre'},
                    {data: 'marca', name: 'marca'},
                    {data: 'familia', name: 'familia'},
                    {data: 'linea', name: 'linea'},
                    {data: 'stock', name: 'stock'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#datatable tbody').on('click', 'td .bt-stock', function () {

                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var tableId = 'stocks-' + row.data().id;

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row

                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('shown');
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            });

            function initTable(tableId, data) {
                console.log(tableId);
                $('#' + tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: false,
                    ajax: data.details_url,
                    columns: [
                        { data: 'ubicacion', name: 'ubicacion' },
                        { data: 'direccion', name: 'direccion' },
                        { data: 'stock_disponible', name: 'stock_disponible' },
                        { data: 'stock_critico', name: 'stock_critico' }
                    ]
                })
            }


            //fin tabla



            jQuery('#datatable tbody').on( "click", ".bt-desactivar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                if(boton.hasClass('btn-primary')){
                    boton.removeClass('btn-primary');
                    boton.addClass('btn-secondary');
                    boton.find('span').html("Activar")

                }else{
                    boton.removeClass('btn-secondary');
                    boton.addClass('btn-primary');
                    boton.find('span').html("Desactivar")
                }
                jQuery.ajax({
                    url: "{{ route('admin.bodega.producto.activar') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        jQuery.each(data.errors, function(key, value){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>'+value+'</p>');
                        });
                        if(data.estado==1){
                            bootbox.alert(data.msg);
                        }
                    }
                });
            });

            jQuery('#datatable tbody').on( "click", ".bt-eliminar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);

                bootbox.confirm("Está seguro que desea eliminarlo?", function(result) {

                    if(result) {
                       jQuery.ajax({
                                    url: "{{ route('admin.bodega.producto.eliminar') }}",
                            method: 'post',
                            data: { id: id},
                            success: function(data){
                                if(data.estado==1){
                                    bootbox.alert(data.msg);
                                    table.ajax.reload();
                                }
                            }
                        });

                    }
                });
            });
        });


    </script>



    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="label label-info">Detalle de stock por ubicacion para el articulo {{ nombre }} </div>
        <table class="table details-table" id="stocks-{{id}}">
            <thead>
            <tr>
                <th>Ubicacion</th>
                <th>Direccion</th>
                <th>Stock Disponible</th>
                <th>Stock Critico</th>
            </tr>
            </thead>
        </table>
        @endverbatim
    </script>
@endpush

