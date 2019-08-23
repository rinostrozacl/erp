@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">

        @php
            if($sucursal){
                $msg_bt= "Actualizar";
                 $msg_h4= "Editar sucursal";
                 $bodega_id = $sucursal->bodega_id;
                 $impresora_id = $sucursal->impresora_id;
            }else{
                 $msg_bt= "Guardar Nuevo regisro";
                  $msg_h4= "Nueva sucursal";
                  
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
                                <input type="text" class="form-control" name="id" readonly value="{{$sucursal->id ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Nombre</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="nombre"  value="{{$sucursal->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="bodega_id">Bodega</label>

                            <div class="col-md-10">
                            <select class="form-control" id="bodega_id" name="bodega_id">
                                <option value="0">Seleccione</option>
                                    @foreach($ubicaciones as $ubicacion)
                                        <option value="{{$ubicacion->id}}" <?php if($bodega_id == $ubicacion->id) echo "selected";?>>{{$ubicacion->nombre}}</option>
                                    @endforeach
                            </select>
                                {{-- <input type="text" class="form-control" name="bodega_id"   value="{{$sucursal->ubicacion->nombre  ?? ''}}"> --}}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="impresora_id">Impresora</label>

                            <div class="col-md-10">
                                <select class="form-control" id="impresora_id" name="impresora_id">
                                    <option value="0">Seleccionar</option>
                                        @foreach($impresoras as $impresora)
                                            <option value="{{$impresora->id}}" <?php if($impresora_id == $impresora->id) echo "selected";?> >{{$impresora->nombre}}</option>
                                        @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" name="bodega_id"   value="{{$sucursal->impresora->nombre  ?? ''}}"> --}}
                            </div><!--col-->
                        </div><!--form-group-->


                        


                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <a class="btn btn-danger btn-sm" href="{{route('admin.general.sucursal')}}">Cancelar</a>
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
                    url: "{{ route('admin.general.sucursal.form.update') }}",
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

