<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-title">
                {{--@lang('menus.backend.sidebar.system')--}}
                Sistema
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/bodega*')) }}" href="#">
                    <i class="nav-icon icon-user"></i> Bodega
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/bodega/producto*')) }}" href="{{ route('admin.bodega.producto') }}">
                            Gestion de productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/bodega/entrada*')) }}" href="{{ route('admin.bodega.entrada') }}">
                            Movimiento de productos
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/bodega/inventario*')) }}" href="{{ route('admin.bodega.inventario') }}">
                            Realizar Inventario
                        </a>
                    </li>



                </ul>
            </li>








            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                    <i class="nav-icon icon-user"></i> Informes
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/informe/stock')) }}" href="{{ route('admin.informe.stock') }}">
                            Informe de stock
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/informe/stockcritico')) }}" href="{{ route('admin.informe.stockcritico') }}">
                            Informe de stock crítico
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/informe/movimiento')) }}" href="{{ route('admin.informe.movimiento') }}">
                            Historial de movimientos
                        </a>
                    </li>
                </ul>
            </li>







            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> General
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/cliente')) }}" href="{{ route('admin.general.cliente') }}">
                                Cliente
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/marca')) }}" href="{{ route('admin.general.marca') }}">
                                Marca
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/linea')) }}" href="{{ route('admin.general.linea') }}">
                                Línea
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/familia')) }}" href="{{ route('admin.general.familia') }}">
                                Familia
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/ubicacion')) }}" href="{{ route('admin.general.ubicacion') }}">
                                Ubicación
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/proveedor')) }}" href="{{ route('admin.general.proveedor') }}">
                                Proveedor
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/doctipocompra')) }}" href="{{ route('admin.general.doctipocompra') }}">
                                Tipo Doc Compra
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/general/doctipoventa')) }}" href="{{ route('admin.general.doctipoventa') }}">
                                Tipo Doc Venta
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i>  Acceso
                        {{--@lang('menus.backend.access.title')--}}

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                Usuarios

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                               Roles
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="divider"></li>

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
