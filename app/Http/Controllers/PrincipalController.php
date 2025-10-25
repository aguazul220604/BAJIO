<?php

namespace App\Http\Controllers;

use App\Models\departamentos;
use App\Models\lugares;
use App\Models\colaboradores;
use App\Models\enlaces;
use App\Models\directorio;
use App\Models\novedades;
use App\Models\horarios;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class PrincipalController extends Controller
{
    public function index()
    {
        $lugares = lugares::all();
        $departamentos = departamentos::all();
        return view('index', compact('departamentos', 'lugares'));
    }
    public function about($id)
    {
        /*  $principal = colabordores->firstWhere('id_rol', 1)
            ->get()
            ->map(function ($principal) {
                $principal->descripcion = str_replace('. ', ".\n", $principal->descripcion);
                return $jefe;
            });
*/
        $departamento = departamentos::where('id', $id)
            ->select(DB::raw('UPPER(nombre) as nombre'), 'id')
            ->firstOrFail();


        $colaboradores = colaboradores::where('id_departamento', $id)
            ->select('nombre', 'id_rol', 'descripcion', 'genero', 'img')
            ->get();

        // Verificar si hay un colaborador con id_rol == 1
        $principal = $colaboradores->firstWhere('id_rol', 1);

        // Si no hay, buscar con id_rol == 2
        if (!$principal) {
            $principal = $colaboradores->firstWhere('id_rol', 2);
        }

        // Si sigue siendo null, asignar un objeto vacío para evitar errores en la vista
        if (!$principal) {
            $principal = (object) [
                'nombre' => 'No disponible',
                'descripcion' => 'No hay información disponible',
                'img' => 'default.jpg', // Imagen por defecto en storage/app/public
            ];
        } else {
            // Agregar salto de línea después de cada punto
            $descripcion = wordwrap($principal->descripcion, 50, "\n", true);
            $descripcion = str_replace('. ', ".\n \n", $descripcion);
            $principal->descripcion = $descripcion;
        }

        $enlaces = enlaces::where('id_departamento', $id)->select('descripcion', 'enlace')->get();
        $extensiones = directorio::where('id_departamento', $id)->select('nombre', 'extension')->get();


        return view('about', compact('departamento', 'colaboradores', 'enlaces', 'extensiones', 'principal'));
    }

    public function guardias()
    {
        $calendarios = horarios::all();
        return view('guardias', compact('calendarios'));
    }

    public function diagramas()
    {
        $datos = DB::table('subestaciones')
            ->leftJoin('archivos', 'subestaciones.id', '=', 'archivos.id_subestacion')
            ->select('subestaciones.id', 'subestaciones.nombre', 'archivos.archivo')
            ->get();

        // Agrupar archivos por subestación manualmente
        $subestaciones = [];
        foreach ($datos as $dato) {
            if (!isset($subestaciones[$dato->id])) {
                $subestaciones[$dato->id] = [
                    'nombre' => $dato->nombre,
                    'archivos' => []
                ];
            }
            if ($dato->archivo) {
                $subestaciones[$dato->id]['archivos'][] = $dato->archivo;
            }
        }

        return view('diagramas', ['subestaciones' => $subestaciones]);
    }
    public function directorio()
    {
        $datos = DB::table('departamentos')
            ->leftJoin('directorio', 'departamentos.id', '=', 'directorio.id_departamento')
            ->select('departamentos.id', 'departamentos.nombre', 'directorio.id as directorio_id', 'directorio.extension', 'directorio.nombre as nombre_extension')
            ->get();

        // Obtener todos los departamentos desde el modelo
        $departamentos = departamentos::all();

        // Agrupar datos por departamento
        $directorio = [];

        foreach ($datos as $dato) {
            if (!isset($directorio[$dato->id])) {
                $directorio[$dato->id] = [
                    'nombre' => $dato->nombre,
                    'extensiones' => []
                ];
            }

            // Verificar si hay una extensión asociada
            if ($dato->directorio_id) {
                $directorio[$dato->id]['extensiones'][] = [
                    'id' => $dato->directorio_id,
                    'nombre' => $dato->nombre_extension,
                    'extension' => $dato->extension
                ];
            }
        }

        // Pasar datos a la vista
        return view('directorio', [
            'directorio' => $directorio,
            'departamentos' => $departamentos
        ]);
    }

    public function sitios()
    {
        $datos = DB::table('departamentos')
            ->leftJoin('enlaces', 'departamentos.id', '=', 'enlaces.id_departamento')
            ->select('departamentos.id', 'departamentos.nombre', 'enlaces.id as enlace_id', 'enlaces.enlace', 'enlaces.descripcion')
            ->get();

        // Obtener todos los departamentos desde el modelo
        $departamentos = departamentos::all();

        // Agrupar datos por departamento
        $enlaces = [];

        foreach ($datos as $dato) {
            if (!isset($enlaces[$dato->id])) {
                $enlaces[$dato->id] = [
                    'nombre' => $dato->nombre,
                    'enlaces' => []
                ];
            }

            // Verificar si hay enlaces asociados
            if ($dato->enlace_id) {
                $enlaces[$dato->id]['enlaces'][] = [
                    'id' => $dato->enlace_id,
                    'nombre' => $dato->descripcion,
                    'enlace' => $dato->enlace
                ];
            }
        }

        // Pasar datos a la vista
        return view('sitios', [
            'enlaces' => $enlaces,
            'departamentos' => $departamentos
        ]);
    }

    public function noticias()
    {
        $noticias = novedades::all(); // Obtiene todas las noticias

        // Recorremos cada noticia y modificamos su descripción
        $noticias->transform(function ($noticia) {
            $descripcion = wordwrap($noticia->descripcion, 110, "\n", true);
            $descripcion = str_replace('. ', ".\n", $descripcion);
            $noticia->descripcion = $descripcion; // Asigna la nueva descripción
            return $noticia;
        });

        return view('noticias', compact('noticias'));
    }
}
