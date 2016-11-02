<?php

class SettingsController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function showsettings(){
		$settings = DB::table('settings')->where('id','=',1)->first();
		$this->layout->content = View::make('settings.view')->with('settings',$settings);
	}
	public function savesettings(){
		$name = Input::get('name');
		$menu_color = Input::get('menu_color');
		$button_color = Input::get('button_main');
		$button_hover = Input::get('button_hover');
		$sidemenu_color = Input::get('sidemenu_main');
		$sidemenu_hover = Input::get('sidemenu_hover');
		$version = Input::get('version');
		DB::table('settings')->update(array(
			'name'=>$name,'menu_color'=>$menu_color, 'button_color'=>$button_color, 'button_hover'=>$button_hover, 'sidemenu_color'=>$sidemenu_color, 'sidemenu_hover'=>$sidemenu_hover, 'version'=>$version
		));
		$settings = DB::table('settings')->where('id','=',1)->first();
		$this->layout->content = View::make('settings.view')->with('settings',$settings); 
	}
	
}
?>