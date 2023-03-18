<?php declare(strict_types=1);

namespace h4kuna\Iterators\Tests;

use h4kuna\Iterators\PeriodDayFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class PeriodDayFactoryTest extends TestCase
{

	/**
	 * @param class-string $class
	 * @dataProvider dataClass
	 */
	public function testExFromInTo(string $class): void
	{
		$startDate = new $class('1989-02-01 07:00:00');
		$endDate = new $class('1996-04-09 08:00:00');
		assert($startDate instanceof \DateTimeInterface && $endDate instanceof \DateTimeInterface);
		$period = PeriodDayFactory::createExFromInTo($startDate, $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof $class);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1989-02-01', $startDate->format('Y-m-d'));
		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-02', $first->format('Y-m-d'));
		Assert::same('1996-04-09', $last->format('Y-m-d'));
		Assert::same(2624, $count);
		Assert::same(2623, $last->diff($first)->days);
	}


	/**
	 * @dataProvider dataClass
	 */
	public function testExFromExTo(string $class): void
	{
		$startDate = new $class('1989-02-01 07:00:00');
		$endDate = new $class('1996-04-09 08:00:00');
		assert($startDate instanceof \DateTimeInterface && $endDate instanceof \DateTimeInterface);
		$period = PeriodDayFactory::createExFromExTo($startDate, $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof $class);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1989-02-01', $startDate->format('Y-m-d'));
		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-02', $first->format('Y-m-d'));
		Assert::same('1996-04-08', $last->format('Y-m-d'));
		Assert::same(2623, $count);
		Assert::same(2622, $last->diff($first)->days);
	}


	/**
	 * @dataProvider dataClass
	 */
	public function testInFromExTo(string $class): void
	{
		$startDate = new $class('1989-02-01 07:00:00');
		$endDate = new $class('1996-04-09 08:00:00');
		assert($startDate instanceof \DateTimeInterface && $endDate instanceof \DateTimeInterface);
		$period = PeriodDayFactory::createInFromExTo($startDate, $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof $class);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1989-02-01', $startDate->format('Y-m-d'));
		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-01', $first->format('Y-m-d'));
		Assert::same('1996-04-08', $last->format('Y-m-d'));
		Assert::same(2624, $count);
		Assert::same(2623, $last->diff($first)->days);
	}


	/**
	 * @dataProvider dataClass
	 */
	public function testInFromInTo(string $class): void
	{
		$startDate = new $class('1989-02-01 07:00:00');
		$endDate = new $class('1996-04-09 08:00:00');
		assert($startDate instanceof \DateTimeInterface && $endDate instanceof \DateTimeInterface);
		$period = PeriodDayFactory::createInFromInTo($startDate, $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof $class);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1989-02-01', $startDate->format('Y-m-d'));
		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-01', $first->format('Y-m-d'));
		Assert::same('1996-04-09', $last->format('Y-m-d'));
		Assert::same(2625, $count);
		Assert::same(2624, $last->diff($first)->days);
	}


	/**
	 * @return array<array<string, class-string>>
	 */
	public static function dataClass(): array
	{
		return [
			['class' => \DateTime::class,],
			['class' => \DateTimeImmutable::class,],
		];
	}

}

(new PeriodDayFactoryTest())->run();
