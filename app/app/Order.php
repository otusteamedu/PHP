<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name', 'quantity', 'total', 'processed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
//        'product_name', 'quantity', 'total', 'processed', 'updated_at', 'created_at'
    ];

    public function setProcessed()
    {
        $this->processed = true;
    }

}
