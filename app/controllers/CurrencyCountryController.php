<?php

class CurrencyCountryController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$layout = "layouts.currency_country";
		$this->layout->content =  View::make('currency_country.create');	
	}
	public function show_countrycurrency()
	{
		$currency_country = DB::table('currency_country')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('currency_country.manage')->with('currency_country',$currency_country);	
	}
	public function store()	{
		
		$rules = array(
			'country_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('currency_country/create')
				->withErrors($validator);
		} else {
			$CurrencyCountryEntry = new CurrencyCountryEntry;
			$CurrencyCountryEntry->country_name      	   = Input::get('country_name');
			$CurrencyCountryEntry->country_currency	   	   = Input::get('country_currency');
			$CurrencyCountryEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$CurrencyCountryEntry->created_at		   = $date;
			$CurrencyCountryEntry->updated_at		   = $date;
			$CurrencyCountryEntry->save();

			return Redirect::to('currency_country');			
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'country_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('currency_country/edit')
				->withErrors($validator);
		} else {
			$CurrencyCountryEntry = CurrencyCountryEntry::find(Input::get('id'));
			$CurrencyCountryEntry->country_name      	= Input::get('country_name');
			$CurrencyCountryEntry->country_currency     	= Input::get('country_currency');
			$CurrencyCountryEntry->updated_by		= Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$CurrencyCountryEntry->updated_at		 = $date;
			$CurrencyCountryEntry->save();

			return Redirect::to('currency_country');
		}
	}
	public function edit_countrycurrency($id)
	{
		$country_currency = CurrencyCountryEntry::find($id);
		 return View::make('currency_country.edit')
            ->with('country_currency', $country_currency);
	}
	public function view_countrycurrency($id)
	{
		$country_currency = CurrencyCountryEntry::find($id);
		 return View::make('currency_country.view')
            ->with('country_currency', $country_currency);
	}
	public function delete_countrycurrency()
	{
		$id = Input::get('id');
		DB::table('currency_country')->where('id','=', $id)->delete();
		return Redirect::to('currency_country');
	}
	
}
?>