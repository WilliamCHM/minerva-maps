<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MinervaController extends Controller
{
    public function index()
    {
        // Consumir la API de zonas, referencias y aulas
        $zonasResponse = Http::get('https://ues-api-production.up.railway.app/zonas');
        $referenciasResponse = Http::get('https://ues-api-production.up.railway.app/referencias');
        $aulasResponse = Http::get('https://ues-api-production.up.railway.app/aulas');

        $departments = [];

        // Verificar que todas las respuestas fueron exitosas
        if ($zonasResponse->successful() && $referenciasResponse->successful() && $aulasResponse->successful()) {
            $zonasData = $zonasResponse->json()['data']; // Zonas
            $referenciasData = $referenciasResponse->json()['data']; // Referencias
            $aulasData = $aulasResponse->json()['data']; // Aulas

            // Agrupar referencias y aulas por zona
            foreach ($zonasData as $zona) {
                $zonaId = $zona['id'];
                $zonaNombre = $zona['nombre'];

                // Filtrar las referencias que coincidan con la zona actual
                $filteredReferencias = array_filter($referenciasData, function($ref) use ($zonaId) {
                    return $ref['zona'] == $zonaId;
                });

                // Filtrar las aulas que coincidan con la zona actual
                $filteredAulas = array_filter($aulasData, function($aula) use ($zonaId) {
                    return $aula['zona'] == $zonaId;
                });

                // Cambiar el nombre de clave 'numero' a 'nombre' para que se maneje como referencia
                $filteredAulas = array_map(function($aula) {
                    $aula['nombre'] = $aula['numero'];  // Asignar 'numero' como 'nombre'
                    return $aula;
                }, $filteredAulas);

                // Combinar las referencias y aulas en un solo array
                $combinedData = array_merge($filteredReferencias, $filteredAulas);

                // Ordenar alfabéticamente por nombre
                usort($combinedData, function($a, $b) {
                    $nombreA = isset($a['nombre']) ? $a['nombre'] : '';
                    $nombreB = isset($b['nombre']) ? $b['nombre'] : '';
                    return strcmp($nombreA, $nombreB);
                });

                // Añadir las referencias y aulas agrupadas al departamento correspondiente
                $departments[$zonaNombre] = $combinedData;
            }
        }

        // Pasar los datos de $departments a la vista
        return view('minerva', compact('departments'));
    }
}
