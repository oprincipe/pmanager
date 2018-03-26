<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 25/03/18
 * Time: 10:09
 */

namespace App;


trait UserRelations
{

    /**
     * List all users from object related to this
     *
     * @return array
     */
    public abstract function getUsersFromParentObjects();

    /**
     * A project belongs to:
     * - user (many)
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Return the list of Users related to ProjectUsers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany("App\User");
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
        return $this->user_id === $user_id;
    }


}