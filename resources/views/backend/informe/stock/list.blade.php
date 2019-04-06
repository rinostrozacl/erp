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
                        Listado de stock de productos
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
                                        <label for="vat" class="col-sm-4">Ubicación</label>
                                        <select class="form-control col-sm-7" id="ubicacion_id" name="ubicacion_id">
                                            <option value="0">Seleccione</option>

                                            @foreach($ubicacion as $u)

                                                <option value="{{$u->id}}">{{$u->nombre}}</option>

                                            @endforeach
                                        </select>

                                        {{--<div class="col-sm-3">
                                            <button class="btn btn-md btn-success" type="submit" id="btn_filtrar">Filtrar</button>                                </div>
                                        </div>--}}

                                    </div><!--form-group-->

                                    <div class="form-group row">

                                    <label for="vat" class="col-sm-1">Línea</label>
                                    {{--<select class="form-control col-sm-3" id="linea_id" name="linea_id">
                                        <option value="0">Seleccione</option>

                                        @foreach($linea as $l)

                                            <option value="{{$l->id}}">{{$l->nombre}}</option>

                                        @endforeach
                                    </select>--}}

                                    @component('backend.component.select-form',
                            [
                            'name' => 'linea_id',
                            'lista' => $linea,
                            'class' => 'col-sm-4',
                            'valor_seleccionado' => 0,
                            'msg_o' => "Todos",
                            'elemento_editar' => null,
                            'enlazado' => true,
                            'enlazado_destino' => 'familia_id',
                            'enlazado_ruta'=> route('admin.global.combo.familiabylinea'),
                            ])
                                    @endcomponent

                                    <label for="vat" class="col-sm-1">Familia</label>
                                    {{--<select class="form-control col-sm-3" id="familia_id" name="familia_id">
                                        <option value="0">Seleccione</option>

                                        @foreach($familia as $f)

                                            <option value="{{$f->id}}">{{$f->nombre}}</option>

                                        @endforeach
                                    </select>--}}

                                    @component('backend.component.select-form',
                           [
                           'name' => 'familia_id',
                           'lista' => $familia,
                           'class' => 'col-sm-4',
                           'valor_seleccionado' => 0,
                           'msg_o' => "Todos",
                           'elemento_editar' => null,
                           ])
                                    @endcomponent




                                    <div class="col-sm-2">
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
                                <th>Producto</th>
                                <th>Código</th>
                                <th>Stock global</th>
                                <th>Stock por ubicación</th>
                                <th>Ubicación</th>
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

                ajax: {
                    url: '{{route('admin.informe.stock.tabla')}}',
                    data: function (d) {
                        d.ubicacion_id = $('select[name=ubicacion_id]').val();
                        d.familia_id = $('select[name=familia_id]').val();
                        d.linea_id = $('select[name=linea_id]').val();

                    }
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'codigo_ean13', name: 'codigo_ean13'},
                    {data: 'stock_global', name: 'stock_global'},
                    {data: 'stock_disponible', name: 'stock_disponible'},
                    {data: 'ubicacion_id', name: 'ubicacion_id'},
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

