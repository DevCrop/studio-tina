<?php
/* 
실 오픈시 발급 
도메인 + 사이트유니크키
*/


class Lisence {
	static $keys = []; 

	static function add($newLisence = ''){
		if(isset($newLisence) && !empty($newLisence)) {
			self::$keys[] = $newLisence;
		}
	}
	
	static function getAll(){
		return self::$keys; 
	}
}

Lisence::add('a553edc259545ea93b2e59943bcfa52b8261d93ee4387a5b198c368da0a96c86');
Lisence::add('937e8d5fbb48bd4949536cd65b8d35c426b80d2f830c5c308e2cdec422ae2244');
Lisence::add('1383b55f18f20c72f598044a7410e8d0c41410b0be656f46041a490565b48a45');
Lisence::add('56c7b795e8a00d35ce2579e5da70b8394e684bbaa5923812f55d7910c98e839a');

