<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Prestamo;
use App\Models\Responsable;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        return view('auth.login');
    } 
    public function contraseña(){
        return view('auth.contraseña');
    } 
    public function dashboard(){

        $prestamos = Prestamo::select(
            'fecha_prestamo',
            'fecha_devolucion',
            'r.nombre',
            'c.usuarioNombre',
            'c.usuarioApellidoPat',
            'c.usuarioApellidoMat',
            'e.descripcion'
        )
            ->join('responsable AS r', 'prestamos.capturaUser', '=', 'r.id_responsable')
            ->join('colaborador as c', 'prestamos.idColaboradorEmpleado', '=', 'c.numeroColaborador')
            ->join('estatus as e', 'prestamos.estatus_idEstatus', '=', 'e.idEstatus')
            ->get();


        return view('auth.dashboard', ['prestamos' => $prestamos]);
       // return view('auth.dashboard');
    }

    public function verify(Request $request)
    {

        $credentials = $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        $user = Responsable::where('usuario', $credentials['usuario'])->first();

        // Verificar si se encontró al usuario y si la contraseña coincide

        if (!empty($credentials['password']) && $user && $user->getPlainTextPassword()) {
            if ($credentials['password'] == $user->getPlainTextPassword()) {
                return redirect()->route('auth.dashboard');
            } else {
                // Las contraseñas no coinciden, manejar el error aquí
                return redirect()->route('auth.login')->withInput();
            }
        } else {

            return redirect()->route('auth.login')->withInput();
        }
    }


    public function CapturaInventario(){
        return view('auth.CapturaInventario');
    }

    public function VistaPrestamo(){
        return view ('auth.VistaPrestamo');
    }
    //ESTE ES PRESTAMO DE EQUIPOS
    public function Prestamo(){
        return view('auth.Prestamo');
    }
    //ESTE ES REPORTES DE PRESTAMOS
    public function ReportePrestamo(){
        return view('auth.ReportePrestamo');
    }
    public function ReporteResguardo(){
        return view('auth.ReporteResguardo');
    }
    public function SinAsignar(){
        return view('auth.SinAsignar');
    }
    //RUTAS DE LICENCIAS
    public function Licencias(){
        return view('');
    }
    //CONTROL EQUIPOS
    public function ControlEquipo(){
        return view('auth.ControlEquipo');
    }
    public function ActualizarControl(){
        return view('auth.ActualizarControl');
    }
    public function CrearResguardo(){
        return view('auth.CrearResguardo');
    }

    public function CrearPrestamo(){
        return view('auth.CrearPrestamo');
    }
    public function AgregarUsuario(){
        return view('auth.AgregarUsuario');
    }
    public function AsignarEquipo(){
        return view('auth.AsignarEquipo');
    }
    public function Responsiva(){
        return view('auth.Responsiva');
    }


}
