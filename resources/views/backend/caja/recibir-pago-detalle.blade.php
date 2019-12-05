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
                                <label class="col-md-4 col-form-label" for="hf-email">Nombre</label>
                                <div class="col-md-8">
                                     {{ $venta->cliente->nombre}}
                                     <input type="hidden" name="venta_id" value=" {{ $venta->id}}">
                                </div>
                            </div>

                             

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="hf-email">Rut</label>
                                <div class="col-md-8">
                                     {{ $venta->cliente->rut}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="hf-email">Giro</label>
                                <div class="col-md-8">
                                     {{ $venta->cliente->giro}}
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                          

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="hf-email">Credito maximo (Saldo)</label>
                                <div class="col-md-8">
                                     {{ $venta->cliente->credito_maximo}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label" for="text-input" >Credito </label>
                                <div class="col-md-8">
                                {{ $venta->cliente->credito}}
                                </div>
                            </div>


       
                        </div>



                    </div>
                </div><!--card-body-->
            </div><!--card-->
            {{-- Fin Cliente--}}



        </div>



    

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
                                    <th width="10%">Val Neto UN</th>
                                    <th width="10%">SubTotal</th>
                                    <th width="10%">IVA</th>
                                    <th width="10%">Total</th> 
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ( $venta->venta_detalle as  $detalle)
                                    <tr>
                                        <th>{{$detalle->producto->nombre}}  </th>
                                        <th>{{$detalle->cantidad_vendida}} </th>

                                        <th>  {{ floatval($detalle->valor_unitario) }}  </th>
                                        <th>  {{ floatval($detalle->valor_neto)}}  </th>
                                        <th>  {{$detalle->valor_iva}}  </th>
                                        <th>  {{$detalle->valor_total}}  </th> 

                                    </tr>

                                @endforeach
                                </tbody>

                            <tfoot>
                                <tr>
                                        <th colspan="4"></th>
                                        <th> Total: </th> 
                                        <th>  {{$venta->total}}  </th> 
                                    </tr>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th> Pagado: </th> 
                                        <th>  {{$venta->pagado}}  </th> 
                                    </tr>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th> Pendiente: </th> 
                                        <th>  {{$venta->pendiente_pago}}  </th> 
                                    </tr>

                            </tfoot>
                                
                                   

                            </table>
                        </div> <!--table-responsive-->

                    </div><!--card-body-->

                </div><!--card-->
            </div>
    </div>


    <div class="row">
            <div class="col-12 pl-0">
                <div class="card">
                    <div class="card-header">
                        <strong>Pagos realizados</strong>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                                <table class="table table-striped">
                                        <thead class="linea-top">
                                            <tr>
                                                <th class="center" width="10%"># Pago</th> 
                                                <th class="center" width="10%">Comprobante</th>
                                                <th class="center" width="10%">Tipo</th>
                                                <th class="center" width="10%">Fecha</th>
                                                <th class="center" width="10%">Valor</th>
                                                <th class="center" width="10%">Recibido por</th>
                                            </tr>
                                        </thead>
                                        <tbody class="linea-bot">
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($venta->venta_pago_tipo as $pago)
                                                <tr>
                                                    <td class="center">{{$i++}}</td> 
                                                    <td class="center">{{$pago->comprobante}}</td>
                                                    <td class="center">{{$pago->pago_tipo->nombre}}</td>
                                                    <td class="center">{{ $pago->created_at}}</td>
                                                    <td class="center">$ {{floatval($pago->monto)}}</td>
                                                    <td class="center">{{$pago->user->first_name}}  {{$pago->user->last_name}} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                         
                        
                        
                                    </table>
                        </div> <!--table-responsive-->

                    </div><!--card-body-->

                </div><!--card-->
            </div>
    </div>


     {{-- Fin seleccion de productos--}}
        

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
                                <label class="col-md-3 col-form-label">Tipo Venta</label>
                                <div class="col-md-9 col-form-label">
                                    <div class="form-check">
                                        <input class="form-check-input"  type="radio" value="1" name="tipo_venta" id="tp_1">
                                        <label class="form-check-label" for="radio1">Solo Cotizacion</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="2" name="tipo_venta" id="tp_2">
                                        <label class="form-check-label" for="radio1">Venta - Boleta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="3" name="tipo_venta" id="tp_3">
                                        <label class="form-check-label" for="radio1">Venta - Factura</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"   type="radio" value="4" name="tipo_venta" id="tp_4">
                                        <label class="form-check-label" for="radio1">Venta - Guia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"  type="radio" value="5" name="tipo_venta" id="tp_5">
                                        <label class="form-check-label" for="radio1">Cargar Cotizacion</label>
                                    </div>

                                </div>
                            </div>
 
                        </div>

                        <div class="col-9">
                            <div class="table-responsive">
                                <table class="table dataTable-small" id="tabla_fin">
                                    

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
                                            <th> </th>
                                            <th colspan="3">
                                            <input class="form-check-input" type="checkbox" name="venta_adelanto" id="venta_adelanto" value="">Venta con adelanto
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

      

 


       
 
 

        // boton pagar con efectivo 
        $('#btn-pago-1').click(function(e){
            e.preventDefault();
            var valor=   $('#pago-1').val();
            var total_total=   {{$venta->pendiente_pago}} ;
           
            if(valor==""){
                alert("Debe ingresar el monto pagado");
            }else{
                if(parseInt(valor) <  total_total ){
                    $('#pago-final-1').val(valor);
                }else{
                    var vuelto = parseInt(valor) - parseInt(total_total);
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
                var total_total=  {{$venta->pendiente_pago}} ;
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
                var total_total= {{$venta->pendiente_pago}} ;
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
                var total_total=  {{$venta->pendiente_pago}} ;
                $('#pago-final-5').val(total_total);
                totales();
            //}
        });



        $('#formulario').submit(function(e){
            e.preventDefault();
        });


 
 
            

 

        function totales() {

 


            var total_pagado=0;
            var total_venta = {{$venta->pendiente_pago}} ;

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



 
 

        $('body').on( "change", ".input-pago",function(){


            totales();

        });


      
        

        $("#btn_guardar").on('click',function() {

            $("#btn_guardar").attr("disabled", "true");
 
            var total_a_pagar = {{$venta->pendiente_pago}};
            var total_pagado =  $("#pagado").val();


            if( (total_a_pagar != total_pagado ) &&  !$('#venta_adelanto').is(":checked") ){
                
                    alert("La suma total difiere del total pagado");
                    $("#btn_guardar").removeAttr("disabled");
                
            }else{


            $.ajax({
                url: "{{route('admin.caja.pago.recibir.pagar.procesar')}}",
                type: "post",
                data: $("#formulario").serialize(),
                success: function (data) {
                    var respuesta = JSON.parse(data);
                    //console.log(respuesta);

                    if(respuesta.imprimir==1){
                       
                        window.open('{{route('admin.caja.venta.imprimir')}}/' + respuesta.venta_id, '_blank');
                        alert(respuesta.mensaje);
                       
                    }else{
                        $("#btn_guardar").removeAttr("disabled");
                    }


                    if(respuesta.mensaje){
                        alert(respuesta.mensaje);
                    }

                    if(respuesta.correcto == 1){


                       // location.reload();
                       window.location.href = "/admin/caja/pago/recibir";
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
            }

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
@endpush