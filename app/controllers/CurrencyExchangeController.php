<?php

class CurrencyExchangeController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()	{
		$c = Input::get('cid');
		$m = Input::get('mm');
		$y = Input::get('yy');
		$currency = DB::table('currency_country')->where('id',$c)->pluck('country_currency');
		$layout = "layouts.currency_exchange";	

		$this->layout->content =  View::make('currency_exchange.create')->with('country',$c)->with('month',$m)->with('year',$y)->with('currency',$currency);	
	}
	
	public function show_currencyexchange()
	{
		$currency_exchange = DB::table('currency_exchange')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('currency_exchange.manage')->with('currency_exchange',$currency_exchange);	
	}
	public function store()	{
		
		$rules = array(
			'currency_rate'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('currency_exchange/create')
				->withErrors($validator);
		} else {
			$currency_date = Input::get('cyears').'-'.Input::get('cmonths').'-'.Input::get('cdays');
			$CurrencyExchchangeEntry = new CurrencyExchangeEntry;
			$CurrencyExchchangeEntry->country_id      	   = Input::get('country_id');
			$CurrencyExchchangeEntry->currency_name        = Input::get('currency_name');
			$CurrencyExchchangeEntry->currency_rate    	   = Input::get('currency_rate');
			$CurrencyExchchangeEntry->currency_date    	   = $currency_date;
			$CurrencyExchchangeEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$CurrencyExchchangeEntry->created_at		   = $date;
			$CurrencyExchchangeEntry->updated_at		   = $date;
			$CurrencyExchchangeEntry->save();

			return Redirect::to('currency_exchange');			
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'currency_rate'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('currency_exchange/edit')
				->withErrors($validator);
		} else {
			$currency_date = Input::get('cyears').'-'.Input::get('cmonths').'-'.Input::get('cdays');
			$CurrencyExchchangeEntry = CurrencyExchangeEntry::find(Input::get('id'));
			$CurrencyExchchangeEntry->country_id      	   = Input::get('country_id');
			$CurrencyExchchangeEntry->currency_name        = Input::get('currency_name');
			$CurrencyExchchangeEntry->currency_rate    	   = Input::get('currency_rate');
			$CurrencyExchchangeEntry->currency_date    	   = $currency_date;
			$CurrencyExchchangeEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$CurrencyExchchangeEntry->created_at		   = $date;
			$CurrencyExchchangeEntry->updated_at		   = $date;
			$CurrencyExchchangeEntry->save();

			return Redirect::to('currency_exchange');
		}
	}
	public function edit_currencyexchange($id)
	{
		$currency_exchange = CurrencyExchangeEntry::find($id);
		 return View::make('currency_exchange.edit')
            ->with('currency_exchange', $currency_exchange);
	}
	public function view_currencyexchange($id)
	{
		$currency_exchange = CurrencyExchangeEntry::find($id);
		 return View::make('currency_exchange.view')
            ->with('currency_exchange', $currency_exchange);
	}
	public function delete_currencyexchange()
	{
		$id = Input::get('id');
		DB::table('currency_exchange')->where('id','=', $id)->delete();
		return Redirect::to('currency_exchange');
	}

	public function showbymonths(){
		$month = Input::get('month');
		$year = Input::get('year');
		return View::make('currency_exchange.manage')
            ->with('search_month', $month)->with('search_year',$year);
	}
}
?>