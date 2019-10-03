<?php

namespace Berinc;

class Model {

	private $values = [];

	public function setData($data)
	{

		foreach ($data as $key => $value)
		{

			$this->{"set".$key}($value);

		}

	}

	public function __call($name, $args)
	{

		$method = substr($name, 0, 3);
		$fieldName = substr($name, 3, strlen($name));

		/*if (in_array($fieldName, $this->fields))
		{*/

			switch ($method)
			{

				case "get":
					return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
				break;

				case "set":
					$this->values[$fieldName] = $args[0];
				break;

			}

		/*}*/

	}

	public function getValues()
	{

		return $this->values;

	}

	public function getImgBase64($file, $pid ){
		
		$extension = explode('.', $file['name']);
		$extension = end($extension);
	
		switch ($extension) {
	
			case "jpg":
			case "jpeg":
			$image = imagecreatefromjpeg($file["tmp_name"]);
			break;
	
			case "gif":
			$image = imagecreatefromgif($file["tmp_name"]);
			break;
	
			case "png":
			$image = imagecreatefrompng($file["tmp_name"]);
			break;
	
		}
	    
		$dist = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $pid . ".jpg";
	
		imagejpeg($image, $dist);
	
		imagedestroy($image);
		
		$code = base64_encode(file_get_contents($dist));
		
		return 'data:image/jpeg;base64,' . $code;
	}
	

}

 ?>
