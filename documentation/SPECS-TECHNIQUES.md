# Spécifications techniques — CARRERO IMMOBILIER

**Usage** : Document interne — décisions techniques d'implémentation

---

## 1. Système vidéo — Teaser + Vidéo complète

**Décision** : 2 vidéos Vimeo séparées par bien.

| | Teaser | Vidéo complète |
|---|---|---|
| Durée | 10-15 secondes | Complète |
| Confidentialité Vimeo | Public | Domain privacy (carrero.immo uniquement) |
| Visible par | Tout le monde | Utilisateurs connectés uniquement |
| Champ BDD | `vimeo_teaser_id` | `vimeo_video_id` |
| Embed dans le HTML | Oui (directement) | Non (servie par endpoint backend authentifié) |

**Pourquoi 2 vidéos et pas une seule coupée côté code** :
- Si on utilise 1 seule vidéo en limitant la lecture à 15s via le SDK Vimeo Player, l'URL embed de la vidéo complète est exposée dans le HTML source. Un utilisateur technique pourrait contourner la limite.
- Avec 2 vidéos séparées, l'URL de la vidéo complète n'existe pas dans le HTML tant que l'utilisateur n'est pas connecté. Le backend la sert uniquement via un endpoint protégé par middleware auth.
- La protection Vimeo domain privacy empêche la lecture de la vidéo complète en dehors du domaine autorisé (double sécurité).

**Sécurité vidéo — Vimeo Pro vs gratuit** :

| | Vimeo gratuit (unlisted) | Vimeo Pro (domain privacy) |
|---|---|---|
| Coût | Gratuit | ~180 €/an |
| Protection | Vidéo non indexée, lien accessible uniquement via le backend | Vidéo jouable uniquement sur le domaine autorisé (ex: carrero.immo) |
| Risque | Un utilisateur connecté pourrait copier l'URL depuis l'inspecteur du navigateur et la partager | Aucun — même avec l'URL, Vimeo refuse la lecture hors du domaine |

**Décision V1 : Vimeo gratuit (unlisted)**. Le backend ne sert l'URL qu'aux utilisateurs connectés, ce qui suffit comme protection. Le risque qu'un utilisateur aille extraire l'URL embed depuis l'inspecteur pour partager une vidéo de visite immobilière est quasi nul. Si Brice souhaite renforcer la sécurité plus tard, passer en Vimeo Pro est un changement de config côté Vimeo uniquement — zéro code à modifier.

**Workflow pour Brice** : pour chaque bien, uploader 2 vidéos sur Vimeo (le teaser court + la visite complète) et renseigner les 2 IDs dans le back-office.

---

## 2. OTP — Vérification d'identité à l'inscription

### À quoi sert l'OTP ?

L'OTP (One-Time Password) est un code à 6 chiffres envoyé à l'utilisateur pour vérifier qu'il est bien propriétaire de l'adresse email (ou du numéro de téléphone) renseignée. C'est une couche de sécurité qui garantit :
- **Des comptes réels** : évite les inscriptions avec des coordonnées inventées
- **La fiabilité des contacts** : quand Brice reçoit une notification de lead, il sait que l'email/téléphone est valide et joignable
- **La qualité des données** : les relances automatiques (48h post-vidéo, reporting) arrivent à de vraies personnes

### Décision : OTP par email (pas par SMS)

| | OTP Email | OTP SMS (Twilio) |
|---|---|---|
| Coût | Gratuit (Laravel Mail) | ~0.05 €/SMS + abonnement Twilio |
| Mise en place | 0.5 jour | 1.5 jours |
| Fiabilité | Très bonne | Variable (délais 10-30s, parfois bloqué par opérateur) |
| Dépendance externe | Aucune (SMTP déjà en place pour les emails transactionnels) | Twilio : compte à créer, identité à vérifier, numéro expéditeur à enregistrer |
| Réglementation | Aucune contrainte | Enregistrement numéro obligatoire (réglementation locale Île Maurice) |
| UX | L'utilisateur vérifie sa boîte mail | L'utilisateur reçoit un SMS instantanément |
| Clientèle internationale | Fonctionne partout | Coût SMS variable par pays, certains numéros internationaux mal supportés |

