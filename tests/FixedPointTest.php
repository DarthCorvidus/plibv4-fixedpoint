<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
/**
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2020, Claus-Christoph Kuethe
 */
class FixedPointTest extends TestCase {
	function testAdd() {
		$sum = new FixedPoint(2);
		$sum->add(10.25);
		$sum->add(0.7);
		$sum->add(0.1);
		$this->assertEquals(11.05, $sum->getSum());
	}
	/**
	 * Adding 0.0001 10.000 times as float results in 0.99999999999991 instead
	 * of 1; used fixed point arithmetic, you'll get 1.
	 */
	function testFloatBeWrong() {
		$sum = new FixedPoint(4);
		for($i=0;$i<10000;$i++) {
			$sum->add(0.0001);
		}
		$this->assertEquals(1, $sum->getSum());
	}
	
	function testPrecisionTooLarge() {
		$sum = new FixedPoint(2);
		$this->expectException(UnexpectedValueException::class);
		$sum->add(10.123);
	}
	
	function testAddRound() {
		$sum = new FixedPoint(2);
		$sum->addRound(2.519);
		$sum->addRound(3.101);
		$this->assertEquals(5.62, $sum->getSum());
	}
}
