@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-home"></i> Bienvenido
                </div>
                <div class="card-body">
                    <a href="/login"  class="button btn-success">Iniciar Sesión</a>
                    <br>Username: admin@admin.com
                    <br>Password: secret
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

    <div class="row mb-4">
        <div class="col">

        </div><!--col-->
    </div><!--row-->

@endsection
