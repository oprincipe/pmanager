<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 25/03/18
 * Time: 10:09
 */

namespace App;


use Illuminate\Support\Facades\Auth;

trait UserRelations
{

    /**
     * A project belongs to:
     * - user (many)
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Return the list of Users related to Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany("App\User");
    }


    /**
     * Return the list of Users related to Object
     * referring to owner_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany("App\User")
            ->where("owner_id", Auth::id());
    }


    /**
     * @see user()
     */
    public function owner()
    {
        return $this->user();
    }

    /**
     * @param int $user_id
     *
     * @return bool
     */
    public function isOwner(int $user_id)
    {
        return (int) $this->user_id === (int) $user_id;
    }


}