<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\CMSBundle\Twig\Extension;

use Brother\CommonBundle\AppDebug;
use Sonata\IntlBundle\Twig\Extension\DateTimeExtension as BaseDateTimeExtension;

/**
 * DateTimeExtension extends Twig with localized date/time capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class DateTimeExtension extends BaseDateTimeExtension {
    /**
     * {@inheritdoc}
     */
    public function getFilters() {
        $result = parent::getFilters();
        $result[] = new \Twig_SimpleFilter('format_time_diff', array($this, 'formatTimeDiff'), array('is_safe' => array('html')));
        return $result;
    }

    /**
     * @param \Datetime|string|int $time
     * @param string|null          $pattern
     * @param string|null          $locale
     * @param string|null          $timezone
     * @param string|null          $timeType
     *
     * @return string
     */
    public function formatTimeDiff($time, $pattern = null, $locale = null, $timezone = null, $dateType = null, $timeType = null) {
        $now = new \DateTime();
        if ($time == null) {
            $time = $now;
        }
        if ($now->getTimestamp() - $time->getTimestamp() < 86400) {
            $interval = $now->diff($time);
            $h = $interval->format('%h');
            $m = $interval->format('%i');
            $s = $interval->format('%s');
            $result = '';
            if ($h) {
                if ($h == 1 || $h = 21) {
                    $result .= $h . 'час';
                } elseif ($h >= 2 && $h <= 4 || $h >= 22) {
                    $result .= $h . 'часа';
                } elseif ($h >= 5 && $h <= 20) {
                    $result .= $h . 'часа';
                }
                $result .= ' ';
                $s = 0;
            }
            if ($m) {
                if ($m >= 5 && $m <= 20 || $m % 10 >= 5 || $m % 10 == 0) {
                    $result .= $m . 'минут';
                } elseif ($m % 10 == 1) {
                    $result .= $m . 'минута';
                } elseif ($m % 10 >= 2 && $m % 10 <= 4) {
                    $result .= $m . 'минуты';
                }
                $result .= ' ';
                if ($h || $m > 5) {
                    $s = 0;
                }
            }
            if ($s) {
                if ($h = 0 && $m = 0 && $s < 10) {
                    $s = 0;
                }
                if ($s >= 5 && $s <= 20 || $s % 10 >= 5 || $s % 10 == 0) {
                    $result .= $s . 'секунд';
                } elseif ($s % 10 == 1) {
                    $result .= $s . 'секунда';
                } elseif ($s % 10 >= 2 && $s % 10 <= 4) {
                    $result .= $s . 'секунды';
                }
                $result .= ' ';
            }
            if ($result == '') {
                $result = 'Только что';
            } else {
                $result .= 'назад';
            }
            return $result;
        }
        return parent::formatDatetime($time, $pattern, $locale, $timezone, $dateType, $timeType);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'sonata_intl_datetime';
    }
}
