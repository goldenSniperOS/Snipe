<?php
/**
 * Libreria Extraida del usuario Xeoncross en uno de sus gists
 * https://gist.github.com/Xeoncross/2362936
 *
 *
 * Ejemplo de Uso
 *
 * $requests = new Requests();
 * $requests->process(['http://example.com/site'],function($data,$info){
 * 		echo $data;
 * });
 *
 * Esta clase presenta algunos errores de respuesta
 * Make asynchronous requests to different resources as fast as possible and process the results as they are ready.
 */
class Requests
{
	//Verificar Por que la razon de que Sea Publico - Razon de Error
	private $handle;

	public function __construct()
	{
		$this->handle = curl_multi_init();
	}
	public function process($urls, $callback)
	{
		foreach($urls as $url)
		{
			$ch = curl_init($url);
			curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => TRUE));
			curl_multi_add_handle($this->handle, $ch);
		}
		do {
			$mrc = curl_multi_exec($this->handle, $active);
			if ($state = curl_multi_info_read($this->handle))
			{
				//print_r($state);
				$info = curl_getinfo($state['handle']);
				//print_r($info);
				$callback(curl_multi_getcontent($state['handle']), $info);
				curl_multi_remove_handle($this->handle, $state['handle']);
			}
			usleep(10000); // stop wasting CPU cycles and rest for a couple ms
		} while ($mrc == CURLM_CALL_MULTI_PERFORM || $active);
	}
	public function __destruct()
	{
		curl_multi_close($this->handle);
	}
}
