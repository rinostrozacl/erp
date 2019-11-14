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




        {{-- Seleccion de productos--}}
        <div class="card">
            <div class="card-header">
                Detalle de las ventas realizadas
            </div>
             @if($ventas_pago->count() > 0)<div class="card-body">

                <div class="table-responsive">
                    <table class="table dataTable-small" id="tabla_venta">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Cliente</th>  
                                <th>Efectivo</th>
                                <th>Tarjeta</th>
                                <th>Transferencia</th>
                                <th>Cheque</th>
                                <th>Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t_efectivo=0;
                                $t_pago_tarjeta=0;
                                $t_pago_transferencia  = 0;
                                $t_pago_cheque = 0;
                                $t_pago_credito = 0;
                                $t_total =0;
                                $comprobante_debito="";
                            @endphp
                            @foreach ( $ventas_pago as  $venta_pago)

                                @php
                                     $t_total_venta=0;
                                     $comp_deb="";

                                    $user_id= auth()->user()->id;

                                    $p_efectivo = 0;
                                    $p_pago_tarjeta = 0;
                                    $p_pago_transferencia = 0;
                                    $p_pago_cheque = 0;
                                    $p_pago_credito = 0; 
                                    if($venta_pago->pago_tipo_id == 1){

                                        $p_efectivo = $venta_pago->monto;  
                                        $t_efectivo += $p_efectivo;

                                    } else if($venta_pago->pago_tipo_id == 2){

                                        $p_pago_tarjeta =  $venta_pago->monto;   
                                        $t_pago_tarjeta += $p_pago_tarjeta;

                                        $comprobante_debito =   $comprobante_debito . " [" . $venta_pago->comprobante ." x $" . $venta_pago->monto . "]";
                                        $comp_deb ="(". $venta_pago->comprobante .")";
                                    } else if($venta_pago->pago_tipo_id == 3){

                                        $p_pago_transferencia =  $venta_pago->monto;   
                                        $t_pago_transferencia += $p_pago_transferencia;
 
                                    }else if($venta_pago->pago_tipo_id == 4){

                                        $p_pago_cheque =  $venta_pago->monto;   
                                        $t_pago_cheque += $p_pago_cheque;

                                    }else if($venta_pago->pago_tipo_id == 5){

                                        $p_pago_credito =  $venta_pago->monto;   
                                        $t_pago_credito += $p_pago_credito;

                                    }
                                                                            
                                    
  
 
                                @endphp
                               


                        
                                <tr>
                                    <td>{{ $venta_pago->venta->id }}</td>
                                    <td>{{ $venta_pago->venta->created_at }}</td>
                                    <td>{{ $venta_pago->venta->cliente->nombre }}</td>  
                                    <td>{{ $p_efectivo }}</td>
                                    <td>{{ $p_pago_tarjeta }} {{ $comp_deb }}</td>
                                    <td>{{ $p_pago_transferencia }}</td>
                                    <td>{{ $p_pago_cheque }}</td>
                                    <td>{{ $p_pago_credito }}</td>
                                </tr>
                              

                            @endforeach
                        </tbody>
                        <tfoot>
                                <tr>
                                        <td> </td>
                                        <td></td>
                                        <td></td>  
                                        <td>{{ $t_efectivo }}  </td>
                                        <td>{{ $t_pago_tarjeta }}  </td>
                                        <td>{{ $t_pago_transferencia }}  </td>
                                        <td>{{ $t_pago_cheque }}  </td>
                                        <td>{{ $t_pago_credito}} </td>
                                    </tr>
                        </tfoot>
                    </table>
                </div> <!--table-responsive-->

            </div><!--card-body-->
            <div class="card-header">
                    Detalle de los comprobantes de Redcompra
            </div>
            <div class="card-body">
                    <p class="card-text">
                        {{  $comprobante_debito  }} 
                    </p>
            </div>
            <div class="card-header">
                    Detalle de los comprobantes de Transferencia
            </div>
            <div class="card-body">
                    <p class="card-text">
                          
                        
                        </p>
            </div>
            <div class="card-footer">
                    <button class="btn btn-md btn-success float-right" type="button" id="btn_guardar">
                        <i class="fa fa-dot-circle-o"></i>
                        Generar comprobante de cierre de caja
                    </button>
            </div>
            @else
                <div class="card-body">
                        <p class="card-text">
                               No esxisten ventas que rendir
                        </p>
                </div>
            @endif
        </div><!--card-->



        <div class="card">





            </div>

       {{-- Fin seleccion de productos--}}




        </form>



@endsection

<script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>


    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#formulario').submit(function(e){
            e.preventDefault();
        });

        $("#btn_guardar").on('click',function() {

            $.ajax({
                url: "{{route('admin.caja.turno.guardar')}}",
                type: "post",
                data: $("#formulario").serialize(),
                success: function (data) {
                    var respuesta = $.parseJSON( data);
                    //console.log(respuesta);
                    alert("Caja cerrada");
                    window.open('{{ route('admin.caja.turno.verimprimir') }}/' + respuesta, '_blank');
                    alert("Comprobante generado");
                    location.reload();
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
