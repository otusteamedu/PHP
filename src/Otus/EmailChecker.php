<?php


namespace Otus;
/**
 * 
 */
class EmailChecker
{

	/**
	 * берем строку и чекаем ее на валидный адрес
	 */
	public function checkEmail(string $email): bool
	{
		// чекаем лайтовой регуляркой,
		// нам хватит чек на @ и точку
		if(!preg_match("/.+@.+\..+/i", $email)){
			return false;
		}

		// @ точно есть, поэтому берем строку после @ как домен
		// и чекаем MX
		$domain = substr($email, strpos($email, '@') + 1);
		if(!getmxrr($domain, $mxhosts)){
			return false;
		}

		return true;
	}

}