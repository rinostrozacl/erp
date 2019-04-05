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
                        Administración de categoría: Familia
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.general.familia.form') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i> Nuevo</a>
                    </div><!--btn-toolbar-->

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha ingreso</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">

                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">

                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection


@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var tabla= $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.general.familia.tabla')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            jQuery('#datatable tbody').on( "click", ".bt-desactivar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);


                if(boton.hasClass('btn-primary')){
                    boton.removeClass('btn-primary');
                    boton.addClass('btn-secondary');
                    boton.find('span').html("Activar")

                }else{
                    boton.removeClass('btn-secondary');
                    boton.addClass('btn-primary');
                    boton.find('span').html("Desactivar")
                }

                jQuery.ajax({
                    url: "{{ route('admin.general.familia.activar') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        jQuery.each(data.errors, function(key, value){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>'+value+'</p>');
                        });
                        if(data.estado==1){
                            alert(data.msg);
                        }

                    }

                });
            });

            jQuery('#datatable tbody').on( "click", ".bt-eliminar",function(){
                //e.preventDefault();
                var boton=  jQuery(this);
                var id=  boton.data('id');
                //alert('aa'+ id);
                jQuery.ajax({
                    url: "{{ route('admin.general.familia.eliminar') }}",
                    method: 'post',
                    data: { id: id},
                    success: function(data){
                        if(data.estado==1){
                            alert(data.msg);
                            tabla.ajax.reload();
                        }

                    }

                });
            });
        });


    </script>
@endpush

