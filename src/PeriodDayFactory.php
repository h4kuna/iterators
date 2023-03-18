<?php declare(strict_types=1);

namespace h4kuna\Iterators;

use DateInterval;
use DatePeriod;

final class PeriodDayFactory
{

	/**
	 * interval is (from, to> | exclude from, include to
	 */
	public static function createExFromInTo(
		\DateTimeImmutable|\DateTime $start,
		\DateTimeImmutable|\DateTime $end,
	): DatePeriod
	{
		return new DatePeriod((clone $start)->modify('midnight'), self::createDayInterval(), (clone $end)->modify('+1 day, midnight'), DatePeriod::EXCLUDE_START_DATE);
	}


	/**
	 * interval is <from, to> | exclude from, include to
	 */
	public static function createInFromInTo(
		\DateTimeImmutable|\DateTime $start,
		\DateTimeImmutable|\DateTime $end,
	): DatePeriod
	{
		return new DatePeriod((clone $start)->modify('midnight'), self::createDayInterval(), (clone $end)->modify('+1 day, midnight'));
	}


	/**
	 * interval is (from, to) | exclude from, include to
	 */
	public static function createExFromExTo(
		\DateTimeImmutable|\DateTime $start,
		\DateTimeImmutable|\DateTime $end,
	): DatePeriod
	{
		return new DatePeriod((clone $start)->modify('midnight'), self::createDayInterval(), (clone $end)->modify('midnight'), DatePeriod::EXCLUDE_START_DATE);
	}


	/**
	 * interval is <from, to) | exclude from, include to
	 */
	public static function createInFromExTo(
		\DateTimeImmutable|\DateTime $start,
		\DateTimeImmutable|\DateTime $end,
	): DatePeriod
	{
		return new DatePeriod((clone $start)->modify('midnight'), self::createDayInterval(), (clone $end)->modify('midnight'));
	}


	private static function createDayInterval(): DateInterval
	{
		return new DateInterval('P1D');
	}

}
