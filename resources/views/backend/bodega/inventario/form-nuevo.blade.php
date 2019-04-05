@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Generar nuevo inventario
                        <small class="text-muted"></small>
                    </h4>
                    <div class="alert alert-danger" style="display:none"></div>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">




                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Linea</label>
                        <div class="col-md-10">
                            @component('backend.component.select-form',
                                [
                                'name' => 'linea_id',
                                'lista' => $lineas,
                                'valor_seleccionado' => 0,
                                'msg_o' => "Todos",
                                'elemento_editar' => null,
                                'enlazado' => true,
                                'enlazado_destino' => 'familia_id',
                                'enlazado_ruta'=> route('admin.global.combo.familiabylinea'),
                                ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Familia</label>
                        <div class="col-md-10">
                            @component('backend.component.select-form',
                               [
                               'name' => 'familia_id',
                               'lista' => $familias,
                               'valor_seleccionado' => 0,
                               'msg_o' => "Todos",
                               'elemento_editar' => null,
                               ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Producto</label>
                        <div class="col-md-10">
                            @component('backend.component.select-form',
                                [
                                'name' => 'producto_id',
                                'lista' => $productos,
                                'valor_seleccionado' => 0,
                                'msg_o' => "Todos",
                                'elemento_editar' => null,
                                ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Ubicacion</label>
                        <div class="col-md-10">
                            @component('backend.component.select-form',
                                [
                                'name' => 'ubicacion_id',
                                'lista' => $ubicacion,
                                'valor_seleccionado' => 0,
                                'msg_o' => "Todos",
                                'elemento_editar' => null,
                                ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->


                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a class="btn btn-danger btn-sm" href="{{route('admin.bodega.inventario')}}">Cancelar</a>
                </div><!--col-->

                <div class="col text-right">
                    <button class="btn btn-success btn-sm pull-right" type="submit" id="guardar">
                        Nuevo inventario
                    </button>

                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
        @csrf
    </form>
@endsection


@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#formulario-editar').submit(function(e){
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('admin.bodega.inventario.nuevo') }}",
                    method: 'post',
                    data: $('#formulario-editar').serialize(),
                    success: function(data){
                        if(data.estado==1){
                            bootbox.alert(data.mensaje, function(){
                                history.back(-1);
                            });

                        }
                    }
                });


            });
        });

    </script>
@endpush

