<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Movimiento;

class BibliotecaController extends Controller
{
    public function index()
    {
        $prestamos    = Movimiento::where('tipo', 'prestamo')
                            ->orderBy('fecha', 'desc')->get();
        $devoluciones = Movimiento::where('tipo', 'devolucion')
                            ->orderBy('fecha', 'desc')->get();

        return view('biblioteca', compact('prestamos', 'devoluciones'));
    }

    public function procesar(Request $request){
//Validar que nombre, pin y libro
        $request->validate([
            'nombre' => 'required',
            'pin'    => 'required',
            'libro'  => 'required',
        ]);

//Buscar usuario por nombre
        $usuario = Usuario::where('nombre', $request->nombre)->first();

        if (!$usuario) {
            return back()->with('error', 'Usuario no encontrado.')->withInput();
        }

// Comprobar pin
        if ($usuario->pin !== $request->pin) {
            return back()->with('error', 'Pin incorrecto.')->withInput();
        }

        $accion = $request->accion;

        if ($accion === 'prestar') {
            $usuario->prestados += 1;
            $usuario->save();

            Movimiento::create([
                'usuario_id' => $usuario->id,
                'tipo'       => 'prestamo',
                'libro'      => $request->libro,
                'fecha'      => now(),
            ]);

            $mensaje = 'Prestamo registrado correctamente.';

        } elseif ($accion === 'devolver') {
            if ($usuario->prestados <= 0) {
                return back()->with('error', 'El usuario no tiene libros prestados.')->withInput();
            }

            $usuario->prestados -= 1;
            $usuario->save();

            Movimiento::create([
                'usuario_id' => $usuario->id,
                'tipo'       => 'devolucion',
                'libro'      => $request->libro,
                'fecha'      => now(),
            ]);

            $mensaje = 'Devolucion registrada correctamente.';

        } else {
            return back()->with('error', 'Accion no reconocida.')->withInput();
        }
        $usuario = Usuario::find($usuario->id)->fresh();
    
        $prestamos    = Movimiento::where('tipo', 'prestamo')
                            ->orderBy('fecha', 'desc')->get();
        $devoluciones = Movimiento::where('tipo', 'devolucion')
                            ->orderBy('fecha', 'desc')->get();

        return view('biblioteca', compact('prestamos', 'devoluciones', 'mensaje', 'usuario'));
    }
}
