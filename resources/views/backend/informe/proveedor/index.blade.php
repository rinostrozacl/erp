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
                        Informe de Compras por Proveedor / General
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


                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="proveedor-tab" data-toggle="tab" href="#proveedor" role="tab" aria-controls="proveedor" aria-selected="true">Por proveedor</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">Estado General</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                        <!-- Tab proveedor-->
                        <div class="tab-pane fade show active" id="proveedor" role="tabpanel" aria-labelledby="proveedor-tab">
                            <div class="table-responsive">
                                <table class="table" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>RUT</th>
                                        <th>@lang('labels.general.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        </div>
                        
                        <!-- Tab general -->
                        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                        
                        
                    <div class="card">
                        <div class="card-header">Información
                            <div class="card-header-actions">

                                <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCliente" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>

                            </div>
                        </div><!--card-header-->
                        <div class="collapse show" id="collapseCliente" style="">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="nombre">Periodo</label>
                                    <div class="col-md-3">
                                        <select class="form-control">
                                            <option>09-2019</option>
                                        </select>
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="nombre">Cant. Boletas</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="nombre"  readonly value="2">
                                    </div><!--col-->

                                    <label class="col-md-3 form-control-label" for="nombre">Total Boletas</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="nombre"  readonly value="2">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="nombre">Cant. Facturas</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="nombre"  readonly value="2">
                                    </div><!--col-->

                                    <label class="col-md-3 form-control-label" for="nombre">Total Facturas</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="nombre"  readonly value="2">
                                    </div><!--col-->
                                </div><!--form-group-->




                            </div><!--card-body-->
                        </div><!--collapse-->

                            <div class="table-responsive">
                                <table class="table" id="datatableg">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo de documento</th>
                                        <th>Nro. Documento</th>
                                        <th>Valor neto</th>
                                        <th>IVA</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Días transcurridos</th>
                                        <th>Fecha compra</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
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
                    url: '{{route('admin.informe.proveedor.tabla')}}'
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'rut', name: 'rut'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]

            });

        });


        jQuery(document).ready(function(){
            var tablag= $('#datatableg').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('admin.informe.proveedor.tablag')}}'
                },

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'doc_tipo_compra_id', name: 'doc_tipo_compra_id'},
                    {data: 'nro_documento', name: 'nro_documento'},
                    {data: 'valor_neto', name: 'valor_neto'},
                    {data: 'valor_iva', name: 'valor_iva'},
                    {data: 'valor_total', name: 'valor_total'},
                    {data: 'is_pagado', name: 'is_pagado'},
                    {data: 'dias', name: 'dias'},
                    {data: 'created_at', name: 'created_at'}
                ]

            });

        });


    </script>

@endpush