**Pourquoi l'email est le bon choix ici** :
1. **Coût zéro** : le SMTP est déjà configuré pour les emails transactionnels (bienvenue, confirmation RDV, relance, reporting). L'OTP email ne coûte rien de plus.
2. **Pas de dépendance tierce** : Twilio ajoute un service externe à maintenir, un compte à gérer, des crédits à recharger. Si le solde Twilio tombe à zéro, plus personne ne peut s'inscrire.
3. **Clientèle internationale** : l'agence accompagne des clients locaux et internationaux. L'envoi de SMS à l'étranger via Twilio coûte plus cher et n'est pas fiable dans tous les pays. L'email fonctionne partout.
4. **Simplicité** : Laravel intègre nativement tout ce qu'il faut (génération du code, hashage, envoi mail, vérification, expiration).

**L'OTP SMS reste une option** : si Brice souhaite ajouter la vérification par SMS plus tard (meilleure UX perçue, plus instantané), c'est prévu en option (+1.5j, +675 €). Le code est conçu pour supporter les deux canaux.

### Fonctionnement technique

1. L'utilisateur s'inscrit avec nom, email, téléphone, mot de passe
2. Un code à 6 chiffres est généré, hashé en BDD, et envoyé par email
3. L'utilisateur saisit le code sur la page de vérification
4. Le code expire après 10 minutes, max 3 tentatives
5. Une fois vérifié, le compte est activé et l'utilisateur peut accéder aux vidéos complètes

---

## 3. Calendly — Prise de rendez-vous

### À quoi ça sert ?

Calendly permet aux acheteurs intéressés de prendre rendez-vous directement depuis le site, sans échange d'emails. Il intervient à 2 endroits :
- **Page Vendre** : bouton "Prendre rendez-vous pour une estimation" → les vendeurs potentiels réservent un créneau avec Brice
- **Parcours post-vidéo (Option 1)** : "Je souhaite visiter" → l'acheteur prend RDV pour une visite du bien

### Intégration technique

Calendly s'intègre via un **embed inline** (widget intégré directement dans la page, pas de popup). Aucune API, aucun backend nécessaire.

```vue
<template>
  <div class="calendly-inline-widget"
       :data-url="`https://calendly.com/carrero-immo/visite?name=${user.name}&email=${user.email}`"
       style="min-width:320px;height:700px;">
  </div>
</template>

