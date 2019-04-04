@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))


@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection



@section('content')


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">

                    </h4>
                </div><!--col-->


            </div><!--row-->

        <form id="formulario">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                            <div class="card-header">
                                <strong>Tipo de movimiento</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="select1">Seleccione un tipo</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select_movimiento" name="select_movimiento">
                                            <option value="0">Seleccione</option>

                                            @foreach($bag['tipo_movimiento'] as $tm)

                                            <option value="{{$tm->id}}">{{$tm->nombre}}</option>

                                            @endforeach

                                        </select>
                                    </div><!--col-->
                                </div><!--form-->
                            </div><!--card-body-->
                    </div><!--card-->




                    <div class="card" id="ocultoentrada" name="ocultoentrada" style="display: none;">
                        <div class="card-header">
                            <strong>Información de entrada</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="vat" class="col-sm-3">ORIGEN</label>
                                <select class="form-control col-sm-3" id="origen_entrada" name="origen_entrada">
                                    <option value="0">Seleccione origen</option>

                                    @foreach($bag['ubicacion_entrada_origen'] as $ubicacion_entrada_origen)

                                        <option value="{{$ubicacion_entrada_origen->id}}">{{$ubicacion_entrada_origen->nombre}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3">DESTINO</label>
                                <select class="form-control col-sm-3" id="destino_entrada" name="destino_entrada">
                                    <option value="0">Seleccione destino</option>

                                    @foreach($bag['ubicacion_entrada_destino'] as $ubicacion_entrada_destino)

                                        <option value="{{$ubicacion_entrada_destino->id}}">{{$ubicacion_entrada_destino->nombre}}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="card row">
                                <div class="card-header">
                                    <strong>Datos de la compra</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="vat" class="col-sm-2">Proveedor</label>

                                        <select class="selectpicker col-sm-10" data-live-search="true" id="select_proveedor" name="select_proveedor">

                                            <option value="0">Buscador</option>

                                            @foreach($bag['proveedor'] as $p)

                                                <option value="{{$p->id}}">{{$p->nombre}}</option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group row">
                                        <label for="vat" class="col-sm-2">Tipo documento</label>
                                        <select class="form-control col-sm-3" id="select_tipo_documento" name="select_tipo_documento">
                                            <option value="0">Seleccione</option>

                                            @foreach($bag['tipo_doc'] as $td)

                                                <option value="{{$td->id}}">{{$td->nombre}}</option>

                                            @endforeach

                                        </select>
                                        <label for="nro_documento" class="col-sm-1">Número</label>
                                        <input class="form-control col-sm-6" id="nro_documento" name="nro_documento" type="text" placeholder="Ingrese nro. documento">
                                    </div>

                                    <div class="form-group row">
                                        <label for="vat" class="col-sm-1">Neto</label>
                                        <input class="form-control col-sm-2" id="neto" name="neto" type="text">
                                        <label for="vat" class="col-sm-1">IVA</label>
                                        <input class="form-control col-sm-2" id="iva" name="iva" type="text">
                                        <label for="vat" class="col-sm-1">Total</label>
                                        <input class="form-control col-sm-2" id="total" name="total" type="text">
                                        <label for="is_pagado" class="col-sm-1">Pagado</label>
                                        <input type="checkbox" id="is_pagado" name="is_pagado" value="Pagado">
                                    </div>


                                </div>
                            </div>

                        </div><!--card-body-->

                    </div><!--card-->


                    <div class="card" id="ocultotraslado" style="display: none;">
                        <div class="card-header">
                            <strong>Información de traslado</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="vat" class="col-sm-3">ORIGEN</label>
                                <select class="form-control col-sm-3" id="origen_traslado" name="origen_traslado">
                                    <option value="0">Seleccione origen</option>

                                    @foreach($bag['ubicacion_traslado_origen'] as $ubicacion_traslado_origen)

                                        <option value="{{$ubicacion_traslado_origen->id}}">{{$ubicacion_traslado_origen->nombre}}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3">DESTINO</label>
                                <select class="form-control col-sm-3" id="destino_traslado" name="destino_traslado">
                                    <option value="0">Seleccione destino</option>

                                    @foreach($bag['ubicacion_traslado_destino'] as $ubicacion_traslado_destino)

                                        <option value="{{$ubicacion_traslado_destino->id}}">{{$ubicacion_traslado_destino->nombre}}</option>

                                    @endforeach

                                </select>
                            </div>
                        </div><!--card-body-->

                    </div><!--card-->

                    <div class="card" id="ocultosalida" style="display: none;">
                        <div class="card-header">
                            <strong>Información de salida</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="vat" class="col-sm-3">ORIGEN</label>
                                <select class="form-control col-sm-3" id="origen_salida" name="origen_salida">
                                    <option value="0">Seleccione origen</option>

                                    @foreach($bag['ubicacion_salida_origen'] as $ubicacion_salida_origen)

                                        <option value="{{$ubicacion_salida_origen->id}}">{{$ubicacion_salida_origen->nombre}}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3">DESTINO</label>
                                <select class="form-control col-sm-3" id="destino_salida" name="destino_salida">
                                    <option value="0">Seleccione destino</option>

                                    @foreach($bag['ubicacion_salida_destino'] as $ubicacion_salida_destino)

                                        <option value="{{$ubicacion_salida_destino->id}}">{{$ubicacion_salida_destino->nombre}}</option>

                                    @endforeach

                                </select>
                            </div>
                        </div><!--card-body-->

                    </div><!--card-->


                    <div class="card">
                        <div class="card-header">
                            <strong>Listado de productos</strong>
                        </div>
                        <div class="card-body">


                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Ingrese el código del producto</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="codigoproducto" type="text" name="codigoproducto" placeholder="">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="tabla_item">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Familia</th>
                                        <th>Línea</th>
                                        <th>Cantidad</th>
                                        <th>Neto compra (UN)</th>
                                        <th>Neto venta (UN)</th>
                                        {{--<th>Acción</th>--}}

                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div> <!--table-responsive-->

                        </div><!--card-body-->
                        <div class="card-footer">
                            <button class="btn btn-md btn-success" type="button" id="btn_guardar">
                                <i class="fa fa-dot-circle-o"></i> Guardar</button>
                            <button class="btn btn-md btn-danger" type="reset">
                                <i class="fa fa-ban"></i>Cancelar</button>
                        </div>
                    </div><!--card-->


                </div><!--col-->
            </div><!--row-->
        </form>
        </div><!--card-body-->
    </div><!--card-->


@endsection

<script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>


    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#codigoproducto').focus();

        $('select[name="select_movimiento"]').on('change', function() {

            var seleccion = $(this).val();


            if (seleccion == 1) {
                $('#ocultoentrada').css('display', 'block');
                $('#ocultotraslado').css('display', 'none');
                $('#ocultosalida').css('display', 'none');}
            else if (seleccion == 2) {
                $('#ocultoentrada').css('display', 'none');
                $('#ocultotraslado').css('display', 'block');
                $('#ocultosalida').css('display', 'none'); }
            else if (seleccion == 3) {
                $('#ocultoentrada').css('display', 'none');
                $('#ocultotraslado').css('display', 'none');
                $('#ocultosalida').css('display', 'block'); }

        });

        $('#codigoproducto').on('keypress', function (e) {
            if(e.which === 13){

                $.ajax({
                    url: "{{route('admin.bodega.entrada.item')}}",
                    type: "post",
                    data: $("#formulario").serialize(),
                    success: function (data) {
                        var respuesta = $.parseJSON( data);
                        //console.log(respuesta);
                        if(respuesta.mensaje){
                            alert(respuesta.mensaje);
                        }

                        if(respuesta.correcto == 1){
                            //alert("cilindro");
                            $('#tabla_item tbody').append(respuesta.tr);
                            $("#codigoproducto").val("");
                            $("#codigoproducto").focus();

                        }

                        if(respuesta.correcto == 2){
                            console.log("Holi, lo arrelglè");
                            var producto = respuesta.producto_id;
                            var cantidad = respuesta.cantidad;

                            $("input[name='cantidad["+ producto +"]']").val(cantidad);
                            $('#codigoproducto').val("");
                            console.log(":3 " );
                        }

                    }
                });

            }
        });



        $("#btn_guardar").on('click',function() {

            $.ajax({
                url: "{{route('admin.bodega.entrada.guardar')}}",
                type: "post",
                data: $("#formulario").serialize(),
                success: function (data) {
                    var respuesta = $.parseJSON( data);
                    //console.log(respuesta);
                    if(respuesta.mensaje){
                        alert(respuesta.mensaje);
                    }

                    if(respuesta.correcto == 1){

                        alert("Productos ingresados correctamente");
                        location.reload();
                    }


                }
            });

        });


        jQuery('#tabla_item tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);

            $(this).closest('tr').remove();

        });






    });


</script>
