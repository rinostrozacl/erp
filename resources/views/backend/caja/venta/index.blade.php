@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))


@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>
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
                                    <input class="form-check-input"  type="radio" value="1" name="tipo_venta" checked>
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
                            <label class="col-md-3 col-form-label" for="hf-email">Nro Cotizacion</label>
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



            <div class="col-4 pl-0">
                <div class="card">
                    <div class="card-header">
                        <strong>Cliente </strong>
                    </div>
                    <div class="card-body">


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


                    </div>
                </div><!--card-body-->
            </div><!--card-->




        </div>




        {{-- Seleccion de productos--}}
        <div class="card">
            <div class="card-header">
                <strong>Productos</strong>
            </div>
            <div class="card-body">


                    <div class="row">



                        @component('backend.component.select-form',
                          [
                          'name' => 'ubicacion_id',
                          'lista' => $ubicacion,
                          'valor_seleccionado' => 0,
                          'msg_o' => "No filtrar por ubicacion",
                          'class' => 'chosen-select col-md-5',
                          'elemento_editar' => null,
                          ])
                        @endcomponent
                        @component('backend.component.select-form',
                            [
                            'name' => 'marca_id',
                            'lista' => $marcas,
                            'valor_seleccionado' => 0,
                            'msg_o' => "No filtrar por marca ",
                            'class' => 'chosen-select col-md-5',
                            'elemento_editar' => null,
                            ])
                        @endcomponent

                    </div>
                    <div class="form-group row">

                            @component('backend.component.select-form',
                               [
                               'name' => 'linea_id',
                               'lista' => $lineas,
                               'valor_seleccionado' => 0,
                               'msg_o' => "No filtrar por linea",
                               'elemento_editar' => null,
                               'enlazado' => true,
                               'class' => 'chosen-select col-md-5',
                               'enlazado_destino' => 'familia_id',
                               'enlazado_ruta'=> route('admin.global.combo.familiabylinea'),
                               ])
                            @endcomponent
                            @component('backend.component.select-form',
                                  [
                                  'name' => 'familia_id',
                                  'lista' => $familias,
                                  'valor_seleccionado' => 0,
                                  'msg_o' => "No filtrar por familia",
                                   'class' => 'chosen-select col-md-5',
                                  'elemento_editar' => null,
                                  ])
                            @endcomponent

                    </div>
                <div class="form-group row">
                    <button  id="bt-filtrar" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Filtrar </button>
                </div>
                </div>
            <h4>Productos encontrados</h4>
            <div class="table-responsive">
                <table class="table dataTable-small" id="tabla_busqueda">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Descripcion</th>
                        <th>Familia</th>
                        <th>Línea</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Valor Neto</th>
                        <th>Descuento</th>
                        <th>IVA</th>
                        <th>Valor Total</th>
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
                            <th>Nombre</th>
                            <th>cantidad</th>
                            <th>Valor Neto</th>
                            <th>SubTotal Neto</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th> </th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th> </th>
                                <th id="total_cantidad"> </th>
                                <th id="total_neto"> </th>
                                <th id="total_subtotal_neto"> </th>
                                <th id="total_iva"> </th>
                                <th id="total_total"> </th>
                                <th  > </th>
                            </tr>

                            <tr>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th><button class="btn btn-md btn-success float-right" type="button" id="btn_guardar">
                                        <i class="fa fa-dot-circle-o"></i> Guardar</button> </th>
                                <th><button class="btn btn-md btn-danger float-right" type="reset">
                                        <i class="fa fa-ban"></i>Cancelar</button> </th>
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
                }
            });
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
                {data: 'codigo', name: 'codigo'},
                {data: 'descripcion', name: 'descripcion'},
                {data: 'familia', name: 'familia'},
                {data: 'linea', name: 'linea'},
                {data: 'marca', name: 'marca'},
                {data: 'stock', name: 'stock'},
                {data: 'valor_neto_venta', name: 'valor_neto_venta'},
                {data: 'descuento', name: 'descuento'},
                {data: 'valor_iva', name: 'valor_iva'},
                {data: 'valor_total_venta', name: 'valor_total_venta'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#bt-filtrar').click(function(e){
            tabla_busqueda.draw();
            e.preventDefault();
        });





        $('#tabla_busqueda tbody').on( "click", ".bt-agregar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
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
                            "<td>"+producto.nombre+" <input type=\"hidden\"  name=\"productos_id["+ id +"]\" value=\""+id+"\" /></td>" +
                            "<td> <input type=\"number\" class=\"input-cantidad\" name=\"cantidad["+ id +"]\" value=\""+cantidad+"\" data-id=\"" + id + "\" /></td>" +
                            "<td> <input type=\"number\" name=\"valor_neto["+ id +"]\"  value=\"" + stripZeroes(producto.valor_neto_venta) + "\"  readonly/>  </td>" +
                            "<td><input type=\"number\" name=\"sub_total_neto["+ id +"]\"  value=\"" + stripZeroes(subtotal) + "\"  readonly/>   </td>" +
                            "<td><input type=\"number\" name=\"iva["+ id +"]\"  value=\"" + stripZeroes(iva) + "\"  readonly/>  </td>" +
                            "<td> <input type=\"number\" name=\"total["+ id +"]\"  value=\"" + stripZeroes(total) + "\"  readonly/> </td>" +
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
            $('#total_cantidad').html(total_cantidad);

            $('#total_subtotal_neto').html(fNumber.go(total_subtotal_neto, "$"));
            $('#total_iva').html(fNumber.go(total_iva, "$"));
            $('#total_total').html(fNumber.go(total_total, "$"));
        };




        $('#tabla_venta tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);
            $('#tr-detalle-'+id).remove();


        });


        $('#tabla_venta tbody').on( "change", ".input-cantidad",function(){
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
