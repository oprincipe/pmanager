<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 03/04/18
 * Time: 16:10
 */

namespace App;


/**
 * Class that use it must implements Monetizable interface
 *
 * Class must declare "use Akaunting\Money\Currency;"
 *
 * Trait MonetizableTrait
 * @package App
 */
trait MonetizableTrait
{

    /**
     * Money values are set using methods
     *
     * @param string $key
     * @param mixed $value
     * @return $this|void
     */
    public function setAttribute($key, $value)
    {
        if($this->isMoneyField($key)) {
            $moneyFields = $this->getMoneyFields();
            $callback = $moneyFields[$key];
            if(strpos($value, \Akaunting\Money\Currency::EUR()->getSymbol()) !== false) {
                $money = \money($value,\Akaunting\Money\Currency::EUR()->getCurrency(),true)->getValue();
                $this->$callback($money);
            }
            else {
                $this->$callback($value);
            }
        }
        else {
            parent::setAttribute($key, $value);
        }
    }


    /**
     * The formula is:
     * 100 : x = hours : Real hours
     *
     * if the task is closed the percentage is always 100%
     */
    public function getCompletitionPercentage()
    {
        if($this->getStatusId() == TaskStatus::STATUS_CLOSED) {
            return 100;
        }

        $worked_hours = $this->getHoursReal();
        $quoted_hours = $this->getHours();
        if($quoted_hours == 0 || $worked_hours == 0) {
            return 0;
        }

        $percentage = $worked_hours * 100 / $quoted_hours;
        if($percentage > 100) {
            return 100;
        }
        
        return number_format($percentage,2);
    }

}