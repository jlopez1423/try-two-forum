<?php


namespace App\Filters;


use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    //All of the filters we can respond to
    protected $filters = ['by', 'popular'];

    /**
     * Filter a query by a given username
     *
     * @param string $username
     * @return mixed
     */
    protected function by( $username )
    {
        $user = User::where('name', $username)->firstorFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query by most popular threads
     *
     * @return $this
     */
    protected function popular()
    {
        //this removes pre-set latest() from original query in getPost in controller
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy( 'replies_count', 'desc' );


    }


}


?>