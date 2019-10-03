@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">

        @php
            if($movimiento){
                $msg_bt= "Actualizar";
                 $msg_h4= "Detalle movimiento";
            }else{
                 $msg_bt= "Guardar Nuevo regisro";
                  $msg_h4= "Nuevo movimiento";
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
                                <input type="text" class="form-control" name="id" readonly value="{{$movimiento->id ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="nombre">Tipo de movimiento</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="nombre"  readonly value="{{$movimiento->movimiento_tipo->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="rut">Origen</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="rut" readonly  value="{{$movimiento->ubicacion_origen->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="rut">Destino</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->ubicacion_destino->nombre  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="rut">Efectuado por</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->usuario->first_name . " " . $movimiento->usuario->last_name  ?? ''}}">
                            </div><!--col-->
                        </div><!--form-group-->
                        
                        @if ($movimiento->movimiento_tipo_id == 1)

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">Nombre proveedor</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->proveedor->nombre ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">RUT proveedor</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->proveedor->rut ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">Tipo documento</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->doc_tipo_compra->nombre ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">Neto</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->valor_neto ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">IVA</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->valor_iva ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="rut">Total</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rut"  readonly value="{{$movimiento->compra->valor_total ?? ''}}">
                                </div><!--col-->
                            </div><!--form-group-->
                            
                        @endif

                        <div class="card">
                            <div class="card-header">Detalle de unidades creadas
                                {{--<span class="badge badge-pill badge-danger float-right">{{$movimiento->cantidad  ?? ''}}</span>--}}
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre del producto</th>
                                        <th>Valor neto venta</th> 
                                        <th>Eliminar Unidad</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @php
                                        $producto_id = 0;
                                    @endphp
                                    @foreach ($movimiento->unidad_movimiento as $um)
                                        @if($um->unidad->producto_id != $producto_id )
                                            <tr class="producto_{{$um->unidad->producto_id}}">
                                                <td colspan="3">{{$um->unidad->producto->nombre}}</td> 
                                                <td> {{-- <button class="btn btn-danger btn-sm pull-right eliminar-producto" type="button" 
                                                    data-unidad_movimiento_id="{{$um->id}}" 
                                                    data-movimiento_id="{{$movimiento->id}}" 
                                                    data-unidad_id="{{$um->unidad_id}}" 
                                                    data-producto_id="{{$um->unidad->producto_id}}" >
                                                        Eliminar Todos
                                                    </button> --}}
                                                </td>
                                            </tr>
                                            @php
                                                $producto_id = $um->unidad->producto_id ;
                                            @endphp
                                        @endif

                                        
                                        <tr id="unidad_{{$um->id}}" class="producto_{{$um->unidad->producto_id}}">
                                            <td>{{$um->unidad->producto->codigo_ean13}}</td>
                                            <td>{{$um->unidad->producto->nombre}}</td>
                                            <td>{{$um->unidad->producto->valor_neto_venta}}</td> 
                                            <td>  
                                                @if($um->unidad->producto->is_vendido)
                                                    Vendido
                                                @else
                                                <button class="btn btn-danger btn-sm pull-right eliminar-unidad" type="button"  
                                                    data-unidad_movimiento_id="{{$um->id}}" 
                                                    data-unidad_id="{{$um->unidad_id}}" 
                                                    data-producto_id="{{$um->unidad->producto_id}}"  >
                                                    Eliminar
                                                </button>
                                                @endif

                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>




                    </div><!--col-->
                </div><!--row mt4-->


            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <a class="btn btn-danger btn-sm" href="{{route('admin.informe.movimiento')}}">Volver</a>
                    </div><!--col-->

                    {{--<div class="col text-right">
                        <button class="btn btn-success btn-sm pull-right" type="submit" id="guardar">
                            {{$msg_bt}}
                        </button>

                    </div><!--row-->--}}
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
        @csrf
    </form>
@endsection


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){


            
            $('.eliminar-unidad').click(function(){
                var unidad_id =   $(this).data('unidad_id');
                var producto_id =   $(this).data('producto_id');
                var unidad_movimiento_id =   $(this).data('unidad_movimiento_id');
                
                $.ajax({
                    url: "{{ route('admin.informe.movimiento.eliminar.unidad') }}",
                    method: 'post',
                    data: { unidad_id:unidad_id,
                            producto_id:producto_id,
                            unidad_movimiento_id:unidad_movimiento_id 
                    },
                    success: function(data){
                        /*jQuery.each(data.errors, function(key, value){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>'+value+'</p>');
                        }); */
                        $('#unidad_'+unidad_movimiento_id).remove();
                                                
                    }

                });

            });


            $('.eliminar-producto').click(function(){
                var unidad_id =   $(this).data('unidad_id');
                var producto_id =   $(this).data('producto_id');
                var unidad_movimiento_id =   $(this).data('unidad_movimiento_id');
                var movimiento_id =   $(this).data('movimiento_id');
                
                $.ajax({
                    url: "{{ route('admin.informe.movimiento.eliminar.producto') }}",
                    method: 'post',
                    data: { unidad_id:unidad_id,
                            producto_id:producto_id,
                            unidad_movimiento_id:unidad_movimiento_id,
                            movimiento_id:movimiento_id
                    },
                    success: function(data){
                        /*jQuery.each(data.errors, function(key, value){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>'+value+'</p>');
                        }); */
                        //$('#producto'+producto_id).remove();
                           // alert("eliminado");                        
                    }

                });

            });




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

