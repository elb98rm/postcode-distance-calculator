<?php
/**
 * LocalisationInterface.php
 *
 * Interface to enforce expected behaviour for a localised version of PostcodeDistanceCalculator
 *
 * php 7+
 *
 * @category  None
 * @package   Floor9design\PostcodeDistanceCalculator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright floor9design.com
 * @license   GPL 3.0 (http://www.gnu.org/copyleft/gpl.html)
 * @version   0.1
 * @link      http://floor9design.com/
 * @see       http://floor9design.com/
 * @since     File available since Release 1.0
 */
namespace Floor9design\PostcodeDistanceCalculator;
/**
 * Class LocalisationInterface
 *
 * Interface to ensure that the appropriate methods can be called.
 *
 * @category  None
 * @package   Floor9design\PostcodeDistanceCalculator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright floor9design.com
 * @license   GPL 3.0 (http://www.gnu.org/copyleft/gpl.html)
 * @version   0.1
 * @link      http://floor9design.com/
 * @see       http://floor9design.com/
 * @since     File available since Release 1.0
 */
interface LocalisationInterface
{
    /**
     * Validates a postcode. Returns the postcode if valid, an empty string if not.
     *
     * Example cases might be (the Jorvik Centre in York, and Beverly Hills):
     *
     * $postcode_uk = PostcodeDistanceCalculatorUk->validatePostcode('YO1 9WT');
     * $postcode_us = PostcodeDistanceCalculatorUs->validatePostcode('90210');
     *
     * @param string $postcode Postcode for validation
     *
     * @return string $return A valid postcode, or empty string.
     */
    public function validatePostcode(string $postcode) : string;
}