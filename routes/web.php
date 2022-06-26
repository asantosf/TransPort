<?php

use App\Models\Administracion\Producto;
use App\Models\Administracion\Rol;
use App\Models\Administracion\Ventas;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', function () {
    return view('auth.login');
} )->name('login');

Route::post('loginAuth', 'Auth\LoginController@login')->name('loginAuth'); 
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('home', function () {
            
            return view('index', compact('rolName'));
    })->name('home');

    Route::get('home', function () {

        $ventasCount = 0;

        $comprasCount = 0;

            return view('index', compact('ventasCount', 'comprasCount'));
    })->name('home');

    //Materia Prima routes
    Route::get('homeMateriaPrima', 'Administracion\ProductoController@indexMateriaPrima')->name('homeMateriaPrima');
    Route::post('guardarMateriaPrima', 'Administracion\ProductoController@storeMateriaPrima')->name('guardarMateriaPrima');
    Route::post('materiaPrimaTabla', 'Administracion\ProductoController@materiaPrimaTabla')->name('materiaPrimaTabla');
    Route::post('eliminarMateriaPrima', 'Administracion\ProductoController@destroyMateriaPrima')->name('eliminarMateriaPrima');
    Route::post('editarMateriaPrima', 'Administracion\ProductoController@showMateriaPrima')->name('editarMateriaPrima');
    Route::post('actualizarMateriaPrima', 'Administracion\ProductoController@updateMateriaPrima')->name('actualizarMateriaPrima');

    //Produccion routes
    Route::get('homeProduccion', 'Administracion\ProductoController@indexProduccion')->name('homeProduccion');
    Route::post('guardarProduccion', 'Administracion\ProductoController@storeProduccion')->name('guardarProduccion'); 
    Route::post('cargarGuardarProducto', 'Administracion\ProductoController@cargarGuardarProducto')->name('cargarGuardarProducto');
    Route::post('produccionTabla', 'Administracion\ProductoController@produccionTabla')->name('produccionTabla');
    Route::post('destroyProduccion', 'Administracion\ProductoController@destroyProduccion')->name('destroyProduccion');
    Route::post('editarProducto', 'Administracion\ProductoController@showProduccion')->name('editarProducto');
    Route::post('updateProducto', 'Administracion\ProductoController@updateProducto')->name('updateProducto');
    Route::post('materiaPrimaDisponible', 'Administracion\ProductoController@materiaPrimaDisponible')->name('materiaPrimaDisponible');
    Route::post('buscarProducto', 'Administracion\ProductoController@buscarProducto')->name('buscarProducto');
    Route::post('selectPlantaProducto', 'Administracion\ProductoController@selectPlantaProducto')->name('selectPlantaProducto');
    Route::post('showProduccion', 'Administracion\ProductoController@showProduccion')->name('showProduccion');

    //Plantas routes
    Route::get('homePlantas', 'Plantas\PlantasController@index')->name('homePlantas');
    Route::post('guardarPlanta', 'Plantas\PlantasController@store')->name('guardarPlanta');
    Route::post('plantasTable', 'Plantas\PlantasController@plantasTable')->name('plantasTable');
    Route::post('eliminarPlanta', 'Plantas\PlantasController@destroy')->name('eliminarPlanta');
    Route::post('editarPlanta', 'Plantas\PlantasController@show')->name('editarPlanta');
    Route::post('actualizarPlanta', 'Plantas\PlantasController@update')->name('actualizarPlanta'); 

    //Ubicaciones routes
    Route::get('homeUbicaciones', 'Plantas\PlantasController@homeUbicaciones')->name('homeUbicaciones');
    Route::post('ubicacionesPlanta', 'Plantas\PlantasController@ubicacionesPlanta')->name('ubicacionesPlanta'); 
    Route::post('storeUbicacion', 'Plantas\PlantasController@storeUbicacion')->name('storeUbicacion'); 
    Route::post('deleteUbicacion', 'Plantas\PlantasController@deleteUbicacion')->name('deleteUbicacion'); 
    Route::post('tablaUbicaciones', 'Plantas\PlantasController@tablaUbicaciones')->name('tablaUbicaciones');
    Route::post('selectMunicipioUbicacion', 'Plantas\PlantasController@selectMunicipioUbicacion')->name('selectMunicipioUbicacion'); 

    //ordenes routes
    Route::get('homeOrdenes', 'Administracion\VentasController@index')->name('homeOrdenes');
    Route::post('disponible', 'Administracion\VentasController@disponible')->name('disponible'); 
    Route::post('guardarOrden', 'Administracion\VentasController@store')->name('guardarOrden'); 
    Route::post('devolucionOrden', 'Administracion\VentasController@devolucionOrden')->name('devolucionOrden'); 
    Route::post('devolucionOrdenView', 'Administracion\VentasController@devolucionOrdenView')->name('devolucionOrdenView');
    Route::post('removerUlitmo', 'Administracion\VentasController@removerUlitmo')->name('removerUlitmo'); 
    Route::post('validaNIT', 'Administracion\VentasController@validaNIT')->name('validaNIT');

    //temporales routes
    Route::post('temporal', 'Administracion\TemporalController@temporal')->name('temporal'); 
    Route::post('detalleTemp', 'Administracion\TemporalController@detalleTemp')->name('detalleTemp'); 
    Route::post('borrarPendiente', 'Administracion\TemporalController@borrarPendiente')->name('borrarPendiente'); 

    //clientes routes
    Route::get('homeClientes', 'Administracion\ClientesController@index')->name('homeClientes'); 
    Route::get('clientesTabla', 'Administracion\ClientesController@clientesTabla')->name('clientesTabla'); 
    Route::post('guardarCliente', 'Administracion\ClientesController@store')->name('guardarCliente'); 
    Route::post('selectMunicipio', 'Administracion\ClientesController@selectMunicipio')->name('selectMunicipio'); 
    Route::post('eliminarCliente', 'Administracion\ClientesController@destroy')->name('eliminarCliente'); 
    Route::post('editarCliente', 'Administracion\ClientesController@show')->name('editarCliente');
    Route::post('actualizarCliente', 'Administracion\ClientesController@update')->name('actualizarCliente');
    Route::post('buscarCliente', 'Administracion\ClientesController@buscarCliente')->name('buscarCliente'); 

    //empleados routes
    Route::get('empleados', 'Administracion\EmpleadoController@index')->name('empleados');
    Route::get('empleadoTabla', 'Administracion\EmpleadoController@empleadoTabla')->name('empleadoTabla'); 
    Route::post('guardarEmpleado', 'Administracion\EmpleadoController@store')->name('guardarEmpleado'); 
    Route::post('eliminarEmpleado', 'Administracion\EmpleadoController@destroy')->name('eliminarEmpleado'); 
    Route::post('editarEmpleado', 'Administracion\EmpleadoController@show')->name('editarEmpleado');
    Route::post('actualizarEmpleado', 'Administracion\EmpleadoController@update')->name('actualizarEmpleado');
 
    //usuario routes
    Route::get('homeUsuario', 'Administracion\HomeController@homeUsuario')->name('homeUsuario');
    Route::post('buscarEmpleado', 'Administracion\HomeController@buscarEmpleado')->name('buscarEmpleado');
    Route::post('guardarUsuario', 'Administracion\HomeController@guardarUsuario')->name('guardarUsuario'); 
    Route::get('usuariosTabla', 'Administracion\HomeController@usuariosTabla')->name('usuariosTabla'); 
    Route::post('eliminarUsuario', 'Administracion\HomeController@eliminarUsuario')->name('eliminarUsuario'); 
    Route::post('resetPassword', 'Administracion\HomeController@resetPassword')->name('resetPassword');
    Route::post('actualizarPassword', 'Administracion\HomeController@actualizarPassword')->name('actualizarPassword');

    //reportes routes
    Route::get('reporteVentas', 'Administracion\VentasController@getReportView')->name('reporteVentas');
    Route::post('tablaVentas', 'Administracion\VentasController@tablaVentas')->name('tablaVentas');
    Route::post('orderDetail', 'Administracion\VentasController@orderDetail')->name('orderDetail'); 
    Route::post('finalizarOrden', 'Administracion\VentasController@finalizarOrden')->name('finalizarOrden');
});

