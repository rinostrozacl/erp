@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))


@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection



@section('content')
    <style type="text/css">
        .box{
            width:600px;
            margin:0 auto;
        }
        .hide{
            display: none;
        }
        .show{
            display: flex;
        }
    </style>
    @php
//dd(session()->attributes);

    

   @endphp

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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label" for="select1">Tipo movimiento</label>
                                            <select class="form-control col-sm-8" id="movimiento_tipo_id" name="movimiento_tipo_id">
                                                <option value="0">Seleccione</option>
                                                @foreach($bag['tipos_movimiento'] as $tm)
                                                <option value="{{$tm->id}}">{{$tm->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vat" class="col-sm-4">Origen</label>
                                            <select class="form-control col-sm-8" id="ubicacion_origen_id" name="ubicacion_origen_id">
                                                <option value="0">Seleccione Tipo Movimiento</option>

                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="street" class="col-sm-4">Destino</label>
                                            <select class="form-control col-sm-8" id="ubicacion_destino_id" name="ubicacion_destino_id">
                                                <option value="0">Seleccione Tipo Movimiento</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         {{--Columna derecha--}}


                                        <div class="form-group row movimiento_tipo_1 hide">
                                            <label for="vat" class="col-sm-4">Proveedor</label>
                                            <select class="selectpicker col-sm-8" data-live-search="true" id="proveedor_id" name="proveedor_id">
                                                <option value="0">Buscador</option>
                                                @foreach($bag['proveedor'] as $p)
                                                    <option value="{{$p->id}}">{{$p->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group row movimiento_tipo_1 hide">
                                            <label for="vat" class="col-sm-4">Documento</label>
                                            <input class="form-control col-sm-4" id="nro_documento" name="nro_documento" type="number" placeholder="Numero Documento">
                                            <select class="form-control col-sm-4" id="doc_tipo_compra_id" name="doc_tipo_compra_id">
                                                <option value="0">Seleccione</option>
                                                @foreach($bag['doc_tipo_compra'] as $td)
                                                    <option value="{{$td->id}}">{{$td->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row movimiento_tipo_1 hide">
                                            <label for="vat" class="col-sm-4">Monto</label>
                                            <input class="form-control col-sm-4" id="compra_valor_neto" name="compra_valor_neto" type="number" placeholder="Total Neto">
                                            <div class="col-md-4 col-form-label">
                                                <div class="form-check form-check-inline mr-1">
                                                    <input class="form-check-input" id="is_pagado" type="checkbox" name="is_pagado" value="1">
                                                    <label class="form-check-label" for="inline-checkbox1">Pagado</label>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group row movimiento_tipo_3 hide">
                                            <label for="vat" class="col-sm-4"></label>

                                            <select class="form-control col-sm-8" data-live-search="true" id="venta_id" name="venta_id">
                                                <option value="0">Buscador</option>
                                                @foreach($bag['ventas'] as $p)
                                                    <option value="{{$p->id}}">(Nº:{{$p->id}}) {{$p->cliente->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>




                                    </div>
                            </div>

                                    </div><!--col-->
                                </div><!--form-->
                            </div><!--card-body-->
                    </div><!--card-->







                    <div class="card">
                        <div class="card-header">
                            <strong>Listado de productos</strong>
                        </div>
                        <div class="card-body">




                            <div class="form-group row  movimiento_tipo_1 hide">

                                <div class="col-md-2">
                                    <input class="form-control" id="codigoproducto" type="text" name="codigoproducto" placeholder="Buscar por codigo">
                                </div>
                                <div class="col-md-2" id="producto_autocomplete">
                                    <input class="form-control" id="producto_name" type="text" name="producto_name" placeholder="Buscar por nombre producto">
                                </div>
                                <div class="col-md-4" >
                                    <select class="form-control" data-live-search="true" id="producto_id_add" name="producto_id_add">
                                        <option value="0">---</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" id="cantidad_producto_add" type="text" name="cantidad_producto_add" placeholder="Cantidad a ingresar">

                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="bt-agregar" type="button" disabled>Agregar</button>

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
                                        <th>Neto (UN)</th>
                                        <th> </th>
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


                            <input    type="hidden" name="total_productos"   id="total_productos" value="0" >
                        </div>
                    </div><!--card-->
















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


        $('#producto_name').keyup(function(){
            var query = $(this).val();
            $("#producto_id_add").empty();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{route('admin.global.autocomplete.fetchProducto')}}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success: function (data) {
                       // console.log(data);
                        $.each(JSON.parse(data), function(id, item) {
                            $("#producto_id_add").append('<option value=' + item.id + '>' + item.nombre + '</option>');
                        });
                        $('#bt-agregar').removeAttr("disabled");
                    }
                });

            }else{
                $("#producto_id_add").append('<option value="0">---</option>');
            }
            $("#producto_id_add").trigger("liszt:updated");
        });

        $("#producto_autocomplete").on('click', 'li', function(){
            //producto_id_add
            $('#producto_id_add').val($(this).data("producto_id"));
            $('#producto_name').val($(this).text());
            $('#producto_list').fadeOut();

        });


        $("#bt-agregar").on('click', function() { //Agrega producto a la lista de productos
            var producto_id_add= $('#producto_id_add').val();
            var cantidad_producto_add= $('#cantidad_producto_add').val();
            var total_productos= $('#total_productos').val();

            if(producto_id_add  >0 && cantidad_producto_add>0){

                $.ajax({
                    url: "{{route('admin.bodega.entrada.item')}}",
                    type: "post",
                    data: {
                        producto_id_add: producto_id_add,
                        cantidad_producto_add: cantidad_producto_add
                    },
                    success: function (data) {
                        var respuesta = $.parseJSON( data);
                        //console.log(respuesta);
                        if(respuesta.mensaje){
                            alert(respuesta.mensaje);
                        }
                        if(respuesta.correcto == 1){
                            //alert("cilindro");
                            var producto_id = respuesta.producto_id;
                            var cantidad = parseInt(respuesta.cantidad);
                            if($("input[name='productos_id["+ producto_id +"]']").length != 0){
                                console.log("Producto ya existente " + producto_id);
                                var cantidad_actual = parseInt($("input[name='cantidad["+ producto_id +"]']").val());
                                var nueva_cantidad = cantidad_actual+cantidad;
                                $("input[name='cantidad["+ producto_id +"]']").val(nueva_cantidad);
                            }else{
                                console.log("Producto Nuevo");
                                $('#tabla_item tbody').append(respuesta.tr);
                            }

                            $("#codigoproducto").val("");
                            $("#codigoproducto").focus();
                            $('#producto_name').val("");
                            $('#producto_id_add').val("");
                            $('#bt-agregar').attr("disabled");

                            var cantidad_total = parseInt(respuesta.cantidad) + parseInt(total_productos);

                            $('#total_productos').val(cantidad_total);
                        }
                    }
                });


            }else{
                alert("Debe seleccionar producto e ingresar la cantidad");
            }


        });

        //$('#codigoproducto').focus();

        $('#movimiento_tipo_id').on('change', function() {

            var movimiento_tipo_id = $(this).val();

            var action_id_origen = 0;
            var action_id_destino = 0;
            $(".movimiento_tipo_1").removeClass('show').addClass('hide');
            $(".movimiento_tipo_2").removeClass('show').addClass('hide');
            $(".movimiento_tipo_3").removeClass('show').addClass('hide');
            $(".movimiento_tipo_4").removeClass('show').addClass('hide');

            if(movimiento_tipo_id==1){ // Entrada compra
                $(".movimiento_tipo_1").removeClass('hide').addClass('show');
                 action_id_origen = 1;
                 action_id_destino = 2;
            }
            if(movimiento_tipo_id==2){
                $(".movimiento_tipo_2").removeClass('hide').addClass('show');
                action_id_origen = 4;
                action_id_destino = 3;
            }
            if(movimiento_tipo_id==3){ // Salida a cliente
                $(".movimiento_tipo_3").removeClass('hide').addClass('show');
                action_id_origen = 5;
                action_id_destino = 6;

            }
            if(movimiento_tipo_id==4){
                $(".movimiento_tipo_4").removeClass('hide').addClass('show');
                action_id_origen = 3;
                action_id_destino = 4;
            }
            console.log(movimiento_tipo_id);

            $.ajax({
                url: "{{route('admin.global.info.getUbicacionByAccion')}}/"+action_id_origen,
                type: "get",
                success: function (data) {
                    console.log(data);
                    $("#ubicacion_origen_id").html("");
                    $.each(JSON.parse(data), function(id, name) {
                        $("#ubicacion_origen_id").append('<option value=' + name.id + '>' + name.nombre + '</option>');
                    });
                    //$("#ubicacion_origen_id").trigger("chosen:updated");
                }
            });

            $.ajax({
                url: "{{route('admin.global.info.getUbicacionByAccion')}}/"+action_id_destino,
                type: "get",
                success: function (data) {
                    console.log(data);
                    $("#ubicacion_destino_id").html("");
                    $.each(JSON.parse(data), function(id, name) {
                        $("#ubicacion_destino_id").append('<option value=' + name.id + '>' + name.nombre + '</option>');
                    });
                    //$("#ubicacion_origen_id").trigger("chosen:updated");
                }
            });


/*            if (seleccion == 1) {
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
                */

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
                            //console.log("Holi, lo arrelglè");
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


            $(this).closest('tr').remove();

        });

        $('#formulario').on("change", "#venta_id",function(){
            //e.preventDefault();
            var valor=  jQuery(this).val();

            if(parseInt(valor)>0){
                $.ajax({
                    url: "{{route('admin.global.info.getVentaById')}}/"+valor,
                    type: "get",
                    data: $("#formulario").serialize(),
                    success: function (data) {
                        var respuesta = $.parseJSON( data);
                        console.log(respuesta);




                        $.each(respuesta.venta_detalle, function(index, detalle) {
                           // $("#ubicacion_destino_id").append('<option value=' + name.id + '>' + name.nombre + '</option>');
                           console.log(detalle);


                            //alert("cilindro");
                            var producto_id = detalle.producto_id;
                            var producto = detalle.producto;
                            var cantidad = parseInt(detalle.cantidad_vendida);
                            if($("input[name='productos_id["+ producto_id +"]']").length != 0){
                                console.log("Producto ya existente " + producto_id);
                                var cantidad_actual = parseInt($("input[name='cantidad["+ producto_id +"]']").val());
                                var nueva_cantidad = cantidad_actual+cantidad;
                                $("input[name='cantidad["+ producto_id +"]']").val(nueva_cantidad);
                            }else{
                                console.log("Producto Nuevo");
                                var tr = ` <tr>
                                    <td>`  +  producto.codigo_ean13  +  `<input type="hidden"
                                        id="productos_id_`  +  producto.id  +  `" name="productos_id[` + producto.id + `]" value="`  +  producto.id  +  `" /> </td>
                                    <td>`  +  producto.nombre  +  `  </td>
                                    <td>`  +  producto.familia.nombre  +  `</td>
                                    <td>`  +  producto.familia.linea.nombre  +  `</td>
                                    <td><input class="form-control" id="cantidad" type="text"  readonly name="cantidad[` + producto.id + `]" value="` + cantidad + `"></td>
                                    <td><input class="form-control" id="valor_neto_compra" type="text" readonly name="valor_neto_compra[` + producto.id + `]" value="0"></td>
                                    <td><input type="checkbox" name="entregado[` + producto.id + `]"checked value="` + producto.id + `"></td>
                               </tr>`

                                $('#tabla_item tbody').append(tr);
                            }

/*   <td>' . producto.familia->nombre . '</td>
                                    <td>' . producto->familia->linea->nombre . '</td>*/

                            var cantidad_total = parseInt(respuesta.cantidad) + parseInt(total_productos);

                            $('#total_productos').val(cantidad_total);



                        });


                       /* if(respuesta.mensaje){
                            alert(respuesta.mensaje);
                        }

                        if(respuesta.correcto == 1){

                            alert("Productos ingresados correctamente");
                            location.reload();
                        }
                        */

                    }
                });
            }else{
                $('#tabla_item tbody').html("");
            }


           // $(this).closest('tr').remove();

        });




    });


</script>
