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
                    <h4 class="card-title mb-0">
                        Listado de ventas
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->








            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <form method="POST" id="form_filtros" role="form">
                        <div class="card-header">Filtros
                            <div class="card-header-actions">

                                <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>

                            </div>
                        </div><!--card-header-->
                        <div class="collapse show" id="collapseExample" style="">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="vat" class="col-sm-1">Tipo</label>
                                    <select class="form-control col-sm-2" id="venta_estado_id" name="venta_estado_id">
                                        <option value="0">Todos</option>
                                        @foreach ($venta_estado as $estado)
                                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                        @endforeach

                                         
                                    </select>

                                    <label for="vat" class="col-sm-1">Usuario</label>
                                    <select class="form-control col-sm-2" id="user_id" name="user_id">
                                        <option value="0">Todos</option>
                                        @foreach ($usuarios as $usuario)
                                            <option value="{{$usuario->id}}">{{$usuario->first_name}} {{$usuario->last_name}} </option>
                                        @endforeach

                                         
                                    </select>




                                    <label for="fecha_inicio" class="col-sm-1">F. Inicio</label>
                                    <input class="form-control col-sm-2" id="fecha_inicio" name="fecha_inicio" type="date">
                                    <label for="fecha_fin" class="col-sm-1">F. Fin</label>
                                    <input class="form-control col-sm-2" id="fecha_fin" name="fecha_fin" type="date">

                                    <div class="col-sm-3">
                                        <button class="btn btn-md btn-success" type="submit" id="btn_filtrar">Filtrar</button>                                </div>
                                    </div>

                            </div><!--form-group-->
                        </div><!--card-body-->
                    </div><!--collapse-->
                </form>

                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>Neto</th>
                                <th>Iva</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Efectuado por</th>
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
                order: [[ 0, "desc" ]],
                ajax: {
                    url: '{{route('admin.informe.ventas.tabla')}}',
                    data: function (d) {
                        d.venta_estado_id =   parseInt($('#venta_estado_id').val());   
                        d.user_id =  parseInt($('#user_id').val());   
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'estado', name: 'estado'},
                    {data: 'cliente_id', name: 'cliente_id'},
                    {data: 'suma_neto', name: 'suma_neto'},
                    {data: 'iva', name: 'iva'},
                    {data: 'total', name: 'total'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]

            });

            $('#form_filtros').on('submit', function(e) {
                $('#btn_filtrar').removeAttr("disabled");
                tabla.draw();
                e.preventDefault();
            });

        });


    </script>

@endpush

