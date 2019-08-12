@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))


@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('styles')
    <style type="text/css">
        table thead tr th {
           font-size: smaller!important;
        }
        .sorting_asc{
            font-size: smaller!important;
        }
    </style>

@endsection

@section('content')


    <form id="formulario">

        <div class="row">
            <div class="col-4 pl-0">
                <div class="card">
                    <div class="card-header">
                        <strong>General </strong>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tipo Venta</label>
                            <div class="col-md-9 col-form-label">
                                <div class="form-check">
                                    <input class="form-check-input"  type="radio" value="1" name="tipo_venta">
                                    <label class="form-check-label" for="radio1">Solo Cotizacion</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"   type="radio" value="2" name="tipo_venta">
                                    <label class="form-check-label" for="radio1">Venta - Boleta</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"   type="radio" value="3" name="tipo_venta">
                                    <label class="form-check-label" for="radio1">Venta - Factura</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"   type="radio" value="4" name="tipo_venta">
                                    <label class="form-check-label" for="radio1">Venta - Guia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"  type="radio" value="5" name="tipo_venta">
                                    <label class="form-check-label" for="radio1">Cargar Cotizacion</label>
                                </div>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Nro </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input class="form-control" id="input2-group2" type="text" name="input2-group2" >
                                    <span class="input-group-append">
                                    <button class="btn btn-primary" type="button">Buscar</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!--card-body-->
                </div><!--card-->


            </div>


            {{-- InicioCliente--}}
            <div class="col-8 pl-0">
                <div class="card">
                    <div class="card-header">
                        <strong>Cliente </strong>
                    </div>
                    <div class="card-body row">

                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input">Buscar</label>
                                <div class="col-md-8">
                                    @component('backend.component.select-form',
                                   [
                                   'name' => 'cliente_id',
                                   'lista' => $clientes,
                                   'valor_seleccionado' => 0,
                                   'msg_o' => "------",
                                   'class' => 'chosen-select',
                                   'elemento_editar' => null,
                                   ])
                                    @endcomponent
                                </div>
                            </div>
                            @component('backend.component.form-group-input-text',
                             [
                             'name' => 'nombre',
                             'label' => "Nombre",
                             'col_a' => "4",
                             'col_b' => "8"
                             ])
                            @endcomponent

                            @component('backend.component.form-group-input-text',
                             [
                             'name' => 'rut',
                             'label' => "Rut"
                             ])
                            @endcomponent

                            @component('backend.component.form-group-input-text',
                             [
                             'name' => 'telefono',
                             'label' => "Telefono"
                             ])
                            @endcomponent


                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input">Email</label>
                                <div class="col-md-8">
                                    <input id="email" name="email" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input">Giro</label>
                                <div class="col-md-8">
                                    <textarea id="giro" name="giro" class="form-control" > </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input">Direccion</label>
                                <div class="col-md-8">
                                    <textarea id="direccion" name="direccion" class="form-control" > </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input" >Credito</label>
                                <div class="col-md-8">
                                    <input id="credito" name="credito" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input" >Saldo</label>
                                <div class="col-md-8">
                                    <input id="credito_maximo" name="credito_maximo" class="form-control" readonly >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-6 col-form-label" for="text-input"> </label>
                                <div class="col-md-6">
                                    <button  id="bt-guardar-cliente" class="btn btn-sm btn-block btn-success">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        Guardar
                                    </button>

                                </div>
                            </div>
                        </div>



                    </div>
                </div><!--card-body-->
            </div><!--card-->
            {{-- Fin Cliente--}}



        </div>




        {{-- Seleccion de productos--}}
        <div class="card">
            <div class="card-header">
                <strong>Detalle de la venta</strong>
            </div>
            <div class="card-body">


                    <div class="row">
                        <div class="col-5">
                            @component('backend.component.select-form',
                          [
                          'name' => 'ubicacion_id',
                          'lista' => $ubicacion,
                          'valor_seleccionado' => 0,
                          'msg_o' => "No filtrar por ubicacion",
                          'class' => 'chosen-select',
                          'elemento_editar' => null,
                          ])
                            @endcomponent
                        </div>
                        <div class="col-5">
                            @component('backend.component.select-form',
                            [
                            'name' => 'marca_id',
                            'lista' => $marcas,
                            'valor_seleccionado' => 0,
                            'msg_o' => "No filtrar por marca ",
                            'class' => 'chosen-select',
                            'elemento_editar' => null,
                            ])
                            @endcomponent

                        </div>
                        <div class="col-2">
                                  </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            @component('backend.component.select-form',
                                [
                                'name' => 'linea_id',
                                'lista' => $lineas,
                                'valor_seleccionado' => 0,
                                'msg_o' => "No filtrar por linea",
                                'elemento_editar' => null,
                                'enlazado' => true,
                                'class' => 'chosen-select',
                                'enlazado_destino' => 'familia_id',
                                'enlazado_ruta'=> route('admin.global.combo.familiabylinea'),
                                ])
                            @endcomponent
                        </div>
                        <div class="col-5">
                            @component('backend.component.select-form',
                                  [
                                  'name' => 'familia_id',
                                  'lista' => $familias,
                                  'valor_seleccionado' => 0,
                                  'msg_o' => "No filtrar por familia",
                                   'class' => 'chosen-select',
                                  'elemento_editar' => null,
                                  ])
                            @endcomponent

                        </div>
                        <div class="col-2">
                            <button  id="bt-filtrar" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Filtrar </button>
                        </div>
                    </div>



            <div class="table-responsive">
                <table class="table dataTable-small" id="tabla_busqueda">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Neto</th>
                        <th>Desc</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th></th>
                        {{--<th>Acción</th>--}}

                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div> <!--table-responsive-->
            <h4>Productos agregados</h4>
                <div class="table-responsive">
                    <table class="table dataTable-small" id="tabla_venta">
                        <thead>
                        <tr>
                            <th width="50%">Nombre</th>
                            <th width="5%">Cantidad</th>
                            <th width="10%">Val Neto</th>
                            <th width="10%">SubTotal</th>
                            <th width="10%">IVA</th>
                            <th width="10%">Total</th>
                            <th width="5%"> </th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th> </th>
                                <th><input id="total_cantidad" name="total_cantidad" class="form-control" > </th>
                                <th> </th>
                                <th> <input id="total_subtotal_neto" name="total_subtotal_neto" class="form-control" ></th>
                                <th> <input id="total_iva" name="total_iva" class="form-control" ></th>
                                <th colspan="2"> <input id="total_total" name="total_total" class="form-control" ></th>

                            </tr>


                            <tr>
                                <th colspan="1" class="text-right">

                                </th>
                                <th colspan="2" class="text-right">
                                    <input id="pago-total-efectivo" class="form-control"  type="number" name="pago-total-efectivo"
                                    placeholder="Paga con?" >
                                </th>
                                <th colspan="1" class="text-right">
                                        <button class="btn btn-md btn-success float-right" type="button" id="btn-pago-efectivo">
                                            Pagar
                                            <i class="fa fa-angle-double-right"></i>
                                        </button>
                                 </th>
                                <th colspan="1" class="text-right">
                                    Efectivo
                                </th>
                                <th colspan="2">
                                     <input id="pago_efectivo" class="input-pago form-control" name="pago_efectivo" type="number">
                                </th>


                            </tr>
                            <tr>
                                <th colspan="1" class="text-right">

                                </th>
                                <th colspan="2" class="text-right">
                                    <input id="pago_tarjeta_nro" class="form-control"  type="number" name="pago_tarjeta_nro"
                                    placeholder="Nº operacion" >
                                </th>
                                <th colspan="1" class="text-right">
                                        <button class="btn btn-md btn-success float-right" type="button" id="btn-pago-tarjeta">
                                            Pagar
                                            <i class="fa fa-angle-double-right"></i>
                                        </button>
                                </th>
                                <th colspan="1" class="text-right">
                                        Tarjeta
                                </th>
                                <th colspan="2">
                                    <input id="pago_tarjeta" class="input-pago form-control" type="number">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="1" class="text-right">

                                </th>
                                <th colspan="2" class="text-right">
                                    <input id="pago_transferencia_nro" class="form-control"  type="number" name="pago_transferencia_nro"
                                    placeholder="Nº transferencia" >
                                </th>
                                <th colspan="1" class="text-right">
                                    <button class="btn btn-md btn-success float-right" type="button" id="btn-pago-transferencia">
                                        Pagar
                                        <i class="fa fa-angle-double-right"></i>
                                    </button>
                                </th>
                                <th colspan="1" class="text-right">
                                     Transferencia
                                </th>
                                <th colspan="2">
                                    <input id="pago_transferencia" class="input-pago form-control"  type="number" name="pago_transferencia" >
                                </th>

                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">
                                        Habilitado
                                </th>
                                <th colspan="1" class="text-right">
                                        <button class="btn btn-md btn-success float-right" type="button" id="btn-pago-credito">
                                            Pagar
                                            <i class="fa fa-angle-double-right"></i>
                                        </button>
                                </th>
                                <th colspan="1" class="text-right">
                                    Credito
                                </th>
                                <th colspan="2">
                                    <input id="pago_credito" class="input-pago form-control" type="number" name="pago_credito">
                                </th>
                            </tr>

                            <tr>
                                <th colspan="5" class="text-right">
                                    Total pagado
                                </th>
                                <th colspan="2">  <input id="pagado" class="form-control" type="number" name="pagado" readonly> </th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">
                                    Pendiente
                                </th>
                                <th colspan="2"> <input id="pendiente_pago" readonly type="number"  class="form-control" name="pendiente_pago" readonly ></th>
                            </tr>




                            <tr>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th colspan="3">
                                    <button class="btn btn-md btn-success float-right" type="button" id="btn_guardar">
                                        <i class="fa fa-dot-circle-o"></i>
                                        Finalizar
                                    </button>
                                    <button class="btn btn-md btn-danger float-right" type="reset">
                                        <i class="fa fa-ban"></i>
                                        Cancelar
                                    </button>
                                <th>

                                </th>
                            </tr>

                            </tr>
                        </tfoot>
                    </table>
                </div> <!--table-responsive-->

            </div><!--card-body-->

        </div><!--card-->

       {{-- Fin seleccion de productos--}}




        </form>



