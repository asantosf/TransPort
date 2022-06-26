<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <br>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <!--http://localhost/transport/public/img/user.png-->
            <img src="{{ asset('img/user.png') }}" alt="Image not found"
                style="border-radius: 50%; width: 50%; height: 50%">
        </div>
    </a>

    <div class="sidebar-brand-text mx-3 sidebar-brand d-flex align-items-center justify-content-center">{{ auth()->user()->name }} </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <span>Home</span></a>
    </li>

    <!-- Heading -->
    @if (auth()->user()->rol_id == 3 || auth()->user()->rol_id == 1)

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Produccion
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-cart-arrow-down"></i>
                <span>Materia Prima</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones</h6>
                    <a class="collapse-item" href="{{ route('homeMateriaPrima') }}">Control de Materia Prima</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-tag"></i>
                <span>Productos</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones</h6>
                    <a class="collapse-item" href="{{ route('homeProduccion') }}">Producción</a>
                </div>
            </div>
        </li>

    @endif

    @if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 1)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Ventas
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('homeClientes') }}">
                <i class="fa fa-user"></i>
                <span>Clientes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrden"
                aria-expanded="true" aria-controls="collapseOrden">
                <i class="fa fa-shopping-basket"></i>
                <span>Ordenes</span>
            </a>
            <div id="collapseOrden" class="collapse" aria-labelledby="headingOrden"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones</h6>
                    <a class="collapse-item" href="{{ route('homeOrdenes') }}">Crear Orden</a>
                    <a class="collapse-item" href="{{ route('reporteVentas') }}">Historial Ordenes</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider 
    if (auth()->user()->rol_id == 3)

    else 
        <!--hr class="sidebar-divider">

        <!-- Heading >
        <!--div class="sidebar-heading">
            Compras
        </div>

        <!-- Nav Item - Pages Collapse Menu >
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa fa-users"></i>
                <span>Proveedores</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa fa-truck"></i>
                <span>Compras</span>
            </a>
        </li>
    endif-->

    @if (auth()->user()->rol_id == 1 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 5)

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Administrador
        </div>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fa fa-tag"></i>
                <span>Empleados</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones</h6>
                    @if (auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1)
                        <a class="collapse-item" href="{{ route('empleados') }}">Administrador Empleados</a>
                    @endif
                    @if (auth()->user()->rol_id == 5 || auth()->user()->rol_id == 1)
                        <a class="collapse-item" href="{{ route('homeUsuario') }}">Crear Usuario de Acceso</a>
                    @endif
                </div>
            </div>
        </li>

        @if (auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlantas"
                    aria-expanded="true" aria-controls="collapsePlantas">
                    <i class="fa fa-university"></i>
                    <span>Plantas</span>
                </a>
                <div id="collapsePlantas" class="collapse" aria-labelledby="headingPlantas"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones</h6>
                        <a class="collapse-item" href="{{ route('homePlantas') }}">Administrador Plantas</a>
                        <a class="collapse-item" href="{{ route('homeUbicaciones') }}">Administrar Ubicaciones</a>
                    </div>
                </div>
            </li>
        @endif
    @else 

    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>