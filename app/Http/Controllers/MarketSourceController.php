<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MarketSource;


class MarketSourceController extends Controller
{
    public function index()
    {
        $sources = MarketSource::paginate(10);
        return view('source.markets', compact('sources'));
    }

    public function create()
    {
        return view('source.market_create');
    }

    public function store()
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $source = MarketSource::create($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('market-sources.index');
          break;

          case 'new':
            return redirect()->route('market-sources.market_create');
          break;
        }

    }

    public function edit(MarketSource $source)
    {
        return view('source.market_edit', compact('source'));
    }

    public function update(MarketSource $source)
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $source->update($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('market-sources.index');
          break;

          case 'new':
            return redirect()->route('market-sources.market_create');
          break;
        }

    }

}
