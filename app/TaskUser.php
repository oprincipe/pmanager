<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskUser extends Model implements Monetizable
{
    use UserRelations;
    use MonetizableTrait;

	public $table = "task_user";

	protected $fillable = array(
		'task_id',
		'status_id',
		'user_id',
        'owner_id',
        'hours_real',
        'hours',
        'price',
        'value',
        'value_real'
	);

    public function getMoneyFields()
    {
        return [
            'status_id' => 'setStatusId',
            'hours_real' => 'setHoursReal',
            'hours' => 'setHours',
            'price' => 'setPrice',
        ];
    }

    public function isMoneyField($fieldName)
    {
        return array_key_exists($fieldName, $this->getMoneyFields());
    }


    public function user()
	{
		return $this->belongsTo("App\User");
	}

	public function task()
	{
		return $this->belongsTo("App\Task");
	}

    public function status()
    {
        return $this->belongsTo('App\TaskStatus');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        if(empty($this->owner_id)) {
            return $this->user;
        }
        else {
            return User::find($this->owner_id);
        }
    }



    public function save(array $options = [])
    {
        if(empty($this->getHours())) $this->setHours(0);
        if(empty($this->getHoursReal())) $this->setHoursReal(0);

        if(empty($this->owner_id)) {
            $this->owner_id = Auth::id();
        }
        $this->value      = $this->getQuotedValue();
        $this->value_real = $this->getRealValue();

        return parent::save($options);
    }




    public function getStatusId()
    {
        return (int) $this->status_id;
    }

    public function setStatusId($value)
    {
        $this->status_id = (int) $value;
        parent::setAttribute("status_id", $value);
    }


    /**
     * The price depends by the user who it's related to
     *
     * If the price is zero it will be set from the base_price taken
     * from the first project's customer
     */
    public function getPrice()
    {
        if ($this->price > 0) {
            return $this->price;
        }

        //get the customer
        $customers = $this->task->project->customers;
        if (!empty($customers)) {
            $base_price = 0;
            foreach ($customers as $customer) {
                if (!empty($customer->base_price)) {
                    $base_price = $customer->base_price;
                    break;
                }
            }

            return $base_price;
        }
    }


    /**
     * @param $value
     */
    public function setPrice($value)
    {
        $this->price = $value;
        parent::setAttribute("price", $value);
    }



    /**
     * The value is defined with the price and the hours
     */
    public function getQuotedValue()
    {
        $price = $this->getPrice();
        $hours = ($this->hours > 0) ? $this->hours : 0;
        $this->value = number_format($price * $hours, 2);
        return $this->value;
    }

    /**
     * The value is defined with the price and the hours_real
     */
    public function getRealValue()
    {
        $price = $this->getPrice();
        $hours = ($this->hours_real > 0) ? $this->hours_real : 0;
        $this->value_real = number_format($price * $hours, 2);
        return $this->value_real;
    }


    public function getHours()
    {
        return (int) $this->hours;
    }

    /**
     * @inheritDoc
     */
    public function setHours($value)
    {
        $this->hours = $value;
        parent::setAttribute("hours", $value);
    }

    /**
     * @inheritDoc
     */
    public function getHoursReal()
    {
        return (int) $this->hours_real;
    }

    /**
     * @inheritDoc
     */
    public function setHoursReal($value)
    {
        $this->hours_real = $value;
        parent::setAttribute("hours_real", $value);
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getRealValue();
    }



}
