<?php

namespace App\Security\Voter;

use App\Entity\Shelter;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ShelterVoter extends Voter
{
    public const EDIT = 'SHELTER_EDIT';
    public const VIEW = 'SHELTER_VIEW';
    public const DELETE = 'SHELTER_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Shelter;
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
            case self::DELETE:
                return $this->isOwner($subject, $user);
        }

        return false;
    }

    private function isOwner(Shelter $shelter, User $user): bool
    {
        return $shelter->getOwners()->contains($user);
    }
}
