<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelloWorldController extends Controller
{
    /**
     * Lista todos los ficheros de la carpeta storage/app.
     *
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     * - contenido: Un array con los nombres de los ficheros.
     */
    public function index()
    {
        $files = \Storage::files(); 
        return response()->json([
            'mensaje' => 'Lista de archivos obtenida correctamente',
         'archivos' => $files
        ]);
    }

     /**
     * Recibe por parámetro el nombre de fichero y el contenido. Devuelve un JSON con el resultado de la operación.
     * Si el fichero ya existe, devuelve un 409.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function store(Request $request)
    {
        $filename = $request->input('filename');
    $content = $request->input('content');

    if (!$filename || !$content) {
        return response()->json(['mensaje' => 'Parámetros faltantes'], 422);
    }

    if (\Storage::exists($filename)) {
        return response()->json(['mensaje' => 'El archivo ya existe'], 409);
    }

    \Storage::put($filename, $content);

    return response()->json(['mensaje' => 'Archivo creado exitosamente']);

    }

     /**
     * Recibe por parámetro el nombre de fichero y devuelve un JSON con su contenido
     *
     * @param name Parámetro con el nombre del fichero.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     * - contenido: El contenido del fichero si se ha leído con éxito.
     */
    public function show(string $filename)
    {
       
    if (!\Storage::exists($filename)) {
        return response()->json(['mensaje' => 'Archivo no encontrado'], 404);
    }

    $content = \Storage::get($filename);

    return response()->json([
        'mensaje' => 'Archivo leído correctamente',
        'contenido' => $content
    ]);

    }

    /**
     * Recibe por parámetro el nombre de fichero, el contenido y actualiza el fichero.
     * Devuelve un JSON con el resultado de la operación.
     * Si el fichero no existe devuelve un 404.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function update(Request $request, string $filename)
    {
         $content = $request->input('content');

    if (!$content) {
        return response()->json(['mensaje' => 'Parámetro de contenido faltante'], 422);
    }

    if (!\Storage::exists($filename)) {
        return response()->json(['mensaje' => 'Archivo no encontrado'], 404);
    }

    \Storage::put($filename, $content);

    return response()->json(['mensaje' => 'Archivo actualizado correctamente']);

    }

    /**
     * Recibe por parámetro el nombre de ficher y lo elimina.
     * Si el fichero no existe devuelve un 404.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function destroy(string $filename)
    {

    if (!\Storage::exists($filename)) {
        return response()->json(['mensaje' => 'Archivo no encontrado'], 404);
    }

    \Storage::delete($filename);

    return response()->json(['mensaje' => 'Archivo eliminado correctamente']);
    }
}
