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
                                <th>Vendedor</th>
                                <th>Monto</th>
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
                order: [[ 1, "asc" ]],
                ajax: {
                    url: '{{route('admin.informe.ventasvendedor.tabla')}}',
                    data: function (d) {
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'vendedor', name: 'vendedor'},
                    {data: 'monto', name: 'monto'}
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

