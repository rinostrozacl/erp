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
                Ventas pendiente de pago
            </div>
             @if($ventas->count()>0)<div class="card-body">

                <div class="table-responsive">
                    <table class="table dataTable-small" id="tabla_venta">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Pagado</th>
                                <th>Pendiente Pago</th> 
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t_efectivo=0;
                                $t_pago_tarjeta=0;
                                $t_pago_transferencia  = 0;
                                $t_pago_cheque = 0;
                                $t_pago_credito = 0;
                            @endphp
                            @foreach ( $ventas as  $venta)
    
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->created_at }}</td>
                                <td>@if ($venta->cliente)
                                    {{ $venta->cliente_id}} 
                                        @if ($venta->cliente_id >3)
                                        {{ $venta->cliente->nombre}} 
                                        @endif
                                    @endif
                                    ({{ $venta->contacto_nombre }} )</td>
                                <td>{{ $venta->pagado }}</td>
                                <td>{{ $venta->pendiente_pago  }}</td> 
                                <td> <a href="{{ route('admin.caja.pago.recibir.pagar',$venta->id ) }}" 
                                        class="btn btn-sm btn-block btn-success">
                                            <i class="glyphicon glyphicon-edit"></i> Ingresar
                                    </a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                                <tr>
                                        <td> </td>
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                        <td>   </td>
                                        
                                        <td> </td>
                                    </tr>
                        </tfoot>
                    </table>
                </div> <!--table-responsive-->

            </div><!--card-body-->
             
            @else
                <div class="card-body">
                        <p class="card-text">
                               No esxisten ventas de las cuales recibir pago
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
                     
                    //location.reload();
                  
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
