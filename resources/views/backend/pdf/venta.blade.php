<!DOCTYPE html>
<html>
<head>
    <title>{{$titulo}}</title>


    <style type="text/css">
        @page {
            margin: 22px 15px 5px 15px;
        }
        body{
            margin-top: 0;
            padding-top: 0;
        }
        * {
            font-family: sans-serif;
            font-size: 9px;
        }
        h1{
            font-size: 11px;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .table {
            width: 100%;
            margin-bottom: 0rem;
            background-color: transparent;
        }
        table {
            border-collapse: collapse;
        }
        * {
            font-family: sans-serif;
        }
        *, *::before, *::after {
            box-sizing: border-box;
        }
        user agent stylesheet
        table {
            display: table;
            border-collapse: separate;
            border-spacing: 2px;
            border-color: grey;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c8ced3;
        }
        .table th, .table td {
            padding: 0.6rem;
            vertical-align: top;
            border-top: 1px solid #c8ced3;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        img {
            margin: 0px;
        }
        .tb-minima tr td {
            padding: 1px;
        }
        .gris {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .linea-top{
            border-top: black 2px solid;
        }

        .linea-destacado{
            border: black 2px solid !important;
        }
        .linea-bot{
            border-bottom: black 2px solid;
        }
    </style>

    </head>
<body>

<table class="table tb-minima">
    <tr class="linea-top">
        <td class="left" width="30%" >
            <img src="data:image/jpeg;base64,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"
                 width="211" height="80">
        </td>
        <td class="center" width="40%" >
            <h1>FERRETERIA INDUSTRIAL Y SERVICIOS </h1><br>
            Soluciones integrales para la industria y personas, ferreteria e insumos metal/mecanicos, desarrollo y reparacion de piezas  mecanicas, proyectos de ingeniería hidraulica, neumatica y mas..
        </td>
        <td class="center" width="30%" >
            <h1>
                @if($venta->venta_estado_id == 1)
                    Cotizacion
                @endif
                    @if($venta->venta_estado_id != 1)
                        Venta
                    @endif
            </h1><br>
            <h1> Nº {{$venta->id}} </h1> <br>
            @php
                echo  date('d/m/Y h:i:s', $venta->created_at);
            @endphp

        </td>
    </tr>


</table>
<table class="table">
        <tr class="linea-top">
            <td class="right" width="15%">
                Nombre cliente:
            </td>
            <td class="left"  width="35%">
                 {{$venta->cliente->nombre}}
            </td>
            <td class="right"  width="15%">
                Giro cliente:
            </td>
            <td class="left"  width="35%">
                {{$venta->cliente->giro}}
            </td>
        </tr>

        <tr>
            <td class="right" >
                Rut cliente
            </td>
            <td class="left"  >
                {{$venta->cliente->rut}}
            </td>
            <td class="right"  >
                Direccion
            </td>
            <td class="left"  >
                {{$venta->cliente->direccion}}
            </td>
        </tr>
    </table>

            <table class="table table-striped">
                <thead class="linea-top">
                    <tr>
                        <th class="center" width="10%">#</th>
                        <th>Descripcion</th>
                        <th class="center" width="10%">Cantidad</th>
                        <th class="right" width="10%">Valor unitario</th>
                        <th class="right" width="10%">Valor neto</th>
                    </tr>
                </thead>
                <tbody class="linea-bot">
                    @php
                        $i=1;
                    @endphp
                    @foreach($venta->venta_detalle as $detalle)
                        <tr>
                            <td class="center">{{$i++}}</td>
                            <td class="left">{{$detalle->producto->nombre}}   ({{$detalle->producto->unidad_medida->nombre}})</td>
                            <td class="center">{{$detalle->cantidad_vendida}}</td>
                            <td class="right">$ {{floatval($detalle->valor_unitario)}}</td>
                            <td class="right">$ {{floatval($detalle->valor_neto)}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="linea-bot">
                    <tr>
                        <th class="right"  colspan="4">Total Neto</th>
                        <th class="right"><b>$ {{$venta->suma_neto}}</b></th>
                    </tr>
                    <tr>
                        <th class="right"  colspan="4">IVA</th>
                        <th class="right">$ {{$venta->iva}}</th>
                    </tr>
                    <tr>
                        <th class="right"  colspan="4">Total</th>
                        <th class="right">$ {{$venta->total}}</th>
                    </tr>
                        @if($venta->pagado>0 )
                            <tr class="gris linea-top">
                                <th class="right" colspan="4">Adelanto por parte del cliente</th>
                                <th class="right">$ {{$venta->pagado}}</th>
                            </tr>
                            <tr class="gris">
                                <th class="right" colspan="4">Saldo pendiente de pago</th>
                                <th class="right">$ {{$venta->pendiente_pago}}</th>
                            </tr>
                        @endif

                        @if($venta->pagado==$venta->total)
                            <tr class="gris ">
                                <th class="center linea-destacado" colspan="5"><h1>Pagado</h1></th>

                            </tr>

                        @endif
                        @if($venta->pagado > 0 && $venta->pagado<$venta->total)
                            <tr class="gris ">
                                <th class="center linea-destacado" colspan="5"> <b> Con anticipo de cliente</b> </th>
                            </tr>
                        @endif


                </tfoot>


            </table>

<table class="table">
    <tr >
        <td class="center"  colspan="3" >
            Es obligación presentar este documento para cualquier tipo de tramite post-venta.

            La empresa se reserva el derecho de reprogramar plazos de entrega.

            Todos los trabajos son garantizados. Las garantías serán recepcionadas bajo el sistema de cola remota y la empresa responderá bajo los plazos y condiciones  legales establecidos por la ley vigente.

            La empresa no se responsabiliza por pérdidas o daños sufridos en muestras, materiales o productos no retirados dentro de un plazo de 60 días corridos a partir de la notificación por el medio que el cliente indicó al generar este documento. 

            No se harán devoluciones por materiales que se hayan cortado. 

            Los términos y condiciones,contenidos en este documento reflejan exactamente lo solicitado por el cliente, por lo que se revisa y aprueba mediante firma en dos ejemplares (original comercio - copia cliente)
            <br>
            <br>
            <br>
        </td>

    </tr>

    <tr>
        <td class="right" >

        </td>
        <td class="asdadas linea-bot" width="30%"  >

        </td>
        <td class="right"  >

        </td>

    </tr>


    <tr>
        <td class="right" >

        </td>
        <td class="center">
            {{Auth()->user()->name}}
        </td>
        <td class="right"  >

        </td>

    </tr>
</table>




</body>
</html>