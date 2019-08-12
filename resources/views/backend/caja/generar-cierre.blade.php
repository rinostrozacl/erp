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
             @if($ventas->count()>0)<div class="card-body">

                <div class="table-responsive">
                    <table class="table dataTable-small" id="tabla_venta">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Pagado</th>
                                <th>Efectivo</th>
                                <th>Tarjeta</th>
                                <th>Transferencia</th>
                                <th>Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $ventas as  $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->created_at }}</td>
                                <td>{{ $venta->cliente->nombre }}</td>
                                <td>{{ $venta->pagado }}</td>
                                <td>{{ $venta->pago_efectivo }}</td>
                                <td>{{ $venta->pago_tarjeta }}</td>
                                <td>{{ $venta->pago_transferencia }}</td>
                                <td>{{ $venta->pago_credito }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                                <tr>
                                        <td> </td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $venta->sum('pagado') }}</td>
                                        <td>{{ $venta->sum('pago_efectivo') }}  </td>
                                        <td>{{ $venta->sum('pago_tarjeta') }}  </td>
                                        <td>{{ $venta->sum('pago_transferencia') }}  </td>
                                        <td>{{ $venta->sum('pago_credito') }} </td>
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
                            @foreach ( $ventas as  $venta)
                                @if($venta->pago_tarjeta_nro<>0)
                                    [ {{ $venta->pago_tarjeta_nro }} X ${{ $venta->pago_tarjeta }} ]
                                @endif
                            @endforeach
                    </p>
            </div>
            <div class="card-header">
                    Detalle de los comprobantes de Transferencia
            </div>
            <div class="card-body">
                    <p class="card-text">
                            @foreach ( $ventas as  $venta)
                                @if($venta->pago_transferencia_nro<>0)
                                    [ {{ $venta->pago_transferencia_nro }} X ${{ $venta->pago_transferencia  }}  ]
                                @endif
                            @endforeach
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