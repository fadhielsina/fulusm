<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('to_words'))
{
	function to_words($value)
	{
		
	}
}

if ( ! function_exists('to_rupiah'))
{
	function to_rupiah($value)
	{
		if($value < 0)
		{
			return '( Rp '.number_format(abs($value), 0, '', '.').' )';
		}
		else
		{
			return 'Rp '.number_format($value, 0, '', '.').'  ';
		}
	}
}
if ( ! function_exists('to_abs_nom') )
{
	function to_abs_nom( $int )
	{
	    return ($int < 0) ? sprintf( '(%s)', number_format( abs( $int ) ) ) : number_format( $int );
	}
}

?>
