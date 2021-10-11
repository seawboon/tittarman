<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ShopPromotion;
use App\ShopPromotionAction;
use App\ShopPromotionRule;
use App\ShopPromotionVariant;

class PromotionController extends Controller
{
    public function index()
    {
        //$promotions = ShopPromotion::active()->paginate(10);
        $promotions = ShopPromotion::paginate(10);
        //$promotions = ShopPromotion::get();
        return view('promotion.index', compact('promotions'));
    }

    public function create()
    {
        $types = [
          'promotion' => ShopPromotion::types(),
          'rule' => ShopPromotionRule::types(),
          'action' => ShopPromotionAction::types(),
        ];
        return view('promotion.create', compact('types'));
    }

    public function store()
    {
      $data = request()->validate([
        'promotion.name' => 'required',
        'promotion.code' => 'required',
        'promotion.type' => 'required',
        'promotion.description' => '',
        'promotion.began_at' => 'required',
        'promotion.ended_at' => 'required',
        'rule.type' => 'required',
        'rule.config' => '',
        'rule.config.amount' => 'required',
        'action.type' => 'required',
        'action.config' => '',
        'action.config.amount' => 'required',
      ]);

      $promotion = ShopPromotion::create($data['promotion']);
      $promotion->rule()->create($data['rule']);
      $promotion->action()->create($data['action']);

      return redirect()->route('promotions.edit', $promotion);
      /*$source = MarketSource::create($data);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('market-sources.index');
        break;

        case 'new':
          return redirect()->route('market-sources.market_create');
        break;
      }*/
    }

    public function edit(ShopPromotion $promotion)
    {
        $promotion->load('rule','action','variant');

        $types = [
          'promotion' => ShopPromotion::types(),
          'rule' => ShopPromotionRule::types(),
          'action' => ShopPromotionAction::types(),
        ];

        return view('promotion.edit', compact('types','promotion'));
    }

    public function update(ShopPromotion $promotion)
    {
      $data = request()->validate([
        'promotion.name' => 'required',
        'promotion.code' => 'required',
        'promotion.type' => 'required',
        'promotion.description' => '',
        'promotion.began_at' => 'required',
        'promotion.ended_at' => 'required',
        'rule.type' => 'required',
        'rule.config' => '',
        'rule.config.amount' => 'required',
        'action.type' => 'required',
        'action.config' => '',
        'action.config.amount' => 'required',
      ]);

      $promotion->update($data['promotion']);
      $promotion->rule->update($data['rule']);
      $promotion->action->update($data['action']);

      return redirect()->route('promotions.edit', $promotion);
      /*$source = MarketSource::create($data);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('market-sources.index');
        break;

        case 'new':
          return redirect()->route('market-sources.market_create');
        break;
      }*/
    }

}
