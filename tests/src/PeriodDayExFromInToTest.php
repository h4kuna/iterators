<?php declare(strict_types=1);

namespace h4kuna\Iterators\Tests;

use h4kuna\Iterators\PeriodDayExFromInTo;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class PeriodDayExFromInToTest extends TestCase
{

	public function testRange(): void
	{
		$endDate = new \DateTime('1996-04-09 08:00:00');
		$period = new PeriodDayExFromInTo(new \DateTime('1989-02-01 07:00:00'), $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof \DateTime);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-02', $first->format('Y-m-d'));
		Assert::same('1996-04-09', $last->format('Y-m-d'));
		Assert::same(2624, $count);
		Assert::same(2623, $last->diff($first)->days);
	}


	public function testRangeDateTimeImmutable(): void
	{
		$endDate = new \DateTimeImmutable('1996-04-09 08:00:00');
		$period = new PeriodDayExFromInTo(new \DateTimeImmutable('1989-02-01 07:00:00'), $endDate);

		$last = $first = null;
		$count = 0;
		foreach ($period as $date) {
			assert($date instanceof \DateTime);
			if ($first === null) {
				$first = $date;
			}
			$last = $date;
			++$count;
		}
		assert($last !== null && $first !== null);

		Assert::same('1996-04-09', $endDate->format('Y-m-d')); // clone working
		Assert::same('1989-02-02', $first->format('Y-m-d'));
		Assert::same('1996-04-09', $last->format('Y-m-d'));
		Assert::same(2624, $count);
		Assert::same(2623, $last->diff($first)->days);
	}

}

(new PeriodDayExFromInToTest())->run();
