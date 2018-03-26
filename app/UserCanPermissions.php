<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 25/03/18
 * Time: 11:09
 */

namespace App;


trait UserCanPermissions
{
    /**
     * Permission to view this task
     *
     * @param User $user
     *
     * @return bool
     */
    public function userCanView(User $user)
    {
        //Return true if is the owner
        if($this->user_id == $user->id) return true;

        /**
         * Return true if the user is inside the users
         * list
         */
        $worker = $this->users()->where("user_id", $user->id)->first();
        if($worker) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function userCanEdit(User $user)
    {
        return $this->userCanView($user);
    }

    /**
     * Only the owner can delete
     *
     * @inheritDoc
     */
    public function userCanDelete(User $user)
    {
        //Return true if is the owner
        if($this->user_id == $user->id) return true;
    }

}