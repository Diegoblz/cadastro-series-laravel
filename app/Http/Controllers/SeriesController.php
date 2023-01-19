<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Temporada;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request) {
        $series = Serie::query()
            ->orderBy('nome')
            ->get();
        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie($request->nome, $request->qtd_temporadas,$request->ep_por_temporada);
//        $serie = Serie::create(['nome' => $request->nome]);
//        $qtdTemporadas = $request->qtd_temporadas;
//        for ($indiceTemporadas = 1; $indiceTemporadas <= $qtdTemporadas; $indiceTemporadas++) {
//            $temporada = $serie->temporadas()->create(['numero' => $indiceTemporadas]);
//            for ($indiceEpTem = 1; $indiceEpTem <= $request->ep_por_temporada; $indiceEpTem++) {
//                $temporada->episodios()->create(['numero' => $indiceEpTem]);
//            }
//        }
        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} criada com sucesso {$serie->nome}"
            );

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {

        $nomeSerie = $removedorDeSerie->removerSerie($request->id);


//        Serie::destroy($request->id);
//        $serie = Serie::find($request->id);
//        $serie->temporadas->each(
//            function (Temporada $temporada){
//                $temporada->episodios->each(function (Episodio $episodio){
//                    $episodio->delete();
//                });
//                $temporada->delete();
//            }
//        );
//        $serie->delete();


        $request->session()
            ->flash(
                'mensagem',
                "Série removida com sucesso"
            );
        return redirect()->route('listar_series');
    }
}
