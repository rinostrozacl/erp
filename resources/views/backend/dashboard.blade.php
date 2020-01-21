@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}! CI</strong>
                </div><!--card-header-->
                <div class="card-body">
                    {!! __('strings.backend.welcome') !!}
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <strong>  Total ventas Usuario</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                          <thead>
                          <tr>
                            <th>Mes</th>
                            <th>Monto</th>
                            <th>Status</th> 
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><a href="pages/examples/invoice.html">Neto</a></td>
                            <td></td>
                          
                          </tr>
                      
                          
                          </tbody>
                        </table>
                      </div> 
                    
                </div><!--card-body-->
            </div><!--card-->


        </div><!--col-->

    </div><!--row-->
@endsection
