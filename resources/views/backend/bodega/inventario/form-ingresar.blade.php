@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')



    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Realizar inventario
                        <small class="text-muted"></small>
                    </h4>
                    <div class="alert alert-danger" style="display:none"></div>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">




                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Linea</label>
                        <div class="col-md-10">
                            {{$inventario->linea->nombre?? 'Todos'}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Familia</label>
                        <div class="col-md-10">
                            {{$inventario->familia->nombre?? 'Todos'}}

                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Producto</label>
                        <div class="col-md-10">

                            {{$inventario->producto->nombre?? 'Todos'}}

                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Ubicacion</label>
                        <div class="col-md-10">
                            {{$inventario->ubicacion->nombre?? 'Todos'}}


                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Articulos esperados</label>
                        <div class="col-md-10">
                            {{$inventario->inventario_unidad->count()}}
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Articulos ingresados</label>
                        <div class="col-md-10">
                            <span id="ingresados"> {{$inventario->ingresados}}</span>
                        </div><!--col-->
                    </div><!--form-group-->



                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="nombre">Escanear Codigo</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control"  id="codigo_ean13" name="codigo_ean13"   >
                            <input type="hidden"   name="inventario_id" id="inventario_id"  value="{{$inventario->id}}"  >

                        </div><!--col-->
                    </div><!--form-group-->


                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a class="btn btn-danger btn-sm" href="{{route('admin.bodega.inventario')}}">Cancelar</a>
                </div><!--col-->

                <div class="col text-right">
                    <button class="btn btn-success btn-sm pull-right" type="button" id="guardar">
                        Cerrar Inventario
                    </button>

                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
        @csrf

@endsection


@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#guardar').click(function(e){
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('admin.bodega.inventario.realizar.guardar') }}",
                    method: 'post',
                    data: {
                        inventario_id: $('#inventario_id').val(),
                    },
                    success: function(data){
                        if(data.estado==1){
                            bootbox.alert(data.mensaje, function(){
                                window.location.href ='{{route('admin.bodega.inventario')}}' ;
                            });
                        }
                    }
                });
                $('#formulario-editar').removeAttr('disabled');
            });





            $('#codigo_ean13').on('keypress', function (e) {

                if(e.which === 13){
                    e.preventDefault();
                    var id = $('#inventario_id').val();
                    var valor = $(this).val();
                    $.ajax({
                        url: "{{route('admin.bodega.inventario.realizar.codigo')}}",
                        type: "post",
                        data: {
                            id:id,
                            valor:valor
                        },
                        success: function (data) {
                            //var respuesta = $.parseJSON( data);
                            //console.log(respuesta);
                           if(data.estado==0){
                                alert(data.mensaje);
                            }else{
                               $("#ingresados").html(data.ingresados);
                           }
                        }
                    });
                    $(this).val('');

                }
            });


        });

    </script>
@endpush

