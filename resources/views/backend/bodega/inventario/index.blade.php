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
    <div class="card" id="tablas">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-2">
                      Herramienta de inventarios <small class="text-muted"> </small>
                    </h4>
                    <p class="mb-0">
                       <b>Inventarios abiertos:</b> Se deben ingresar los productos.
                    </p>
                    <p class="mb-0">
                        <b>Inventarios cerrados:</b> Han terminado el proceso de inventariado, se cotejan las diferencias.
                    </p>
                    <p>
                        <b>Inventarios Archivados:</b> Solo disponible para consulta a modo de historico.
                    </p>
                </div><!--col-->

                <div class="col-sm-7">

                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.bodega.inventario.nuevo') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i> Nuevo</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <h5  class="pt-1" >
                        Inventarios abiertos <small class="text-muted">Los inventarios abiertos corresponden a inventarios que deben realizarse actualmente. </small>
                    </h5>
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Fecha ingreso</th>
                                <th>Ubicacion</th>
                                <th>Producto</th>
                                <th>Familia</th>
                                <th>Linea</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <h5  class="pt-1" >
                        Inventarios cerrados <small class="text-muted">Los inventarios cerrados corresponden a inventarios realizados, en los cuales pueden verse las diferencias encontradas. </small>
                    </h5>
                    <div class="table-responsive">
                        <table class="table" id="datatable2">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Fecha ingreso</th>
                                <th>Ubicacion</th>
                                <th>Producto</th>
                                <th>Familia</th>
                                <th>Linea</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <h5  class="pt-1" >
                        Inventarios archivados <small class="text-muted"> Los inventarios archivados correnponden a informacion historica de inventarios</small>
                    </h5>
                    <div class="table-responsive">
                        <table class="table" id="datatable3">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Fecha ingreso</th>
                                <th>Ubicacion</th>
                                <th>Producto</th>
                                <th>Familia</th>
                                <th>Linea</th>
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
            var tabla= $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.inventario.tabla')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'usuario', name: 'usuario'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'producto', name: 'producto'},
                    {data: 'familia', name: 'familia'},
                    {data: 'linea', name: 'linea'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });




            var tabla2= $('#datatable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.inventario.tabla2')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'usuario', name: 'usuario'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'producto', name: 'producto'},
                    {data: 'familia', name: 'familia'},
                    {data: 'linea', name: 'linea'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            var tabla3= $('#datatable3').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.inventario.tabla3')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'usuario', name: 'usuario'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'producto', name: 'producto'},
                    {data: 'familia', name: 'familia'},
                    {data: 'linea', name: 'linea'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });





            jQuery('#tablas ').on( "click", ".bt-cerrar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.bodega.inventario.cerrar') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        if(data.estado==1){
                            alert(data.msg);
                            tabla.ajax.reload();
                            tabla2.ajax.reload();
                           
                        }

                    }

                });
            });





            jQuery('#tablas').on( "click", ".bt-archivar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.bodega.inventario.archivar') }}",
                    method: 'post',
                    data: { 
                        id: id, 
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },
                    success: function(data){
                        if(data.estado==1){

                            

                            var result= confirm("Está seguro que desea archivarlo?");
                                if(result) {
                                    alert(data.msg);
                                    tabla2.ajax.reload();
                                    tabla3.ajax.reload();
                                }
                          
                        }

                    }

                });
            });




        });


    </script>


@endpush

