@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h2 class="card-title mb-0">
                        Gestion de descuentos para el cliente: {{$cliente->nombre}}
                    </h2>
                    <h5 class="card-title mb-0">
                        Descuentos aplicables a lineas
                    </h5>

                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.general.cliente.descuento.nuevo.linea',$cliente->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i> Agregar nuevo descuento a una linea</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table class="table" id="datatable1">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Linea</th>
                                <th>Porcentaje</th>
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








    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h5 class="card-title mb-0">
                        Descuentos aplicables a Familias
                    </h5>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.general.cliente.descuento.nuevo.familia',$cliente->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i> Agregar nuevo descuento a una familia</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table class="table" id="datatable2">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Familia</th>
                                <th>Porcentaje</th>
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



    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h5 class="card-title mb-0">
                        Descuentos aplicables a Productos
                    </h5>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.general.cliente.descuento.nuevo.producto',$cliente->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i>Agregar nuevo descuento a un producto</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table class="table" id="datatable3">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Porcentaje</th>
                                <th>Pesos</th>
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
            var tabla1= $('#datatable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.general.cliente.descuento.tabla1',$cliente->id)}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'linea', name: 'linea'},
                    {data: 'porcentaje', name: 'porcentaje'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            var tabla2= $('#datatable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.general.cliente.descuento.tabla2',$cliente->id)}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'familia', name: 'familia'},
                    {data: 'porcentaje', name: 'porcentaje'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

             var tabla3= $('#datatable3').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.general.cliente.descuento.tabla3',$cliente->id)}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'producto', name: 'producto'},
                    {data: 'porcentaje', name: 'porcentaje'},
                    {data: 'pesos', name: 'pesos'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });







            jQuery('#datatable1 tbody').on( "click", ".bt-eliminar-linea",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.general.cliente.descuento.eliminar.DescuentoLinea') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        if(data.estado==1){
                            alert(data.msg);
                            tabla1.ajax.reload();
                        }

                    }

                });
            });

            jQuery('#datatable2 tbody').on( "click", ".bt-eliminar-familia",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.general.cliente.descuento.eliminar.DescuentoFamilia') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        if(data.estado==1){
                            alert(data.msg);
                            tabla2.ajax.reload();
                        }

                    }

                });
            });



            jQuery('#datatable3 tbody').on( "click", ".bt-eliminar-producto",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.general.cliente.descuento.eliminar.DescuentoProducto') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        if(data.estado==1){
                            alert(data.msg);
                            tabla3.ajax.reload();
                        }

                    }

                });
            });



        });


    </script>
@endpush

