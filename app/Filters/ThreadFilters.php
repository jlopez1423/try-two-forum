<?php


namespace App\Filters;


use App\User;
use Illuminate\Http\Request;

class ThreadFilters
{
    protected $builder;

    /**
     * ThreadFilters constructor.
     */
    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    public function apply( $builder )
    {
        $this->builder = $builder;
        if( ! $username = $this->request->by ) return $builder;

        //We apply our filters to the builder
        return $this->by( $username );

    }

    /**
     * @param $username
     * @return mixed
     */
    protected function by( $username )
    {
        $user = User::where('name', $username)->firstorFail();

        return $this->builder->where('user_id', $user->id);
    }


}


?>