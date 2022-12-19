<?php declare(strict_types=1);

namespace h4kuna\Iterators;

/**
 * interval is (from, to> | exclude from, include to
 */
final class PeriodDayExFromInTo extends \DatePeriod
{

	/**
	 * @param \DateTime|\DateTimeImmutable $start
	 * @param \DateTime|\DateTimeImmutable $end
	 */
	public function __construct(\DateTimeInterface $start, \DateTimeInterface $end)
	{
		parent::__construct((clone $start)->modify('midnight'), new \DateInterval('P1D'), (clone $end)->modify('+1 day, midnight'), self::EXCLUDE_START_DATE);
	}

}
