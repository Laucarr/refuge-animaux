# Refuge des Animaux

Plateforme de gestion et d'adoption d'animaux pour les refuges. Le site permet aux refuges de gérer leurs pensionnaires et leurs adoptions, et aux visiteurs de découvrir les animaux disponibles et de contacter les refuges.

---

## Ce que les visiteurs peuvent faire

Toute personne qui arrive sur le site **sans se connecter** peut :

- **Voir la page d'accueil** : liste de tous les animaux actuellement disponibles à l'adoption (nom, espèce, âge, refuge d'appartenance, description).
- **Découvrir les refuges** : liste des refuges partenaires avec leur adresse, téléphone et email.
- **Contacter un refuge** via un formulaire de contact : le message est envoyé directement par email au refuge concerné. On peut contacter un refuge à propos d'un animal précis (bouton "Contacter le refuge" sur chaque carte d'animal) ou à propos d'informations générales.

---

## Les rôles des utilisateurs connectés

### Utilisateur sans refuge (ROLE_USER)

Un utilisateur peut créer un compte sur le site. Après connexion, s'il n'est rattaché à aucun refuge, il est redirigé vers une page d'attente. Il peut consulter la liste des refuges et des espèces, mais ne peut gérer aucun animal ni adoption tant qu'un administrateur ne lui a pas attribué un refuge.

---

### Gestionnaire de refuge (ROLE_USER + rattaché à un refuge)

Un utilisateur rattaché à un ou plusieurs refuges devient gestionnaire de ce(s) refuge(s). Il peut uniquement agir sur les données de **ses propres refuges**.

**Animaux**
- Voir la liste des animaux de son refuge
- Ajouter un nouvel animal (nom, âge, espèce, description, statut, soigneurs assignés)
- Modifier les informations d'un animal
- Supprimer un animal
- Rechercher et filtrer les animaux

**Adoptions**
- Voir la liste des adoptions enregistrées pour ses animaux
- Créer une adoption : sélectionner un animal disponible et renseigner un adoptant (existant ou nouveau)
- Modifier une adoption existante
- Rechercher et filtrer les adoptions

**Soigneurs**
- Voir la liste des soigneurs rattachés à son refuge
- Ajouter un soigneur (nom, email, téléphone, jours et horaires de travail)
- Modifier ou supprimer un soigneur

**Adoptants**
- Voir la fiche d'un adoptant lié à une adoption de son refuge
- Modifier les informations d'un adoptant

---

### Administrateur (ROLE_ADMIN)

L'administrateur a accès à tout ce que fait un gestionnaire, plus des actions réservées à la gestion globale de la plateforme.

**Refuges**
- Créer un nouveau refuge (nom, adresse, téléphone, email, capacité)
- Modifier un refuge dont il est propriétaire
- Supprimer un refuge dont il est propriétaire
- **Gérer les propriétaires d'un refuge** : attribuer ou retirer des comptes utilisateurs comme gestionnaires d'un refuge

**Espèces**
- Créer une nouvelle espèce (ex. : chien, chat, lapin…)
- Modifier ou supprimer une espèce

**Adoptions**
- Supprimer définitivement une adoption (action réservée à l'admin)

---

## Résumé des accès

| Action | Visiteur | Gestionnaire | Admin |
|---|:---:|:---:|:---:|
| Voir les animaux disponibles | ✅ | ✅ | ✅ |
| Voir les refuges | ✅ | ✅ | ✅ |
| Contacter un refuge | ✅ | ✅ | ✅ |
| Gérer les animaux de son refuge | ❌ | ✅ | ✅ |
| Gérer les adoptions de son refuge | ❌ | ✅ | ✅ |
| Supprimer une adoption | ❌ | ❌ | ✅ |
| Gérer les soigneurs de son refuge | ❌ | ✅ | ✅ |
| Voir / modifier les adoptants | ❌ | ✅ | ✅ |
| Créer / supprimer un refuge | ❌ | ❌ | ✅ |
| Attribuer des gestionnaires à un refuge | ❌ | ❌ | ✅ |
| Gérer les espèces | ❌ | ❌ | ✅ |

