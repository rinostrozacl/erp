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
                       
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->


                <div class="col">
                    <div class="card">
                        <div class="card-header">Datos del cliente
                            <div class="card-header-actions">

                                <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCliente" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>

                            </div>
                        </div><!--card-header-->
                        <div class="collapse show" id="collapseCliente" style="">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">Nombre</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="nombre"  readonly value="{{$cliente->nombre}}">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">RUT</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="nombre"  readonly value="{{$cliente->rut}}">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">Teléfono</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="nombre"  readonly value="{{$cliente->telefono}}">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">Crédito</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="nombre"  readonly value="{{$cliente->credito}}">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">Crédito máximo</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="nombre"  readonly value="{{$cliente->credito_maximo}}">
                                    </div><!--col-->
                                </div><!--form-group-->



                            </div><!--card-body-->
                        </div><!--collapse-->
                </div><!--col-->




            <div class="row mt-4">
                <div class="col">
                
                    <form method="POST" id="form_filtros" role="form">
                        <div class="card">
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
                                    
                                        <label for="fecha_inicio" class="col-sm-2">Fecha Inicio</label>
                                        <input class="form-control col-sm-2" id="fecha_inicio" name="fecha_inicio" type="date">
                                        <label for="fecha_fin" class="col-sm-2">Fecha Fin</label>
                                        <input class="form-control col-sm-2" id="fecha_fin" name="fecha_fin" type="date">

                                        <div class="col-sm-4">
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
                                <th>Estado venta</th>
                                <th>Total</th>
                                <th>Pagado</th>
                                <th>Deuda</th>
                                <th>Días vencidos</th>
                                <th>Fecha de ingreso</th>
                                <th>Adjunto</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                ajax: {
                    url: '{{route('admin.informe.cliente.form.tabla',$cliente->id)}}',
                    data: function (d) {
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'venta_estado_id', name: 'venta_estado_id'},
                    {data: 'total', name: 'total'},
                    {data: 'pagado', name: 'pagado'},
                    {data: 'pendiente_pago', name: 'pendiente_pago'},
                    {data: 'iva', name: 'iva'},
                    {data: 'created_at', name: 'created_at'},
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

