<?php

namespace App\Security\Voter;

use App\Entity\Caretaker;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class CaretakerVoter extends Voter
{
    public const VIEW   = 'CARETAKER_VIEW';
    public const EDIT   = 'CARETAKER_EDIT';
    public const DELETE = 'CARETAKER_DELETE';
    public const CREATE = 'CARETAKER_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($attribute === self::CREATE) {
            return true;
        }
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE,])
            && $subject instanceof \App\Entity\Caretaker;
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
            case self::CREATE:
                return $this->hasAnyShelter($user);

            case self::EDIT:
            case self::VIEW:
            case self::DELETE:
                return $this->isOwnerOfShelter($subject, $user);
        }

        return false;
    }

    private function isOwnerOfShelter(Caretaker $caretaker, User $user): bool
    {
        foreach ($caretaker->getShelter() as $shelter) {
            if ($shelter->getOwners()->contains($user)) {
                return true;
            }
        }
        return false;
    }

    private function hasAnyShelter(User $user): bool
    {
        return !$user->getShelters()->isEmpty();
    }
}
