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
                Cierres de caja disponibles
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable-small" id="tabla_venta">
                        <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Fecha</th>
                            <th>Usuario</th>

                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $cierres as  $cierre)
                            <tr>
                                <td>{{ $cierre->id }}</td>
                                <td>{{ $cierre->created_at }}</td>
                                <td>{{ $cierre->usuario->first_name }} {{ $cierre->usuario->last_name }}</td>
                                <td>
                                    <button class="btn btn-md btn-success btn_cerrar" data-cierre_id="{{ $cierre->id }}" type="button" id="">
                                        <i class="fa fa-dot-circle-o"></i>
                                        Cerrar
                                    </button>
                                    <a class="btn btn-md btn-primary" href="{{ route('admin.caja.turno.verimprimir') }}/{{ $cierre->id }}" target="_blank">
                                            <i class="fa fa-dot-circle-o"></i>
                                            Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#formulario').submit(function(e){
            e.preventDefault();
        });

        $(".btn_cerrar").on('click',function() {

            var cierre_id = $(this).data("cierre_id");
            $.ajax({
                url: "{{route('admin.caja.rendir.cerrar')}}",
                type: "post",
                data: { cierre_id: cierre_id},
                success: function (data) {
                    alert("Cierre de caja finalizado");
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
