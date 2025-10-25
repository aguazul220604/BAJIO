<?php

namespace App\Http\Controllers;

use App\Models\departamentos;
use App\Models\jefes;
use App\Models\colaboradores;
use App\Models\enlaces;
use App\Models\directorio;
use App\Models\subestaciones;
use App\Models\archivos;
use App\Models\guardias;
use App\Models\calendario;
use App\Models\horarios;
use App\Models\personal;
use App\Models\novedades;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function admin()
    {
        $departamentos = departamentos::all();
        return view('departamentos', compact('departamentos'));
    }

    public function subestaciones()
    {
        $datos = DB::table('subestaciones')
            ->leftJoin('archivos', 'subestaciones.id', '=', 'archivos.id_subestacion')
            ->select('subestaciones.id', 'subestaciones.nombre', 'archivos.id as archivo_id', 'archivos.archivo')
            ->get();


        $zonas = subestaciones::all();

        // Agrupar archivos por subestación
        $subestaciones = [];
        foreach ($datos as $dato) {
            if (!isset($subestaciones[$dato->id])) {
                $subestaciones[$dato->id] = [
                    'nombre' => $dato->nombre,
                    'archivos' => []
                ];
            }
            if ($dato->archivo) {
                $subestaciones[$dato->id]['archivos'][] = [
                    'id' => $dato->archivo_id,
                    'nombre' => $dato->archivo
                ];
            }
        }


        return view('subestaciones', [
            'subestaciones' => $subestaciones,
            'zonas' => $zonas
        ]);
    }

    public function horarios()
    {
        $calendarios = horarios::all();

        // Usar Carbon para formatear la fecha y eliminar la hora
        foreach ($calendarios as $calendario) {
            $calendario->fecha = Carbon::parse($calendario->fecha)->format('Y-m-d');
        }

        return view('horarios', compact('calendarios'));
    }



    public function gestion($id)
    {
        if ($id == 1) {
            $personal = Personal::whereIn('id', [1, 7])->get();
        } else {
            $personal = Personal::whereBetween('id', [2, 6])->get();
        }
        $departamento = departamentos::where('id', $id)
            ->select(DB::raw('UPPER(nombre) as nombre'), 'id')
            ->firstOrFail();

        $colaboradores = colaboradores::join('personal', 'colaboradores.id_rol', '=', 'personal.id')
            ->where('colaboradores.id_departamento', $id)
            ->select('colaboradores.id', 'colaboradores.nombre', 'colaboradores.descripcion', 'colaboradores.genero', 'colaboradores.img', 'personal.puesto', 'colaboradores.id_rol')
            ->get();


        $enlaces = enlaces::where('id_departamento', $id)->select('id', 'descripcion', 'enlace')->get();
        $directorios = directorio::where('id_departamento', $id)->select('id', 'nombre', 'extension')->get();


        return view('gestion', compact('personal', 'departamento', 'colaboradores', 'enlaces', 'directorios'));
    }


    public function editar_admin(Request $request)
    {
        $request->validate([
            'nombre' => 'string|max:200',
            'descripcion' => 'string',
            'genero' => 'string|max:200',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validación de la imagen
        ]);

        $id_jefe = $request->input('jefe');
        $jefe = jefes::find($id_jefe);

        if (!$jefe) {
            return back()->with('message', 'error')->withErrors(['message' => 'Jefe no encontrado']);
        }

        $jefe->nombre = $request->input('nombre');
        $jefe->descripcion = $request->input('descripcion');
        $jefe->genero = $request->input('genero');

        if ($request->hasFile('img')) {
            // Eliminar la imagen anterior si existe
            if (!empty($jefe->img) && Storage::disk('public')->exists($jefe->img)) {
                Storage::disk('public')->delete($jefe->img);
            }


            // Guardar la nueva imagen
            $imagenPath = $request->file('img')->store('img', 'public');
            $jefe->img = $imagenPath;
        }

        if ($jefe->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with('message', 'error');
        }
    }
    public function crear_archivo(Request $request)
    {
        // Validación correcta
        $request->validate([
            'zona' => 'required|integer|exists:subestaciones,id',
            'archivo' => 'required|mimes:pdf|max:2048', // Máx. 2MB
        ]);

        // Procesar el archivo
        if ($request->hasFile('archivo')) {
            $archivoFile = $request->file('archivo');
            $archivoNombre = $archivoFile->getClientOriginalName(); // Nombre único
            $archivoPath = $archivoFile->storeAs('archivos', $archivoNombre, 'public'); // Guardar en storage/app/public/archivos

            // Guardar en la BD
            $archivo = new archivos();
            $archivo->id_subestacion = $request->input('zona');
            $archivo->archivo = $archivoNombre; // Guardamos la ruta del archivo en la BD

            if ($archivo->save()) {
                return back()->with('message', 'ok');
            }
        }

        return back()->with('message', 'error');
    }

    public function eliminar_archivo($id)
    {
        // Buscar el archivo en la base de datos
        $archivo = Archivos::find($id);

        if (!$archivo) {
            return back()->with('message', 'Archivo no encontrado');
        }

        // Ruta completa del archivo, asegurando que se busque en la carpeta "archivos/"
        $rutaArchivo = 'archivos/' . $archivo->archivo;

        // Eliminar el archivo del sistema de almacenamiento
        if (Storage::disk('public')->exists($rutaArchivo)) {
            Storage::disk('public')->delete($rutaArchivo);
        } else {
            return back()->with('message', 'El archivo no existe en el almacenamiento');
        }

        // Eliminar el registro de la base de datos
        $archivo->delete();

        return back()->with('message', 'Archivo eliminado con éxito');
    }

    public function crear_calendario(Request $request)
    {
        // Validación correcta
        $request->validate([
            'fecha' => 'required',
            'tipo' => 'required|string',
            'archivo' => 'required|mimes:pdf|max:3072', // Máx. 3MB
        ]);

        // Procesar el archivo
        if ($request->hasFile('archivo')) {
            $archivoFile = $request->file('archivo');
            $extension = $archivoFile->getClientOriginalExtension(); // Obtener la extensión del archivo
            $archivoNombre = pathinfo($archivoFile->getClientOriginalName(), PATHINFO_FILENAME); // Nombre sin extensión

            // Generar un nombre único (agregamos timestamp y un identificador único)
            $archivoNombreUnico = $archivoNombre . '_' . time() . '_' . uniqid() . '.' . $extension;

            // Guardar el archivo en storage/app/public/archivos con el nuevo nombre
            $archivoPath = $archivoFile->storeAs('archivos', $archivoNombreUnico, 'public');

            // Guardar en la BD
            $horario = new horarios();
            $horario->fecha = $request->input('fecha');
            $horario->tipo = $request->input('tipo');
            $horario->archivo = $archivoNombreUnico; // Guardamos el nuevo nombre en la BD

            if ($horario->save()) {
                return back()->with('message', 'ok');
            }
        }

        return back()->with('message', 'error');
    }


    public function eliminar_calendario($id)
    {
        // Buscar el archivo en la base de datos
        $archivo = horarios::find($id);

        if (!$archivo) {
            return back()->with('message', 'Archivo no encontrado');
        }

        // Ruta completa del archivo, asegurando que se busque en la carpeta "archivos/"
        $rutaArchivo = 'archivos/' . $archivo->archivo;

        // Eliminar el archivo del sistema de almacenamiento
        if (Storage::disk('public')->exists($rutaArchivo)) {
            Storage::disk('public')->delete($rutaArchivo);
        } else {
            return back()->with('message', 'El archivo no existe en el almacenamiento');
        }

        // Eliminar el registro de la base de datos
        $archivo->delete();

        return back()->with('message', 'Archivo eliminado con éxito');
    }

    public function crear_departamento(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $departamento = new departamentos();
        $departamento->nombre = $request->input('nombre');

        if ($departamento->save()) {
            return back()->with('message', 'ok');
        }
        return back()->with('message', 'error');
    }


    public function editar_departamento(Request $request, $id)
    {
        $validacion = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $departamento = departamentos::find($id);
        $departamento->nombre = $request->input('nombre');

        if ($departamento->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function eliminar_departamento($id)
    {
        DB::transaction(function () use ($id) {
            // Eliminar primero a los colaboradores
            colaboradores::where('id_departamento', $id)->delete();

            // Eliminar enlaces y directorio
            enlaces::where('id_departamento', $id)->delete();
            directorio::where('id_departamento', $id)->delete();

            // Finalmente, eliminar el departamento
            departamentos::findOrFail($id)->delete();
        });

        return back()->with('message', 'delete');
    }

    public function crear_colaborador(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'departamento' => 'required|exists:departamentos,id',
            'cargo' => 'required|exists:personal,id',
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'genero' => 'required|string|max:200',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validación de la imagen
        ]);

        // Manejar la subida de la imagen
        $imagePath = null;
        if ($request->hasFile('img')) {
            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('img')->getClientOriginalExtension();

            // Mover la imagen a public/images con el nombre único
            $request->file('img')->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        // Crear el colaborador
        $colaborador = new Colaboradores();
        $colaborador->id_departamento = $request->input('departamento');
        $colaborador->nombre = $request->input('nombre');
        $colaborador->id_rol = $request->input('cargo');
        $colaborador->descripcion = $request->input('descripcion');
        $colaborador->genero = $request->input('genero');
        $colaborador->img = $imagePath;

        if ($colaborador->save()) {
            return back()->with('message', 'ok2');
        }
        return back()->with('message', 'error');
    }


    public function editar_colaborador(Request $request)
    {
        $request->validate([
            'cargo2' => 'required|exists:personal,id',
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'genero' => 'required|string|max:200',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validación de la imagen
        ]);

        $id_colaborador = $request->input('colaborador');

        $colaborador = colaboradores::find($id_colaborador);
        $colaborador->nombre = $request->input('nombre');
        $colaborador->id_rol = $request->input('cargo2');
        $colaborador->descripcion = $request->input('descripcion');
        $colaborador->genero = $request->input('genero');

        if ($request->hasFile('img')) {
            // Eliminar imagen anterior si existe
            if ($colaborador->img && file_exists(public_path($colaborador->img))) {
                unlink(public_path($colaborador->img));
            }

            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('img')->getClientOriginalExtension();

            // Mover la imagen a public/images
            $request->file('img')->move(public_path('images'), $imageName);

            // Asignar la nueva ruta de la imagen
            $colaborador->img = 'images/' . $imageName;
        }


        if ($colaborador->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function eliminar_colaborador($id)
    {
        // Buscar al colaborador en la base de datos
        $colaborador = colaboradores::findOrFail($id);

        if ($colaborador->img) {
            $imagePath = public_path($colaborador->img); // Ruta completa de la imagen

            // Comprobar si la imagen existe en el servidor antes de eliminarla
            if (file_exists($imagePath)) {
                unlink($imagePath); // Eliminar la imagen
            }
        }

        // Eliminar el registro del colaborador
        $colaborador->delete();

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('message', 'delete');
    }



    public function crear_enlace(Request $request)
    {
        $request->validate([
            'departamento' => 'required|exists:departamentos,id',
            'descripcion' => 'required|string|max:350',
            'enlace' => 'required|string|max:350',
        ]);

        $enlaces = new enlaces();
        $enlaces->id_departamento = $request->input('departamento');
        $enlaces->descripcion = $request->input('descripcion');
        $enlaces->enlace = $request->input('enlace');

        if ($enlaces->save()) {
            return back()->with('message', 'ok3');
        }
        return back()->with('message', 'error');
    }

    public function editar_enlace(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:350',
            'enlace' => 'required|string|max:350',
        ]);
        $id_enlace = $request->input('enlace');

        $enlace = enlaces::find($id_enlace);
        $enlace->descripcion = $request->input('descripcion');
        $enlace->enlace = $request->input('link');

        if ($enlace->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function eliminar_enlace($id)
    {
        $enlace = enlaces::findOrFail($id);
        $enlace->delete();

        return back()->with('message', 'delete');
    }

    public function crear_directorio(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:350',
            'extensión' => 'required|regex:/^\d{5}$/',
        ]);

        $directorio = new directorio();
        $directorio->id_departamento = $request->input('departamento');
        $directorio->nombre = $request->input('nombre');
        $directorio->extension = $request->input('extensión');

        if ($directorio->save()) {
            return back()->with('message', 'ok4');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function editar_directorio(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:350',
            'extensión' => 'required|regex:/^\d{5}$/',
        ]);

        $id_directorio = $request->input('directorio');

        $directorio = directorio::find($id_directorio);
        $directorio->nombre = $request->input('nombre');
        $directorio->extension = $request->input('extensión');

        if ($directorio->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function eliminar_directorio($id)
    {
        $directorio = directorio::findOrFail($id);
        $directorio->delete();

        return back()->with('message', 'delete');
    }

    public function crear_guardia(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
        ]);

        $guardia = new guardias();
        $guardia->nombre = $request->input('nombre');

        if ($guardia->save()) {
            return back()->with('message', 'ok');
        }
        return back()->with('message', 'error');
    }

    public function editar_guardia(Request $request)
    {
        $request->validate([
            'nombre' => 'string|max:200',
        ]);

        $id_guardia = $request->input('guardia');

        $guardia = guardias::find($id_guardia);
        $guardia->nombre = $request->input('nombre');

        if ($guardia->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }

    public function eliminar_guardia($id)
    {
        $calendarios = calendario::where('id_guardia', $id)->get();

        foreach ($calendarios as $calendario) {
            $calendario->id_guardia = null;
            $calendario->save();
        }

        $guardia = guardias::findOrFail($id);
        $guardia->delete();
        return back()->with('message', 'delete');
    }

    public function editar_horario(Request $request)
    {
        $id_horario = $request->input('horario');

        $horario = calendario::find($id_horario);
        $horario->id_guardia = $request->input('guardia');

        if ($horario->save()) {
            return back()->with('message', 'update');
        } else {
            return back()->with(['message' => 'error']);
        }
    }
    public function novedades()
    {
        $noticias = novedades::all();
        return view('novedades', compact('noticias'));
    }

    public function createNovedades(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'Descripcion' => 'string',
            'Imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejar la subida de la imagen
        if ($request->hasFile('Imagen')) {
            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('Imagen')->getClientOriginalExtension();

            // Mover la imagen a public/images con el nombre único
            $imagePath = $request->file('Imagen')->move(public_path('images'), $imageName);
        } else {
            $imagePath = null; // Si no se sube imagen
        }

        $novedad = new novedades();
        $novedad->descripcion = $request->input('Descripcion');
        $novedad->img = 'images/' . $imageName;

        if ($novedad->save()) {
            return back()->with('message', 'ok');
        }
        return back()->with('message', 'error');
    }

    public function editNovedades(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'Descripcion' => 'nullable|string',
            'Imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ID' => 'required|exists:novedades,id' // Asegurar que el ID existe en la BD
        ]);

        // Buscar la novedad por ID
        $novedad = Novedades::find($request->input('ID'));

        if (!$novedad) {
            return back()->with('message', 'not_found');
        }

        // Manejar la subida de la imagen
        if ($request->hasFile('Imagen')) {
            // Eliminar imagen anterior si existe
            if ($novedad->img && file_exists(public_path($novedad->img))) {
                unlink(public_path($novedad->img));
            }

            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('Imagen')->getClientOriginalExtension();

            // Mover la imagen a public/images
            $request->file('Imagen')->move(public_path('images'), $imageName);

            // Asignar la nueva ruta de la imagen
            $novedad->img = 'images/' . $imageName;
        }

        // Actualizar la descripción si se proporciona
        if ($request->has('Descripcion')) {
            $novedad->descripcion = $request->input('Descripcion');
        }

        // Guardar cambios
        if ($novedad->save()) {
            return back()->with('message', 'update');
        }

        return back()->with('message', 'error');
    }
    public function deleteNovedades($id)
    {
        $novedad = Novedades::findOrFail($id);

        // Verificar si el registro tiene una imagen
        if ($novedad->img) {
            $imagePath = public_path($novedad->img); // Ruta completa de la imagen

            // Comprobar si la imagen existe en el servidor antes de eliminarla
            if (file_exists($imagePath)) {
                unlink($imagePath); // Eliminar la imagen
            }
        }

        // Eliminar el registro de la base de datos
        $novedad->delete();

        return back()->with('message', 'deleted');
    }
}
