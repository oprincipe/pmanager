<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 03/04/18
 * Time: 09:21
 */

namespace App;


/**
 * Interface Monetizable
 * Used to integrate method to everything must be monetizable.
 *
 * @package App
 */
interface Monetizable
{

    /**
     * This method return true or false if the
     * parameter is a money field or it be act like that
     *
     * @param $fieldName
     * @return bool
     */
    public function isMoneyField($fieldName);


    /**
     * Return an array of money fields as key and callback method as value
     *
     * ex:
     * return [
     *    'price' => 'setPrice'
     * ]
     *
     * @return mixed
     */
    public function getMoneyFields();


    /**
     * Get the price set for the object
     *
     * @return float
     */
    public function getPrice();


    /**
     * Set the price of the object
     * @param float $value
     *
     * @return bool
     */
    public function setPrice($value);

    //Methods used for quoted values

    /**
     * Get the ours (quoted if needed) for this object
     *
     * @return int
     */
    public function getHours();


    /**
     * Set the hours (quoted if needed) for this object
     *
     * @param int $value
     * @return bool
     */
    public function setHours($value);

    //Methods used for real values if it's related to quotes
    /**
     * Get the real worked hours for this object
     *
     * @return int
     */
    public function getHoursReal();

    /**
     * Set the real worked hours for this object
     *
     * @param int $value
     * @return bool
     */
    public function setHoursReal($value);

    /**
     * Get the real value for this object
     *
     * @return float
     */
    public function getValue();

}