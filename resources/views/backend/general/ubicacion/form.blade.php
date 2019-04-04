@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">

        @php
            if($ubicacion){
                $msg_bt= "Actualizar";
                 $msg_h4= "Editar ubicación";
            }else{
                 $msg_bt= "Guardar Nuevo regisro";
                  $msg_h4= "Nueva ubicación";
            }
        @endphp
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            {{$msg_h4}}
                            <small class="text-muted"></small>
                        </h4>
                        <div class="alert alert-danger" style="display:none"></div>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="id">ID</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="id" readonly value="{{$ubicacion->id ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Nombre</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="nombre"   value="{{$ubicacion->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Dirección</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="direccion"   value="{{$ubicacion->direccion  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <!-- checkboxes -->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">Configuración</label>

                            <div class="table-responsive col-md-10">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        if($ubicacion){
                                            $is_entrada_origen = ($ubicacion->is_entrada_origen==1)?'checked="checked"': '';
                                            $is_entrada_destino = ($ubicacion->is_entrada_destino==1)?'checked="checked"': '';
                                            $is_traslado_origen = ($ubicacion->is_traslado_origen==1)?'checked="checked"': '';
                                            $is_traslado_destino = ($ubicacion->is_traslado_destino==1)?'checked="checked"': '';
                                            $is_salida_origen = ($ubicacion->is_salida_origen==1)?'checked="checked"': '';
                                            $is_salida_destino = ($ubicacion->is_salida_destino==1)?'checked="checked"': '';

                                        }else{
                                            $is_entrada_origen='';
                                            $is_entrada_destino = '';
                                            $is_traslado_origen = '';
                                            $is_traslado_destino = '';
                                            $is_salida_origen = '';
                                            $is_salida_destino = '';
                                        }

                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_entrada_origen"><input class="switch-input" type="checkbox" name="is_entrada_origen" id="is_entrada_origen" value="1"  {{$is_entrada_origen}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_entrada_origen">Entrada</label>
                                            </div>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_traslado_origen"><input class="switch-input" type="checkbox" name="is_traslado_origen" id="is_traslado_origen" value="1"  {{$is_traslado_origen}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_traslado_origen">Traslado</label>
                                            </div>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_salida_origen"><input class="switch-input" type="checkbox" name="is_salida_origen" id="is_salida_origen" value="1"  {{$is_salida_origen}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_salida_origen">Salida</label>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_entrada_destino"><input class="switch-input" type="checkbox" name="is_entrada_destino" id="is_entrada_destino" value="1"  {{$is_entrada_destino}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_entrada_destino">Entrada</label>
                                            </div>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_traslado_destino"><input class="switch-input" type="checkbox" name="is_traslado_destino" id="is_traslado_destino" value="1" {{$is_traslado_destino}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_traslado_destino">Traslado</label>
                                            </div>
                                            <div class="checkbox d-flex align-items-center">
                                                <label class="switch switch-label switch-pill switch-primary mr-2" for="is_salida_destino"><input class="switch-input" type="checkbox" name="is_salida_destino" id="is_salida_destino" value="1" {{$is_salida_destino}}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                                                <label for="is_salida_destino">Salida</label>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            Las opciones seleccionadas aparecerán en el origen o inicio de un movimiento
                                        </td>
                                        <td>
                                            Las opciones seleccionadas aparecerán en el destino o final de un movimiento

                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!--col-->
                        </div>

                        <!-- /checkboxes-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="activo">Activo</label>

                            <div class="col-md-10">
                                @php
                                    if($ubicacion){
                                        $activo= ($ubicacion->activo==1)?'checked="checked"': '';
                                    }else{
                                        $activo='';
                                    }
                                @endphp
                                <label class="switch switch-label switch-pill switch-primary mr-2">
                                    <input type="checkbox" class="switch-input" name="activo"  {{$activo}}  value="1"><span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                </label>

                            </div><!--col-->
                        </div><!--form-group-->


                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <a class="btn btn-danger btn-sm" href="{{route('admin.general.ubicacion')}}">Cancelar</a>
                    </div><!--col-->

                    <div class="col text-right">
                        <button class="btn btn-success btn-sm pull-right" type="submit" id="guardar">
                            {{$msg_bt}}
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
                jQuery('.alert-danger').hide();
                jQuery.ajax({
                    url: "{{ route('admin.general.ubicacion.form.update') }}",
                    method: 'post',
                    data: $('#formulario-editar').serialize(),
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

