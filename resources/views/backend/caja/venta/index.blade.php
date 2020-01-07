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

<style type="text/css">
    .box{
        width:600px;
        margin:0 auto;
    }
    .hide{
        display: none;
    }
    .hide_salida{
        display: none;
    }
    .show{
        display: flex;
    }
</style>


    <form id="formulario">

@php
if(Auth::user()->is_recibe_pago == 1){
    $estado_tabla = "";
    $estado_check = "";
    $valida_pago = "true";
}
else{
    $estado_tabla = "visibility: collapse;";
    $estado_check = "disabled";
    $valida_pago = "false";

}
    

@endphp

        <div class="row">
            
            {{-- InicioCliente--}}
            <div class="col-12 pl-0">
                <div class="card" id="card_cliente">
                <input type="hidden" id="cliente_nuevo" name="cliente_nuevo">
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
                                   'msg_o' => "Nuevo cliente",
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

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input">Ciudad</label>
                                <div class="col-md-8">
                                    <input id="ciudad" name="ciudad" class="form-control" >
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
                                    <input id="credito_maximo" name="credito_maximo" class="form-control" readonly>
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



    <div class="row">
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

            </div>
        </div> <!-- card -->
    </div> <!-- row -->


    <div class="row">
            <div class="col-12 pl-0">
                <div class="card">
                    <div class="card-header">
                        <strong>Productos agregados</strong>
                    </div>
                    <div class="card-body">

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
                                        <th colspan="3"> <input id="total_descuento_detalle" name="total_descuento_detalle" class="form-control" > </th> 
                                        <th colspan="2"> Descuento </th>
                                        <th colspan="2"> <input id="total_descuento" name="total_descuento" class="form-control input-descuento"  type="number"/></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">  <input id="total_recargo_detalle" name="total_recargo_detalle" class="form-control " > </th> 
                                        <th colspan="2"> Recargo </th>
                                        <th colspan="2"> <input id="total_recargo" name="total_recargo" class="form-control input-descuento"   type="number" /></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3"> </th> 
                                        <th colspan="2">Total Pago Otros medios  </th>
                                        <th colspan="2"> <input id="total_pago_otros" name="total_pago_otros" class="form-control" readonly ></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3"> </th> 
                                        <th colspan="2"> Total Pago Efectivo  </th>
                                        <th colspan="2"> <input id="total_pago_efectivo" name="total_pago_efectivo" class="form-control" readonly ></th>
                                    </tr>

                        
                            </tfoot>
                                
                            </table>
                        </div> <!--table-responsive-->

                    </div><!--card-body-->

                </div><!--card-->
            </div>
    </div>

     {{-- Fin seleccion de productos--}}
        
     <div class="row">
        <div class="col-12 pl-0">
            <div class="card" id="card_cliente">
             
                <div class="card-header">
                    <strong>Informacion Adicional </strong>
                </div>
                <div class="card-body row">

                        <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">Nombre responsable</label>
                                    <div class="col-md-8">
                                       <input class="form-control" name="contacto_nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">Telefono responsable</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="contacto_telefono">
                                    </div>
                                </div>
                        </div>
                        <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">Rut responsable</label>
                                    <div class="col-md-8">
                                       <input class="form-control" name="contacto_rut">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">Correo responsable</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="contacto_correo">
                                    </div>
                                </div>
                        </div>

                        <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="text-input">Observacion Factura</label>
                                    <div class="col-md-10">
                                            <textarea name="observacion_factura" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                               
                        </div>
                        <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="text-input">Observacion OT</label>
                                    <div class="col-md-10">
                                            <textarea name="observacion_ot" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                               
                        </div>

                </div>
            </div>
     </div>

    <div class="row">

        <div class="col-12 pl-0">
            <div class="card">
                <div class="card-header">
                    <strong>Ingreso y pago</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tipo</label>
                                <div class="col-md-9 col-form-label">
                                    <div class="form-check">
                                        <input class="form-check-input"  type="radio" value="1" name="tipo_venta" id="tp_1">
                                        <label class="form-check-label" for="radio1">Solo Cotizacion</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="2" name="tipo_venta" id="tp_2" {{$estado_check}}>
                                        <label class="form-check-label" for="radio1">Venta - Boleta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="3" name="tipo_venta" id="tp_3" {{$estado_check}}>
                                        <label class="form-check-label" for="radio1">Venta - Factura</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="4" name="tipo_venta" id="tp_4" {{$estado_check}}>
                                        <label class="form-check-label" for="radio1">Venta - Guia</label>
                                    </div>

                                    
                                    {{-- <div class="form-check">
                                        <input class="form-check-input"  type="radio" value="5" name="tipo_venta" id="tp_5">
                                        <label class="form-check-label" for="radio1">Cargar Cotizacion</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="6" name="tipo_venta" id="tp_6">
                                        <label class="form-check-label" for="radio1">Preventa</label>
                                    </div>

                                    @if(Auth::user()->is_genera_merma == 1)
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="7" name="tipo_venta" id="tp_7" {{$estado_check}}>
                                        <label class="form-check-label" for="radio1">Merma</label>
                                    </div>
                                    @endif

                                    @if(Auth::user()->is_genera_traslado == 1)
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="8" name="tipo_venta" id="tp_8" {{$estado_check}}>
                                        <label class="form-check-label" for="radio1">Traslado</label>
                                    </div>

                                    <div class="form-check hide" id="dv_traslado"  >
                                        @component('backend.component.select-form',
                                            [
                                            'name' => 'origen_id',
                                            'lista' => $ubicacion->where('is_traslado_origen',1),
                                            'valor_seleccionado' => 0,
                                            'msg_o' => "Seleccione origen",
                                            'elemento_editar' => null,
                                            ])
                                        @endcomponent

                                        @component('backend.component.select-form',
                                            [
                                            'name' => 'destino_id',
                                            'lista' => $ubicacion->where('is_traslado_destino',1),
                                            'valor_seleccionado' => 0,
                                            'msg_o' => "Seleccione destino",
                                            'elemento_editar' => null,
                                            ])
                                        @endcomponent
                                    </div>
                                    

                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Nro </label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input class="form-control" id="venta_id_buscar" type="text" name="input2-group2" >
                                        <span class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="bt-buscar-venta">Buscar</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-9">
                            <div class="table-responsive">
                                <table class="table dataTable-small" id="tabla_fin" style="{{$estado_tabla}}">
                                    

                                    @foreach ($pago_tipos as $pago_tipo)
                                    
                                        <tr>
                                        <th colspan="1" class="text-right"></th>
                                        <th colspan="2" class="text-right">
                                            <input id="pago-{{$pago_tipo->id}}" class="form-control"   name="comprobantes[{{$pago_tipo->id}}]"
                                            placeholder="{{$pago_tipo->texto}}" >
                                        </th>
                                        <th colspan="1" class="text-right">
                                                <button class="btn btn-md btn-success float-right" type="button" id="btn-pago-{{$pago_tipo->id}}">
                                                    Pagar
                                                    <i class="fa fa-angle-double-right"></i>
                                                </button>
                                        </th>
                                        <th colspan="1" class="text-right">{{$pago_tipo->nombre}}</th>
                                        <th colspan="2">
                                            <input id="pago-final-{{$pago_tipo->id}}" class="input-pago form-control" name="pagos[{{$pago_tipo->id}}]" type="number">
                                        </th>
                                        </tr>

                                        @endforeach

                                    

                                        <tr>
                                            <th colspan="5" class="text-right">Total pagado</th>
                                            <th colspan="2">  <input id="pagado" class="form-control" type="number" name="pagado" readonly> </th>
                                        </tr>

                                        <tr>
                                            <th colspan="5" class="text-right">Pendiente</th>
                                            <th colspan="2"> <input id="pendiente_pago" readonly type="number"  class="form-control" name="pendiente_pago" readonly ></th>
                                        </tr>

                                        <tr>
                                            <th> </th>
                                            <th> </th>
                                            <th> </th>
                                            <th colspan="2"> </th>
                                            <th colspan="2"><input class="form-check-input" type="checkbox" name="venta_adelanto" id="venta_adelanto" value="">Venta con adelanto</th>

                                            
                                            <th>

                                            </th>
                                        </tr>
                                </table>

                                <table class="table">
                                
                                                <tr><td></td>
                                                <td colspan="2"><button class="btn btn-md btn-success " type="button" id="btn_guardar">
                                                    <i class="fa fa-dot-circle-o"></i>
                                                    Finalizar
                                                </button>
                                                <button class="btn btn-md btn-danger" type="reset">
                                                    <i class="fa fa-ban"></i>
                                                    Cancelar
                                                </button>
                                                </td>
                                                <td colspan="2">
                                                </td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!--card-body-->
            </div><!--card-->
        </div>
    </div>


        

      




        </form>



@endsection

@push('scripts')

 
<script>
     
 
    $(document).ready(function(){

        var total_cantidad=0;
        var total_neto=0;
        var total_subtotal_neto=0;
        var total_iva=0;
        var total_total=0;


        jQuery('#tabla_item tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);

            $(this).closest('tr').remove();

        });



       

        $('#cliente_id').change(function(){
            //e.preventDefault();

            var cliente_id = $("#cliente_id").val();

            if(cliente_id != 0){
                $("#bt-guardar-cliente").attr("disabled", "true");
            }else{
                $("#bt-guardar-cliente").removeAttr("disabled");
                $("#nombre").val("");
                $("#rut").val("");
                $("#telefono").val("");
                $("#email").val("");
                $("#ciudad").val("");
                $("#giro").val("");
                $("#direccion").val("");
                $("#credito").val("");
                $("#credito_maximo").val("");
            }

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
                    $("#ciudad").val(cliente.ciudad);

                    $("#giro").val(cliente.giro);
                    $("#direccion").val(cliente.direccion);
                    $("#credito").val(cliente.credito);
                    $("#credito_maximo").val(cliente.credito_maximo);
                }
            });
        });


        $('#bt-guardar-cliente').click(function(){
            //e.preventDefault();
             //var id=  jQuery(this).val();

            var nombre = $("#nombre").val();
            var rut = $("#rut").val();
            var telefono = $("#telefono").val();
            var email = $("#email").val();
            var ciudad = $("#ciudad").val();
            var giro = $("#giro").val();
            var direccion = $("#direccion").val();
            var credito = $("#credito").val();
            var credito_maximo = $("#credito_maximo").val();



             jQuery.ajax({
                url: "{{ route('admin.general.cliente.form.update') }}",
                method: 'post',
                data: { nombre: nombre, rut : rut,  telefono : telefono,  email : email ,  ciudad : ciudad,  giro : giro,  direccion : direccion,  credito : credito,  credito_maximo : credito_maximo},
                success: function(data){
                    console.log(data);
                    var respuesta = data;
                    if(respuesta.estado == 1){
                        $("#cliente_nuevo").val(respuesta.cliente_id);
                        $("#bt-guardar-cliente").attr("disabled", "true");
                        $("#cliente_id").attr("disabled", "true");
                        $('#cliente_id').prop('disabled', true).trigger("chosen:updated");
                        alert(respuesta.mensaje + ". Continúe con la venta");
                        
                        
                        
                       
                    }else{
                        alert("Hubo un error. Cliente no pudo ser añadido");
                    }
                    
                }
            });  
        });



        

       

        // boton pagar con efectivo 
        $('#btn-pago-1').click(function(e){
            e.preventDefault();
            var valor=   $('#pago-1').val();
            var total_total=   $('#total_pago_efectivo').val();
            if(valor==""){
                alert("Debe ingresar el monto pagado");
            }else{
                if(valor < total_total){
                    $('#pago-final-1').val(valor);
                }else{
                var vuelto= parseInt(valor) - parseInt(total_total)
                alert("Vuelto: " + vuelto);
                $('#pago-final-1').val(total_total);
               
                }
                totales();
            }
        });



        $('#pago-1').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-1').click();
            }
        });



    //pago con redcompra
        $('#btn-pago-2').click(function(e){
            e.preventDefault();
            var nro=   $('#pago-2').val();
            if(nro==""){
                alert("Debe ingresar el numero de operacion del pago con tarjeta");
            }else{
                var total_total=   $('#total_total').val();
                $('#pago-final-2').val(total_total);
                totales();
            }
        });

        $('#pago-2').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-2').click();
            }
        });




        $('#btn-pago-3').click(function(e){
            e.preventDefault();
            var nro=   $('#pago-3').val();
            if(nro==""){
                alert("Debe ingresar el número de operación de la transferencia");
            }else{
                var total_total=   $('#total_total').val();
                $('#pago-final-3').val(total_total);
                totales();
            }
        });

        $('#pago-3').on('keypress', function (e) {
            if(e.which === 13) {
                e.preventDefault();
                $('#btn-pago-3').click();
            }
        });


