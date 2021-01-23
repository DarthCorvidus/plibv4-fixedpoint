<?php
/**
 * FixedPoint - a class that does fixed point additions. 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2020, Claus-Christoph Kuethe
 */
class FixedPoint {
	private $precision = 0;
	private $scaling = 1;
	private $int = 0;
	/**
	 * 
	 * @param int $precision
	 */
	function __construct(int $precision) {
		$this->precision = $precision;
		$this->scaling = pow(10, $precision);
	}

	/**
	 * Add number
	 * 
	 * Add a float or an integer. FixedPoint::add throws an exception if the
	 * precision of the number exceeds the precision of FixedPoint.
	 * @param float $float
	 * @throws UnexpectedValueException
	 */
	function add(float $float) {
		$scaled = $float*$this->scaling;
		if(is_float($float) && round($scaled)!==$scaled) {
			throw new UnexpectedValueException("Unexpected ".$float." for precision ".$this->precision);
		}
		$this->int += (int)($scaled);
	}
	
	/**
	 * Add arbitrary precision
	 * 
	 * With addRound, numbers get rounded to FixedPoint's precision; in the end
	 * it's a shorthand to FixedPoint::add(round(...)). You should think about
	 * your precision/scaling factor before using addRound, because you
	 * basically defeat the purpose of FixedPoint.
	 * 
	 * @param float $float
	 */
	function addRound(float $float) {
		$scaled = round($float, $this->precision)*$this->scaling;
		$this->int += (int)($scaled);
	}
	
	function getSum(): float {
		return $this->int/$this->scaling;
	}
	
}