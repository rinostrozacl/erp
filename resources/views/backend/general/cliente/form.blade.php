@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">

        @php
            if($cliente){
                $msg_bt= "Actualizar";
                 $msg_h4= "Editar cliente";
            }else{
                 $msg_bt= "Guardar Nuevo regisro";
                  $msg_h4= "Nuevo cliente";
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
                                <input type="text" class="form-control" name="id" readonly value="{{$cliente->id ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Nombre</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="nombre"   value="{{$cliente->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="rut">RUT</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="rut"   value="{{$cliente->rut  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->



                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="activo">Activo</label>

                            <div class="col-md-10">
                                @php
                                    if($cliente){
                                        $activo= ($cliente->activo==1)?'checked="checked"': '';
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
                        <a class="btn btn-danger btn-sm" href="{{route('admin.general.cliente')}}">Cancelar</a>
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
                    url: "{{ route('admin.general.cliente.form.update') }}",
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

