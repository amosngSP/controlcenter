<?php

namespace App\Policies;

use App\Models\OneTimeLink;
use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use anlutro\LaravelSettings\Facade as Setting;

class TrainingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the training.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Training  $training
     * @return bool
     */
    public function view(User $user, Training $training)
    {
        return  $training->mentors->contains($user) ||
                $user->isModeratorOrAbove($training->area) ||
                $user->is($training->user);
    }

    /**
     * Determine whether the user can update the training.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Training  $training
     * @return bool
     */
    public function update(User $user, Training $training)
    {
        return  $training->mentors->contains($user) ||
                $user->isModeratorOrAbove($training->area);
    }

    /**
     * Determine whether the user can delete the training.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Training  $training
     * @return bool
     */
    public function delete(User $user, Training $training)
    {
        return $user->isModeratorOrAbove($training->area);
    }

    /**
     * Determine whether the user can close the training.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Training  $training
     * @return bool
     */
    public function close(User $user, Training $training)
    {
        return $user->is($training->user) && $training->status == 0;
    }

    /**
     * Check whether the given user is allowed to apply for training
     *
     * @param User $user
     * @return Illuminate\Auth\Access\Response
     */
    public function apply(User $user)
    {
        $allowedSubDivisions = explode(',', Setting::get('trainingSubDivisions'));

        // Global setting if trainings are enabled
        if(!Setting::get('trainingEnabled'))
            return Response::deny("We are currently not accepting new training requests");

        // Only users within our subdivision should be allowed to apply
        if (!in_array($user->handover->subdivision, $allowedSubDivisions) && $allowedSubDivisions != null){
            $subdiv = "none";
            if(isset($user->handover->subdivision)) $subdiv = $user->handover->subdivision;
            return Response::deny("You must join Scandinavia subdivision to apply for training. You currently belong to ".$subdiv);
        }

        // Not active users are forced to ask for a manual creation of refresh
        if(!$user->hasActiveTrainings() && $user->rating > 2 && !$user->active){
            return Response::deny("Your ATC rating is inactive in Scandinavia");
        }

        return !$user->hasActiveTrainings() ? Response::allow() : Response::deny("You have an active training request");
    }

    /**
     * Check if the user has access to create a training manually
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isModeratorOrAbove();
    }

    /**
     * Determines whether the user can access the training reports associated with the training
     *
     * @param User $user
     * @param Training $training
     * @return bool
     */
    public function viewReports(User $user, Training $training)
    {
        return  $training->mentors->contains($user) ||
                $user->is($training->user) ||
                $user->isModeratorOrAbove($training->area) ||
                $user->isAdmin();
    }

    public function createReport(User $user, Training $training)
    {
        if (($link = $this->getOneTimeLink($training)) != null) {
            return $user->isModerator($link->training->area) || $user->isMentor($link->training->area);
        }

        // Check if mentor is mentoring area, not filling their own training and the training is in progress
        return $user->isModerator($training->area) || ($training->mentors->contains($user) && $user->isNot($training->user));
    }

    public function createExamination(User $user, Training $training)
    {
        if (($link = $this->getOneTimeLink($training)) != null) {
            return $user->isMentor($link->training->area);
        }

        // Check if mentor is mentoring area, not filling their own training and the training is awaing an exam.
        return $training->mentors->contains($user) && $user->isNot($training->user);
    }

    private function getOneTimeLink($training) {
        $link = null;

        $key = session()->get('onetimekey');

        if ($key != null) {
            $link = OneTimeLink::where([
                ['training_id', '=', $training->id],
                ['key', '=', $key]
            ])->get()->first();
        }

        return $link;
    }

    public function viewActiveRequests(User $user) {
        return $user->isModeratorOrAbove();
    }

    public function viewHistoricRequests(User $user) {
        return $user->isModeratorOrAbove();
    }

}