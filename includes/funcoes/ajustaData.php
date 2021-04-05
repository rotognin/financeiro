<?php
   function ajustaData($data_invertida)
	{
		$data_array = explode('-',$data_invertida);
		$data_normal = $data_array[2] . '/' . $data_array[1] . '/' . $data_array[0];
		return $data_normal;
	}
?>