<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class JsonController extends Controller
{
    private function isValidJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    /**
     * Lista todos los ficheros JSON de la carpeta storage/app.
     * Se debe comprobar fichero a fichero si su contenido es un JSON válido.
     * para ello, se puede usar la función json_decode y json_last_error.
     *
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     * - contenido: Un array con los nombres de los ficheros.
     */
    public function index(): JsonResponse
    {
            $files = collect(Storage::files('app'))
                ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'json')
                ->map(fn($file) => basename($file));

            return response()->json([
                'mensaje' => 'Operación exitosa',
                'contenido' => $files->values()
    ]);
    }

   /**
     * Recibe por parámetro el nombre de fichero y el contenido. Devuelve un JSON con el resultado de la operación.
     * Si el fichero ya existe, devuelve un 409.
     * Si el contenido no es un JSON válido, devuelve un 415.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function store(Request $request): JsonResponse
    {
        $filename = $request->input('filename');
        $content = $request->input('content');

        // Validación de parámetros
        if (!$filename || !$content) {
            return response()->json(['mensaje' => 'Parámetros faltantes.'], 422);
        }

        // Verificar si el contenido es un JSON válido
        if (!is_array(json_decode($content, true))) {
            return response()->json(['mensaje' => 'Contenido no es un JSON válido'], 415);
        }

        // Verificar si el archivo ya existe
        if (Storage::exists("app/$filename")) {
            return response()->json(['mensaje' => 'El fichero ya existe'], 409);
        }

        // Crear el archivo con el contenido proporcionado
        Storage::put("app/$filename", $content);

        return response()->json(['mensaje' => 'Fichero guardado exitosamente']);
    
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
    public function show(string $filename): JsonResponse
    {
         // Verificar si el archivo existe
         if (!Storage::exists("app/$filename")) {
            return response()->json(['mensaje' => 'El fichero no existe'], 404);
        }

        // Leer el contenido del archivo
        $content = Storage::get("app/$filename");

        return response()->json([
            'mensaje' => 'Operación exitosa',
            'contenido' => json_decode($content, true)
        ]);
    }

   /**
     * Recibe por parámetro el nombre de fichero, el contenido y actualiza el fichero.
     * Devuelve un JSON con el resultado de la operación.
     * Si el fichero no existe devuelve un 404.
     * Si el contenido no es un JSON válido, devuelve un 415.
     * 
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function update(Request $request, string $filename): JsonResponse
    {
        $content = $request->input('content');

        // Validación de parámetros
        if (!$content) {
            return response()->json(['mensaje' => 'Parámetro de contenido faltante.'], 422);
        }

        // Verificar si el archivo existe
        if (!Storage::exists("app/$filename")) {
            return response()->json(['mensaje' => 'El fichero no existe'], 404);
        }

        // Verificar si el contenido es un JSON válido
        if (!is_array(json_decode($content, true))) {
            return response()->json(['mensaje' => 'Contenido no es un JSON válido'], 415);
        }

        // Actualizar el contenido del archivo
        Storage::put("app/$filename", $content);

        return response()->json(['mensaje' => 'Fichero actualizado exitosamente']);
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
    public function destroy(string $filename): JsonResponse
    {
         // Verificar si el archivo existe
         if (!Storage::exists("app/$filename")) {
            return response()->json(['mensaje' => 'El fichero no existe'], 404);
        }

        // Eliminar el archivo
        Storage::delete("app/$filename");

        return response()->json(['mensaje' => 'Fichero eliminado exitosamente']);
    }
    
}