<?php

class CNEntry extends Eloquent {
	protected $table = 'credit_notes'; 
	protected $primary_key = 'cn_id';
	public $timestamps = false;
}