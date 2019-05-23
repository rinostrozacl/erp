@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Nuevo descuento para el cliente  [{{$cliente->nombre}}] aplicable a una familia
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
                                   'elemento_editar' => null,
                                   ])
                                @endcomponent
                            </div><!--col-->
                        </div><!--form-group-->


                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Porcentaje</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="porcentaje" >
                            </div><!--col-->
                        </div><!--form-group-->

                        <input type="hidden"  name="cliente_id" value="{{$cliente->id}}" >

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <a class="btn btn-danger btn-sm" href="{{route('admin.general.cliente.indexDescuentos', $cliente->id)}}">Cancelar</a>
                    </div><!--col-->

                    <div class="col text-right">
                        <button class="btn btn-success btn-sm pull-right" type="submit" id="guardar">
                            Guardar nuevo descuento
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
            jQuery('#formulario').submit(function(e){
                e.preventDefault();
                jQuery('.alert-danger').hide();
                jQuery.ajax({
                    url: "{{ route('admin.general.cliente.descuento.nuevo.familia.save') }}",
                    method: 'post',
                    data: $('#formulario').serialize(),
                    success: function(data){
                        jQuery.each(data.errors, function(key, value){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>'+value+'</p>');
                        });
                        if(data.estado==1){
                            alert(data.mensaje);
                            history.back(-1);
                        }

                    }

                });
            });
        });

    </script>
@endpush

