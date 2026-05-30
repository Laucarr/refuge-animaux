<?php

namespace App\Security\Voter;

use App\Entity\Adopter;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AdopterVoter extends Voter
{
    public const VIEW   = 'ADOPTER_VIEW';
    public const EDIT   = 'ADOPTER_EDIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Adopter;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            $vote?->addReason('The user must be logged in to access this resource.');

            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
            case self::VIEW:
                return $this->isLinkedToUserShelter($subject, $user);
        }

        return false;
    }

    private function isLinkedToUserShelter(Adopter $adopter, User $user): bool
    {
        foreach ($adopter->getAdoptions() as $adoption) {
            $shelter = $adoption->getAnimal()->getShelter();
            if ($shelter->getOwners()->contains($user)) {
                return true;
            }
        }
        return false;
    }
}
