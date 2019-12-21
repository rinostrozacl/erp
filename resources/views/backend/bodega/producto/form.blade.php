@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <form id="formulario-editar">

        @php
            if($producto->id>0){
                $msg_bt= "Actualizar";
                 $msg_h4= "Editar producto";
            }else{
                 $msg_bt= "Guardar Nuevo producto";
                  $msg_h4= "Nuevo producto";
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
                            <input type="text" class="form-control" name="id" readonly value="{{$producto->id ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Nombre</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nombre"   value="{{$producto->nombre  ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Codigo EAN13</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="codigo_ean13"   value="{{$producto->codigo_ean13  ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Codigo ERP</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="codigo_erp"   value="{{$producto->codigo_erp  ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Descripcion</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="9" placeholder="">{{$producto->descripcion  ?? ''}}</textarea>

                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Unidad medida</label>
                        <div class="col-md-10">
                                @component('backend.component.select-form',
                                [
                                    'name' => 'unidad_medida_id',
                                    'lista' => $unidad_medidas,
                                    'valor_seleccionado' => $producto->unidad_medida_id,
                                    'elemento_editar' => $producto,
                                ])
                                @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Linea</label>
                        <div class="col-md-10">
                            @php
                                if($producto->id>0){
                                    $linea_id_selected= $producto->familia->linea_id;
                                }else{
                                    $linea_id_selected=0;
                                }
                            @endphp
                            @component('backend.component.select-form',
                                [
                                'name' => 'linea_id',
                                'lista' => $lineas,
                                'valor_seleccionado' => $linea_id_selected,
                                'elemento_editar' => $producto,
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
                               'valor_seleccionado' => $producto->familia_id,
                               'elemento_editar' => $producto,
                               ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Marca</label>
                        <div class="col-md-10">
                            @component('backend.component.select-form',
                                [
                                'name' => 'marca_id',
                                'lista' => $marcas,
                                'valor_seleccionado' => $producto->marca_id,
                                'elemento_editar' => $producto,
                                ])
                            @endcomponent
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="id">Stock disponible</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="stock_disponible" readonly value="{{$producto->stock_disponible ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="id">Stock critico</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="stock_critico"   value="{{$producto->stock_critico ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="id">Valor Neto de venta</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="valor_neto_venta"   value="{{ floatval($producto->valor_neto_venta) ?? ''}}">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="activo">Activo</label>

                        <div class="col-md-10">
                            @php
                            if($producto){
                                $activo= ($producto->activo==1)?'checked="checked"': '';
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
                    <a class="btn btn-danger btn-sm" href="{{route('admin.bodega.producto')}}">Cancelar</a>
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
                jQuery.ajax({
                    url: "{{ route('admin.bodega.producto.form.update') }}",
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

