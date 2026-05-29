<?php

namespace App\Security\Voter;

use App\Entity\Adoption;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AdoptionVoter extends Voter
{
    public const VIEW   = 'ADOPTION_VIEW';
    public const EDIT   = 'ADOPTION_EDIT';
    public const DELETE = 'ADOPTION_DELETE';
    public const CREATE = 'ADOPTION_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($attribute === self::CREATE) {
            return true;
        }

        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Adoption;
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
                break;
            case self::EDIT:
                return $this->isOwnerOfAnimalShelter($subject, $user);
                break;

            case self::VIEW:
                return $this->isOwnerOfAnimalShelter($subject, $user);
                break;

            case self::DELETE:
                return $this->isAdmin($user) && $this->isOwnerOfAnimalShelter($subject, $user);
                break;
        }

        return false;
    }

    private function isOwnerOfAnimalShelter(Adoption $adoption, User $user): bool
    {
        return $adoption->getAnimal()->getShelter()->getOwners()->contains($user);
    }

    private function hasAnyShelter(User $user): bool
    {
        return !$user->getShelters()->isEmpty();
    }

    private function isAdmin(User $user): bool
    {
        return in_array('ROLE_ADMIN', $user->getRoles());
    }
}
