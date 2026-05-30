<?php

namespace App\Security\Voter;

use App\Entity\Animal;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AnimalVoter extends Voter
{
    public const EDIT = 'ANIMAL_EDIT';
    public const VIEW = 'ANIMAL_VIEW';
    public const DELETE = 'ANIMAL_DELETE';
    public const CREATE = 'ANIMAL_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($attribute === self::CREATE) {
            return true;
        }

        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Animal;
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
                return $this->isOwner($subject, $user);
        }

        return false;
    }

    private function isOwner(Animal $animal, User $user): bool
    {
        return $animal->getShelter()->getOwners()->contains($user);
    }

    private function hasAnyShelter(User $user): bool
    {
        return !$user->getShelters()->isEmpty();
    }
}
