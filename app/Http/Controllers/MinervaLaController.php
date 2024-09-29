<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MinervaLaController extends Controller
{
    public function showAula($id)
    {
        // Inicializar las variables
        $aulaData = null;
        $referenciaData = null;
        $zonaRelacionada = null;
        $imagenes = [];

        // Obtener datos del aula
        $aulaResponse = Http::get('https://ues-api-production.up.railway.app/aulas/' . $id);
        $zonasResponse = Http::get('https://ues-api-production.up.railway.app/zonas');

        if ($aulaResponse->successful() && !empty($aulaResponse->json()['data'])) {
            $aulaData = $aulaResponse->json()['data'];
            $zonaRelacionada = collect($zonasResponse->json()['data'])->firstWhere('id', $aulaData['zona']);
            $imagenes = explode(',', $aulaData['fotos']);
        }

        // Pasar los datos a la vista
        return view('minerva-la', compact('aulaData', 'referenciaData', 'imagenes', 'zonaRelacionada'));
    }

    public function showReferencia($id)
    {
        // Inicializar las variables
        $aulaData = null;
        $referenciaData = null;
        $zonaRelacionada = null;
        $imagenes = [];

        // Obtener datos de la referencia
        $referenciaResponse = Http::get('https://ues-api-production.up.railway.app/referencias/' . $id);
        $zonasResponse = Http::get('https://ues-api-production.up.railway.app/zonas');

        if ($referenciaResponse->successful() && !empty($referenciaResponse->json()['data'])) {
            $referenciaData = $referenciaResponse->json()['data'];
            $zonaRelacionada = collect($zonasResponse->json()['data'])->firstWhere('id', $referenciaData['zona']);
            $imagenes = explode(',', $referenciaData['foto']);
        }

        // Pasar los datos a la vista
        return view('minerva-la', compact('aulaData', 'referenciaData', 'imagenes', 'zonaRelacionada'));
    }


}
