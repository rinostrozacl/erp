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
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4 mb-4">

                <div class="table-responsive col-6">
                    <h5  class="pt-1" >
                        Productos faltantes
                    </h5>
                    <table class="table" id="datatable4">
                        <thead>
                        <tr>
                            <th>Producto</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive col-6">
                    <h5  class="pt-1" >
                        Productos Sobrante
                    </h5>
                    <table class="table" id="datatable5">
                        <thead>
                        <tr>
                            <th>Producto</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a class="btn btn-success btn-sm" href="{{route('admin.bodega.inventario')}}">Volver</a>
                </div><!--col-->



                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
        @csrf

@endsection


@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){

            var tabla4= $('#datatable4').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.inventario.tabla4',$inventario->id)}}',
                columns: [
                    {data: 'producto', name: 'producto'}
                ]
            });
            var tabla4= $('#datatable5').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.bodega.inventario.tabla5',$inventario->id)}}',
                columns: [
                    {data: 'producto', name: 'producto'}
                ]
            });





        });

    </script>
@endpush

