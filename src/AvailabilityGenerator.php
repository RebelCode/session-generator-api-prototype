<?php

namespace RebelCode\Sessions\Api;

use RebelCode\Sessions\SessionGeneratorInterface;

/**
 * A session generator that uses day-of-the-week (DOTW) rules to generate per-day sessions using another session
 * generator instance.
 *
 * @since [*next-version*]
 */
class AvailabilityGenerator implements SessionGeneratorInterface
{
    protected $generator;

    protected $rules;

    public function __construct(SessionGeneratorInterface $generator, $rules)
    {
        $this->generator = $generator;
        $this->rules     = $rules;
    }

    public function generate($start, $end)
    {
        $sessions       = [];
        // Format into a string to use strtotime() to obtain the midnight timestamp for the both start and end
        $startFormatted = date('d-F-Y', $start);
        $endFormatted   = date('d-F-Y', $end);
        $startDate      = strtotime(sprintf('%s 00:00:00', $startFormatted));
        $endDate        = strtotime(sprintf('%s 00:00:00', $endFormatted));

        // Iterate until end date is reached
        $currDate = $startDate;
        while ($currDate < $endDate) {
            // Get day of the week name, to map to rules
            $_dotw         = strtolower(date('l', $currDate));
            $_dotwSessions = [];

            // Process each rule
            foreach ($this->rules as $_rule) {
                $_ruleFrom = $_rule['from'];
                $_ruleTill = $_rule['till'];

                if ($_ruleFrom['dotw'] !== $_dotw) {
                    continue;
                }

                $_ruleStart = strtotime($_ruleFrom['time'], $currDate);
                $s = sprintf('next %s %s', $_ruleTill['dotw'], $_ruleTill['time']);
                $_ruleEnd   = strtotime($s, $currDate);

                $_ruleSessions = $this->generator->generate($_ruleStart, $_ruleEnd);
                $_dotwSessions = array_merge($_dotwSessions, $_ruleSessions);
            }

            $sessions = array_merge($sessions, $_dotwSessions);
            $currDate = strtotime('+1 day', $currDate);
        }

        return $sessions;
    }
}