@endsection

<script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>


    $(document).ready(function(){

        var total_cantidad=0;
        var total_neto=0;
        var total_subtotal_neto=0;
        var total_iva=0;
        var total_total=0;



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery('#tabla_item tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);

            $(this).closest('tr').remove();

        });



       

        $('#cliente_id').change(function(){
            //e.preventDefault();
            var id=  jQuery(this).val();
            jQuery.ajax({
                url: "{{ route('admin.global.info.ClienteById') }}/"+id,
                method: 'get',
                success: function(data){
                    var cliente = JSON.parse(data);
                    $("#nombre").val(cliente.nombre);
                    $("#rut").val(cliente.rut);
                    $("#telefono").val(cliente.telefono);

                    $("#email").val(cliente.email);

                    $("#giro").val(cliente.giro);
                    $("#direccion").val(cliente.direccion);
                    $("#credito").val(cliente.email);
                    $("#credito_maximo").val(cliente.email);
                }
            });
        });


        $('#bt-guardar-cliente').click(function(){
            //e.preventDefault();
            var id=  jQuery(this).val();
            /* jQuery.ajax({
                url: "{{ route('admin.global.info.ClienteById') }}/"+id,
                method: 'get',
                success: function(data){
                    var cliente = JSON.parse(data);
                    $("#nombre").val(cliente.nombre);
                    $("#rut").val(cliente.rut);
                    $("#telefono").val(cliente.telefono);

                    $("#email").val(cliente.email);

                    $("#giro").html(cliente.giro);
                    $("#direccion").val(cliente.direccion);
                    $("#credito").val(cliente.email);
                    $("#credito_maximo").val(cliente.email);
                }
            });  */
        });


        $('#btn-pago-efectivo').click(function(e){
            e.preventDefault();
            var valor=   $('#pago-total-efectivo').val();
            var total_total=   $('#total_total').val();
            if(valor==""){
                alert("Debe ingresar el monto pagado");
            }else{
                var vuelto= parseInt(valor) - parseInt(total_total)
                alert("Vuelto: " + vuelto);
                $('#pago_efectivo').val(total_total);
                totales();
            }
        });

        $('#pago-total-efectivo').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-efectivo').click();
            }
        });




        $('#btn-pago-tarjeta').click(function(e){
            e.preventDefault();
            var nro=   $('#pago_tarjeta_nro').val();
            if(nro==""){
                alert("Debe ingresar el numero de operacion del pago con tarjeta");
            }else{
                var total_total=   $('#total_total').val();
                $('#pago_tarjeta').val(total_total);
                totales();
            }
        });

        $('#pago_tarjeta_nro').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-tarjeta').click();
            }
        });




        $('#btn-pago-transferencia').click(function(e){
            e.preventDefault();
            var nro=   $('#pago_transferencia_nro').val();
            if(nro==""){
                alert("Debe ingresar el numero de operacion de la transferencia");
            }else{
                var total_total=   $('#total_total').val();
                $('#pago_transferencia').val(total_total);
                totales();
            }
        });

        $('#pago_transferencia_nro').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-transferencia').click();
            }
        });



        $('#btn-pago-credito').click(function(e){
            e.preventDefault();

           /* if(nro==""){
                alert("Debe ingresar el numero de operacion de la transferencia");
            }else{ */
                var total_total=   $('#total_total').val();
                $('#pago_credito').val(total_total);
                totales();
            //}
        });



        $('#formulario').submit(function(e){
            e.preventDefault();
        });



        var tabla_busqueda= $('#tabla_busqueda').DataTable({
            processing: true,
            serverSide: true,
                ajax: {
                    url: '{{route('admin.caja.venta.nuevo.tabla.buscar')}}',
                    type: 'GET',
                    data: function (d) {
                        d.marca_id = $('#marca_id').val();
                        d.ubicacion_id = $('#ubicacion_id').val();
                        d.linea_id = $('#linea_id').val();
                        d.familia_id = $('#familia_id').val();
                    }
                },
            columns: [
                {data: 'nombre', name: 'nombre'},
                {data: 'stock', name: 'stock'},
                {data: 'valor_neto_venta', name: 'valor_neto_venta'},
                {data: 'descuento', name: 'descuento'},
                {data: 'valor_iva', name: 'valor_iva'},
                {data: 'valor_total_venta', name: 'valor_total_venta', "width":"10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width":"11%"}
            ],

            initComplete : function() {
                var input = $('.dataTables_filter input').unbind(),
                    self = this.api(),
                $searchButton = $('<button>')
                    .text('Buscar')
                    .click(function() {
                        self.search(input.val()).draw();
                    })
                    .attr("type","button")

                input.on('keypress', function (e) {
                        if(e.which === 13) {
                            e.preventDefault();
                            self.search(input.val()).draw();
                        }
                    });

                $clearButton = $('<button>')
                    .text('Limpiar')
                    .click(function() {
                        input.val('');
                        $searchButton.click();
                    })
                    .attr("type","button")

                $('.dataTables_filter > label').append($searchButton,$clearButton);
            }



        });
        $('#bt-filtrar').click(function(e){
            tabla_busqueda.draw();
            e.preventDefault();
        });
        

        $('#tabla_busqueda tbody').on( "click", ".bt-guardar-precio",function(){
            //e.preventDefault();
            var producto_id =  boton.data('producto_id');
            var valor_neto_venta =  jQuery("#valor_neto_"+ producto_id);
            //alert('aa'+ id);

            $.ajax({
                url: "{{route('admin.caja.venta.guardar.precio')}}/",
                type: "get",
                data: { producto_id:producto_id,
                        valor_neto_venta:valor_neto_venta
                    }
                success: function (data) {
                    //var producto = $.parseJSON( data);
                    console.log(data);

                });
            });


        $('#tabla_busqueda tbody').on( "click", ".bt-agregar",function(){
            //e.preventDefault();
            var boton =  jQuery(this);
            var id =  boton.data('id');
            //alert('aa'+ id);

            $.ajax({
                url: "{{route('admin.global.info.ProductoById')}}/"+id,
                type: "get",
                success: function (data) {
                    var producto = $.parseJSON( data);
                    //console.log(respuesta);


                    var cantidad=  parseInt($("#cantidad_"+id).val());
                    var subtotal= cantidad * producto.valor_neto_venta;
                    var iva = Math.round(subtotal*0.19);
                    var total = Math.round(subtotal*1.19);





                    if($("input[name='cantidad["+ id +"]']").length == 0){
                    //alert("cilindro");
                        var fila ="<tr id=\"tr-detalle-" + id + "\">" +
                            "<td>"+producto.nombre+" ["+producto.marca.nombre+"] ["+producto.unidad_medida.nombre+"] <input type=\"hidden\"  name=\"productos_id["+ id +"]\" value=\""+id+"\" /></td>" +
                            "<td> <input type=\"number\" class=\"input-cantidad form-control\" name=\"cantidad["+ id +"]\" value=\""+cantidad+"\" data-id=\"" + id + "\" /></td>" +
                            "<td> <input type=\"number\" class=\"form-control\" name=\"valor_neto["+ id +"]\"  value=\"" + stripZeroes(producto.valor_neto_venta) + "\"  readonly/>  </td>" +
                            "<td><input type=\"number\" class=\"form-control\" name=\"sub_total_neto["+ id +"]\"  value=\"" + stripZeroes(subtotal) + "\"  readonly/>   </td>" +
                            "<td><input type=\"number\"  class=\"form-control\"name=\"iva["+ id +"]\"  value=\"" + stripZeroes(iva) + "\"  readonly/>  </td>" +
                            "<td> <input type=\"number\"  class=\"form-control\"name=\"total["+ id +"]\"  value=\"" + stripZeroes(total) + "\"  readonly/> </td>" +
                            "<td> <button class=\"btn btn-danger bt-eliminar\" type=\"button\" data-id=\"" + id + "\"  > [X] </button></td>" +
                            "</tr>";
                        $('#tabla_venta tbody').append(fila);
                        console.log("Producto Nuevo");
                    }else{
                        var cantidad_actual = parseInt($("input[name='cantidad["+ id +"]']").val());
                        var nueva_cantidad = cantidad_actual+cantidad;
                        $("input[name='cantidad["+ id +"]']").val(nueva_cantidad);
                        console.log("Producto existente");

                    }






                   totales();




                }
            });

        });


        function totales() {


            $('#pagado').val(0);
            $('#pendiente_pago').val(0);

            total_cantidad=0;
            total_neto=0;
            total_subtotal_neto=0;
            total_iva=0;
            total_total=0;
            var $inputs = $(".input-cantidad");
            $inputs.each(function() {
                var cantidad= parseInt($(this).val());
                var id= $(this).data('id');
                var valor_neto =  parseFloat($("input[name='valor_neto["+ id +"]']").val());
                var sub_total_neto =   parseFloat(cantidad * valor_neto);
                var iva =  parseInt(sub_total_neto * 0.19);
                var total =   parseInt(sub_total_neto + iva);

                $("input[name='sub_total_neto["+ id +"]']").val(sub_total_neto);
                $("input[name='iva["+ id +"]']").val(iva);
                $("input[name='total["+ id +"]']").val(total);

                total_cantidad += cantidad;
                total_subtotal_neto +=sub_total_neto;
                total_iva += iva;
                total_total +=total;
            });
            $('#total_cantidad').val(total_cantidad);
            $('#total_subtotal_neto').val(total_subtotal_neto);
            $('#total_iva').val(total_iva);
            $('#total_total').val(total_total);



            var total_pagado=0;
            var total_venta = $('#total_total').val();

            if(total_venta==''){
                total_venta=0;
            }

            $('.input-pago').each(function(){
                var valor = $(this).val();
                if(valor==''){
                    valor=0;
                }
                total_pagado += parseInt(valor);
            })


            $('#pagado').val(total_pagado);
            $('#pendiente_pago').val(total_venta - total_pagado);
        };




        $('#tabla_venta tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);
            $('#tr-detalle-'+id).remove();
            totales();

        });


        $('#tabla_venta tbody').on( "change", ".input-cantidad",function(){
            totales();
        });


        $('body').on( "change", ".input-pago",function(){


            totales();

        });




        $("#btn_guardar").on('click',function() {

            $.ajax({
                url: "{{route('admin.caja.venta.nuevo.guardar')}}",
                type: "post",
                data: $("#formulario").serialize(),
                success: function (data) {
                    var respuesta = $.parseJSON( data);
                    //console.log(respuesta);


                    if(respuesta.imprimir==1){
                        alert(respuesta.mensaje);
                        window.open('{{route('admin.caja.venta.imprimir')}}/' + respuesta.venta_id, '_blank');
                    }


                    if(respuesta.mensaje){
                        alert(respuesta.mensaje);
                    }

                    if(respuesta.correcto == 1){


                        location.reload();
                    }


                }
            });

        });






        /*  */
    });


    var fNumber = {
        sepMil: ".", // separador para los miles
        sepDec: ',', // separador para los decimales
        formatear:function (num){
            num +='';
            var splitStr = num.split('.');
            var splitLeft = splitStr[0];
            var splitRight = splitStr.length > 1 ? this.sepDec + splitStr[1] : '';
            var regx = /(\d+)(\d{3})/;
            while (regx.test(splitLeft)) {
                splitLeft = splitLeft.replace(regx, '$1' + this.sepMil + '$2');
            }
            return this.simbol + splitLeft + splitRight;
        },
        go:function(num, simbol){
            this.simbol = simbol ||'';
            return this.formatear(num);
        }
    }






    function stripZeroes(x){
        // remove the last digit, that you know isn't relevant to what
        // you are working on
       // x = x.toString().substring(0,x.toString().length-1);
        // parse the (now) String back to a float. This has the added
        // effect of removing trailing zeroes.
        return parseFloat(x);}

</script>