<script setup>
// Le script Calendly est chargé une seule fois dans le layout
</script>
```

### Prefill des données utilisateur

Quand un utilisateur connecté clique sur "Je souhaite visiter" après une vidéo, on pré-remplit le formulaire Calendly avec ses infos via les query params de l'URL :
- `name` : nom complet
- `email` : email
- `a1` : champ personnalisé (référence du bien, ex: CAR-2026-001)

L'utilisateur n'a plus qu'à choisir un créneau — pas besoin de re-saisir ses coordonnées.

### Détection de la réservation

Pour savoir qu'un RDV a été pris (et notifier Brice + mettre à jour le statut en BDD), on écoute l'événement Calendly via `postMessage` :

```js
window.addEventListener('message', (event) => {
  if (event.data.event === 'calendly.event_scheduled') {
    // Sauvegarder l'URI de l'événement en BDD
    // Notifier l'admin
  }
})
```

### Ce que Calendly gère tout seul (gratuit)
- Disponibilités de Brice (synchro avec son agenda Google/Outlook)
- Confirmation email automatique à l'acheteur
- Rappel email avant le RDV
- Annulation / reprogrammation par l'acheteur
- Page de réservation responsive

### Ce qu'on gère côté site
- L'embed du widget dans les pages Vue
- Le prefill des données utilisateur
- L'écoute du `postMessage` pour détecter la réservation
- La sauvegarde du `calendly_event_uri` dans `post_video_responses`

### Coût
Plan gratuit Calendly suffisant pour la V1 (1 type d'événement, 1 utilisateur).

---

## 4. Tracking & Reporting — Répartition GTM vs Backend

Le cahier des charges demande du tracking avancé et un reporting vendeur hebdomadaire. Tout ne relève pas du développement : une partie est gérée par GTM/GA4 (configuration externe, hors périmètre dev).

### Ce que GTM/GA4 gère (hors périmètre dev)

| Donnée | Comment |
|---|---|
| Nombre de vues par bien | GA4 page_view, filtré par URL de fiche bien |
| Nombre de vidéos vues | Event custom déclenché au play du player Vimeo (GTM écoute le postMessage Vimeo) |
| Durée de visionnage | Event custom sur les milestones Vimeo (25%, 50%, 75%, 100%) |
| Clics sur les boutons/CTA | Event custom sur les clics (data-attributes sur les boutons) |
| Taux de conversion | Calculé dans GA4 (funnel : page_view → vidéo vue → contact) |
| Temps passé sur les pages | Géré nativement par GA4 (engaged sessions) |

Brice consulte ces données directement dans Google Analytics. Pas besoin de les dupliquer en BDD.

### Ce que le backend gère (périmètre dev)

| Donnée | Pourquoi GTM ne peut pas | Table BDD |
|---|---|---|
| Nombre de contacts (demandes d'info/rappel) | Données structurées liées à un user + un bien | `post_video_responses` (action = request_info) |
| Nombre de visites demandées | RDV Calendly lié à un user + un bien | `post_video_responses` (action = schedule_visit) |
| Intérêts confirmés | Utilisateur authentifié + bien identifié | `post_video_responses` (schedule_visit + request_info) |
| Motifs de refus détaillés | Données structurées (Prix, Localisation, Surface...) | `post_video_responses` (decline_reasons JSON) |
| Favoris | Toggle user/bien | `favorites` |
| Biens récemment vus | Historique par utilisateur connecté | Enregistrement léger côté backend |
| Notifications admin | Email temps réel à Brice à chaque interaction | Events/Listeners Laravel |
| Relance 48h post-vidéo | Query BDD sur les video_accesses sans réponse | Commande artisan planifiée |

### Reporting vendeur hebdomadaire (email chaque lundi)

L'email envoyé au vendeur contient uniquement les données disponibles en BDD :

| Donnée dans l'email | Source | Disponible |
|---|---|---|
| Nombre de contacts | `post_video_responses` | Oui |
| Nombre de visites demandées | `post_video_responses` (schedule_visit) | Oui |
| Intérêts confirmés | `post_video_responses` (schedule_visit + request_info) | Oui |
| Motifs de refus | `post_video_responses` (decline_reasons) | Oui |
| Nombre de vues | GTM/GA4 | Non — consultable par Brice dans GA4 |
| Nombre de vidéos vues | GTM/GA4 | Non — idem |
| Recommandations stratégiques | Analyse humaine | Non — hors périmètre technique |

**Résultat** : le reporting est centré sur les données métier actionnables (qui a demandé quoi, pourquoi les refus). Les stats de fréquentation (vues, vidéos) restent dans GA4 où elles sont déjà plus riches et visuelles.

---

## 5. Hébergement & Backups BDD

### Hébergement

Le site est hébergé sur **o2switch** (hébergement mutualisé cPanel, datacenter France).

### Stratégie de backup base de données

Double sécurité : backup o2switch + backup off-site contrôlé.

#### 1. JetBackup (inclus o2switch)
- Sauvegardes automatiques quotidiennes gérées par o2switch
- Rétention ~30 jours
- Restauration en quelques clics depuis cPanel → JetBackup
- **Limite** : dépendance à o2switch, pas de contrôle sur la fréquence

#### 2. spatie/laravel-backup (backup off-site)

Package Laravel dédié pour sauvegarder la BDD + fichiers uploadés vers un stockage externe (S3, Google Drive).

```bash
composer require spatie/laravel-backup
```

Planification dans le scheduler Laravel :

```php
Schedule::command('backup:run --only-db')->daily()->at('03:00');
Schedule::command('backup:clean')->daily()->at('04:00');
```

Activation du scheduler via cron o2switch (cPanel → Tâches Cron) :

```
* * * * * cd /home/toncompte/carrero-immobilier && php artisan schedule:run >> /dev/null 2>&1
```

**Avantage** : les backups sont stockés hors o2switch (ex: bucket S3 ou Google Drive), ce qui protège contre une défaillance totale de l'hébergeur.

#### Résumé

| | JetBackup (o2switch) | spatie/laravel-backup |
|---|---|---|
| Fréquence | Quotidienne (auto) | Quotidienne (scheduler Laravel) |
| Rétention | ~30 jours | Configurable |
| Stockage | Serveur o2switch | Externe (S3, Google Drive) |
| Restauration | cPanel | Manuelle (import SQL) |
| Coût | Inclus | Gratuit (hors stockage S3) |