//pago con crédito del cliente
        $('#btn-pago-5').click(function(e){
            e.preventDefault();

           /* if(nro==""){
                alert("Debe ingresar el numero de operacion de la transferencia");
            }else{ */
                var total_total=   $('#total_total').val();
                $('#pago-final-5').val(total_total);
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
            var producto_id =  $(this).data('producto_id');
            var valor_neto_venta =  $("#valor_neto_"+ producto_id).val();
            $.ajax({
                url: "{{route('admin.caja.venta.guardar.precio')}}",
                method: "POST",
                data: { producto_id:producto_id,
                        valor_neto_venta:valor_neto_venta
                    },
                success: function (data) {
                    alert('Guardado!'); 
                }
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

            var total_pago_otros = 0;
            $('#total_pago_otros').val(0); 

            var total_pago_efectivo = 0;
            $('#total_pago_efectivo').val(0);
            
            var total_descuento = $('#total_descuento').val();
            if(total_descuento == ""){
                total_descuento = 0;
            }
            total_descuento = parseInt(total_descuento);

            var total_recargo = $('#total_recargo').val();
            if(total_recargo == ""){
                total_recargo = 0;
            }
            total_recargo = parseInt(total_recargo);

 
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

            total_pago_otros = total_total -  total_descuento + total_recargo;
            $('#total_pago_otros').val(total_pago_otros);

            total_pago_efectivo = total_total -  total_descuento + total_recargo;
            total_pago_efectivo = ley_redondeo(total_pago_efectivo);
            $('#total_pago_efectivo').val(total_pago_efectivo);



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


            if ($('#pago-1').val()==""){
                $('#pendiente_pago').val(total_venta - total_pagado);
            }else{
                $('#pendiente_pago').val(total_pago_efectivo - total_pagado);
            }
            
            
        };




        $('#tabla_venta tbody').on( "click", ".bt-eliminar",function(){
            //e.preventDefault();
            var boton=  jQuery(this);
            var id=  boton.data('id');
            //alert('aa'+ id);
            $('#tr-detalle-'+id).remove();
            totales();

        });


        $('#tabla_venta tbody').on( "change", ".input-pago, .input-descuento",function(){
            
            totales();
        });

 
      

     


        $('input[type=radio][name="tipo_venta"]').change(function() { 
            var tipo_venta = $(this).val();  

            $("#dv_traslado").hide();

            //alert(tipo_venta);
            if(tipo_venta==8){
                $("#dv_traslado").show();
            }  

        });


        //inicio boton cargar venta anterior
        $('body').on( "click", "#bt-buscar-venta",function(){
            var venta_id_buscar = $("#venta_id_buscar").val();
            $.ajax({
                url: "{{route('admin.global.info.getVentaById')}}/"+venta_id_buscar,
                type: "get",
                success: function (data) {
                    var ventas= $.parseJSON( data);
                    console.log(ventas);
                    $.each( ventas.venta_detalle, function( key, value ) {
                        //console.log(value );
                        var cantidad =value.cantidad_vendida;
                        var producto = value.producto;
                        var id = producto.id;
                        var subtotal= cantidad * producto.valor_neto_venta;
                        var iva = Math.round(subtotal*0.19);
                        var total = Math.round(subtotal*1.19);
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
                        
                    });
                    $("#cliente_id").val(ventas.venta.cliente_id).trigger("chosen:updated").trigger("change"); 
                    totales();

                }
            });

         
 

        });
 

        $("#btn_guardar").on('click',function() {

            $("#btn_guardar").attr("disabled", "true");
 
            var total_a_pagar =  $("#total_total").val();
            var total_pagado =  $("#pagado").val();

            var guardar = 1;

            if(( !($('#venta_adelanto').is(":checked")) && total_a_pagar != total_pagado && !($('#tp_1').is(":checked")) && !($('#tp_6').is(":checked")) && !($('#tp_7').is(":checked")) && !($('#tp_8').is(":checked"))  ) && {{ $valida_pago}}){
                
                    alert("La suma total difiere del total pagado");
                    $("#btn_guardar").removeAttr("disabled");
                    guardar=0;
                
            }


            if($('#pago-final-2').val() != ""){
                if($('#pago-2').val() == ""){
                    alert("Debe ingresar el nro de comprobante");
                    guardar=0;
                    $("#btn_guardar").removeAttr("disabled");
                }
                
            
            }

            
            if(guardar == 1){

                var tipo_venta =   $("input[name='tipo_venta'").val();
                if(tipo_venta>0){
                    $.ajax({
                        url: "{{route('admin.caja.venta.nuevo.guardar')}}",
                        type: "post",
                        data: $("#formulario").serialize(),
                        success: function (data) {
                            var respuesta = JSON.parse(data);
                            //console.log(respuesta);

                            
                                
                            if(respuesta.imprimir==1){
                                window.open('{{route('admin.caja.venta.imprimir')}}/' + respuesta.venta_id, '_blank');
                                
                            }else{
                                $("#btn_guardar").removeAttr("disabled");
                            }


                            if(respuesta.mensaje){
                                
                                if(respuesta.preventa==1){
                                    alert("Preventa registrada correctamente. N°:" + respuesta.venta_id);
                                }else{
                                    alert(respuesta.mensaje);
                                    
                                }
                            }

                            if(respuesta.correcto == 1){

                                location.reload();
                            }


                        },
                        error: function(xhr, status, error){
                            var errorMessage = xhr.status + ': ' + xhr.statusText
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            alert('Error - ' + errorMessage + ' - ' + xhr.responseJSON.message);
                        },
                        complete: function(data) {
                            $("#btn_guardar").removeAttr("disabled");
                        }
                    });


                    
                }else{
                    alert("Debe  Seleccionar un tipo de operacion");
                    $("#btn_guardar").removeAttr("disabled");
                }

            }

            $("#btn_guardar").removeAttr("disabled");

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



    function ley_redondeo(numero){
        let resto = numero % 10;
        let resultado =  Math.trunc(numero/10);
        if (resto <=5){
            resultado = resultado *10;
        }else{
        	resultado = (resultado + 1 )*10;
        }
        return resultado;
    }


    function stripZeroes(x){
        // remove the last digit, that you know isn't relevant to what
        // you are working on
       // x = x.toString().substring(0,x.toString().length-1);
        // parse the (now) String back to a float. This has the added
        // effect of removing trailing zeroes.
        return parseFloat(x);}

</script>
@endpush