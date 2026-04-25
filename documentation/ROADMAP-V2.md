# ROADMAP V2 — CARRERO IMMOBILIER

**Dernière mise à jour** : 20 avril 2026
**Durée totale estimée** : 26.5 jours
**Organisation** : 7 sprints

---

## Sprint 1 — Fondations (4 jours)

> Setup projet, base de données, bilingue, layouts

### US-1.1 · Setup projet
**En tant que** développeur, **je veux** un projet Laravel 13 + Inertia v3 + Vue 3 + Tailwind configuré **afin de** démarrer le développement.

- [ ] Créer le projet Laravel 13 avec starter kit Inertia + Vue 3
- [ ] Installer Tailwind CSS, configurer le thème (#4A5A4F, cream, neutrals)
- [ ] Configurer le `.env` (MySQL, mail, Vimeo)
- [ ] Configurer Vite (code splitting par route)

**Estimation** : 0.5 j

### US-1.2 · Base de données
**En tant que** développeur, **je veux** la base de données en place avec les modèles **afin de** pouvoir développer les features.

- [ ] Migration `users` (first_name, last_name, email, phone, phone_verified, preferred_locale, is_admin)
- [ ] Migration `properties` (reference, slug, type, status, price, surface, bedrooms, bathrooms, location, GPS, vimeo IDs, is_featured, vendor info, soft deletes)
- [ ] Migration `property_translations` (property_id, locale, title, description, short_description, features JSON, neighborhood_description)
- [ ] Migration `property_images` (property_id, path, alt_text, sort_order, is_cover)
- [ ] Migration `property_documents` (property_id, file_path, original_name, label_fr, label_en, file_size)
- [ ] Migration `favorites` (user_id, property_id, unique)
- [ ] Migration `otp_codes` (user_id, code hashé, phone, attempts, verified_at, expires_at)
- [ ] Migration `video_accesses` (user_id, property_id, engagement_accepted_at, video timestamps, watch_duration, post_action_completed, reminder_sent_at)
- [ ] Migration `post_video_responses` (video_access_id, user_id, property_id, action enum, calendly_event_uri, message, preferred_contact, decline_reasons JSON, decline_comment)
- [ ] Migration `leads` (user_id, property_id, source, status, name, email, phone, message, metadata JSON)
- [ ] Créer les Enums (PropertyType, PropertyStatus, PostVideoAction, LeadSource, LeadStatus)
- [ ] Créer tous les modèles Eloquent avec relations, casts et scopes
- [ ] Seeders de démo (1 admin, 3 biens avec traductions FR/EN)

**Estimation** : 1 j

### US-1.3 · Système bilingue FR/EN
**En tant qu'**utilisateur, **je veux** pouvoir basculer entre français et anglais **afin de** naviguer dans ma langue préférée.

- [ ] Créer les fichiers de langue `lang/fr/` et `lang/en/` (nav, properties, auth, validation, emails, dashboard, admin)
- [ ] Middleware `SetLocale` (lecture session, fallback Accept-Language, défaut FR)
- [ ] Configurer `HandleInertiaRequests` (partage locale + traductions + auth)
- [ ] Installer et configurer `vue-i18n` côté frontend
- [ ] `LocaleController` (switch de langue via session)

**Critère d'acceptation** : le switch FR/EN change toute l'interface instantanément sans rechargement de page.

**Estimation** : 2 j

### US-1.4 · Layouts & Composants UI
**En tant qu'**utilisateur, **je veux** une navigation cohérente sur tout le site **afin de** m'orienter facilement.

- [ ] `AppLayout.vue` (layout principal public)
- [ ] `Navbar.vue` (Acheter, Vendre, Qui sommes-nous, Contact, Mon espace + transparent sur hero → cream au scroll)
- [ ] `LanguageSwitcher.vue` (toggle FR/EN, JetBrains Mono)
- [ ] `Footer.vue` (4 colonnes : marque, navigation, contact Île Maurice, légal)
- [ ] `AuthLayout.vue`, `DashboardLayout.vue`, `AdminLayout.vue`

**Estimation** : 0.5 j

---

## Sprint 2 — Authentification & Pages publiques (5.5 jours)

> Auth OTP email, pages Accueil, Acheter, Vendre, Qui sommes-nous, Contact

### US-2.1 · Inscription & Connexion avec OTP email
**En tant qu'**acheteur, **je veux** créer un compte et vérifier mon email **afin d'**accéder aux vidéos complètes des biens.

- [ ] `RegisterController` + `Register.vue` (nom, email, téléphone, mot de passe)
- [ ] `LoginController` + `Login.vue`
- [ ] `OtpService` (génération code 6 chiffres, hashage, envoi par email via Laravel Mail, vérification, rate limiting)
- [ ] `OtpVerificationController` + `VerifyOtp.vue` (saisie code, expiration 10min, max 3 tentatives)
- [ ] Middleware `AdminOnly`

**Critère d'acceptation** : inscription → réception email avec code → saisie code → compte activé → accès vidéos.

**Estimation** : 0.5 j

### US-2.2 · Anti-spam & Cookies
**En tant que** propriétaire du site, **je veux** protéger les formulaires du spam et respecter la réglementation cookies **afin de** garantir la qualité des données.

- [ ] Intégration reCAPTCHA v3 sur les formulaires (inscription, contact)
- [ ] Intégration bandeau cookies (Axeptio ou équivalent)

**Estimation** : 0.5 j

### US-2.3 · Page Accueil
**En tant que** visiteur, **je veux** comprendre le concept Carrero dès la page d'accueil **afin de** décider si je veux acheter ou vendre avec cette agence.

- [ ] `PageController@home` + `Home.vue`
- [ ] Hero vidéo d'ambiance (muette, en boucle) + titre + sous-titre + 2 CTA (Acheter / Vendre)
- [ ] Section concept : 6 points de différenciation (timeline numérotée)
- [ ] Section vendeurs/acheteurs : bénéfices en colonnes miroir ou onglets
- [ ] Section biens à la une : 3 `PropertyCard.vue` (photo, prix, localisation, badge type, favori, vidéo)
- [ ] CTA final : "Faire estimer mon bien"

**Estimation** : 1 j

### US-2.4 · Page Acheter (recherche & filtres)
**En tant qu'**acheteur, **je veux** rechercher des biens avec des filtres précis **afin de** trouver rapidement ce qui correspond à mon projet.

- [ ] `PropertySearchService` (application des filtres via scopes Eloquent)
- [ ] `PropertyController@index` + `Buy/Index.vue`
- [ ] `PropertyFilters.vue` (type, localisation select dynamique, budget min/max, surface, chambres, mots-clés, accessible étrangers)
- [ ] `PropertyGrid.vue` + `Pagination.vue` (pagination serveur via Inertia)
- [ ] Tri (plus récents, prix croissant/décroissant, surface)
- [ ] Compteur de résultats

**Critère d'acceptation** : les filtres s'appliquent côté serveur, l'URL se met à jour, la pagination fonctionne.

**Estimation** : 1.5 j

### US-2.5 · Page Vendre
**En tant que** vendeur potentiel, **je veux** comprendre l'approche Carrero et prendre rendez-vous **afin de** faire estimer mon bien.

- [ ] `PageController@sell` + `Sell.vue`
- [ ] Contenu statique : titre, constats du marché, approche Carrero, process en 6 étapes, bénéfices, crédibilité
- [ ] `CalendlyEmbed.vue` (widget inline, prefill si connecté)
- [ ] CTA : "Prendre rendez-vous pour une estimation"

**Estimation** : 1 j

### US-2.6 · Pages Qui sommes-nous & Contact
**En tant que** visiteur, **je veux** en savoir plus sur l'agence et la contacter **afin de** lui faire confiance.

- [ ] `PageController@about` + `About.vue` (hero, histoire fondateur, positionnement, ouverture internationale, agence, CTA)
- [ ] `PageController@contact` + `Contact.vue` + `ContactForm.vue`
- [ ] `ContactController@store` (sauvegarde lead source=contact_form + notification admin par email)
- [ ] Google Maps embed

**Estimation** : 1 j

---

## Sprint 3 — Fiche bien & Système vidéo (3.5 jours)

> Page coeur du site : galerie, vidéo sécurisée, parcours post-vidéo

### US-3.1 · Fiche bien
**En tant qu'**acheteur, **je veux** voir toutes les informations d'un bien **afin de** décider si je suis intéressé avant de visionner la vidéo.

- [ ] `PropertyController@show` + `Buy/Show.vue`
- [ ] `PropertyGallery.vue` (grille masonry + lightbox)
- [ ] Description bilingue, caractéristiques, prix, localisation
- [ ] `PropertyDocuments.vue` + `PropertyDocumentController@download` (stockage privé, auth check)
- [ ] `FavoriteButton.vue` + `FavoriteController@toggle`
- [ ] `PropertyShareButtons.vue` (Facebook, WhatsApp, Twitter, LinkedIn, email)
- [ ] Données structurées JSON-LD (schema.org/RealEstateListing)

**Estimation** : 1 j

### US-3.2 · Système vidéo sécurisé
**En tant qu'**acheteur connecté, **je veux** visionner la visite immersive complète **afin de** découvrir le bien avant de me déplacer.

- [ ] `VideoTeaser.vue` (embed Vimeo public, 10-15s, overlay verrouillé si pas connecté)
- [ ] `VideoAccessController` (endpoint : obtenir URL vidéo si connecté)
- [ ] `PropertyVideoPlayer.vue` (@vimeo/player SDK, écoute play/progress/ended)
- [ ] Composable `useVideoAccess.js` (machine d'état : pas connecté → connecté → vidéo)
- [ ] Enregistrement dans `video_accesses` à chaque visionnage

**Flux simplifié** : pas connecté → "Créer un compte" → vidéo complète. Pas d'OTP dans le flux vidéo, pas de case d'engagement.

**Critère d'acceptation** : un visiteur non connecté ne voit que le teaser. L'URL de la vidéo complète n'apparaît jamais dans le HTML source.

**Estimation** : 0.5 j

### US-3.3 · Parcours post-vidéo (3 options)
**En tant qu'**acheteur ayant vu la vidéo, **je veux** exprimer mon intérêt ou mes réserves **afin que** l'agence puisse me recontacter ou informer le vendeur.

- [ ] `PostVideoActions.vue` (3 options affichées après fin de vidéo)
- [ ] `PostVideoActionController@store`

**Option 1 — "Je souhaite visiter"** :
- [ ] Embed Calendly inline avec prefill (name, email, ref bien)
- [ ] Écoute `postMessage` Calendly pour détecter `calendly.event_scheduled`
- [ ] Sauvegarde `calendly_event_uri` dans `post_video_responses`

**Option 2 — "J'ai besoin d'infos"** :
- [ ] 2 sous-choix : "Être recontacté" (bouton simple) OU "Poser une question" (textarea + choix mode contact : tel/email/whatsapp)
- [ ] Sauvegarde dans `post_video_responses` (action=request_info)

**Option 3 — "Je ne donne pas suite"** :
- [ ] Multi-select motifs : Prix, Localisation, Surface, Agencement, Environnement, État général
- [ ] Champ libre optionnel
- [ ] Sauvegarde dans `post_video_responses` (action=decline, decline_reasons JSON)

**Pour chaque option** :
- [ ] Notification admin par email (Event/Listener)
- [ ] Marquer `post_action_completed = true`
- [ ] L'utilisateur ne peut répondre qu'une seule fois par bien

**Critère d'acceptation** : chaque réponse est visible dans le back-office avec le détail complet. L'admin reçoit un email en temps réel.

**Estimation** : 2 j

---

## Sprint 4 — Espace utilisateur (2 jours)

> Dashboard, favoris, demandes, RDV, historique, profil

### US-4.1 · Dashboard & Listes
**En tant qu'**acheteur connecté, **je veux** retrouver mes favoris, mes demandes et mes rendez-vous **afin de** suivre mes démarches.

- [ ] `DashboardController@index` + `Dashboard/Index.vue` (résumé : compteurs favoris, demandes, RDV)
- [ ] `Dashboard/Favorites.vue` (liste des `PropertyCard` favoris)
- [ ] `Dashboard/Requests.vue` (demandes d'info et de rappel depuis `post_video_responses`)
- [ ] `Dashboard/Appointments.vue` (RDV : données sauvegardées au moment de la réservation Calendly, lien d'annulation)

**Estimation** : 1 j

### US-4.2 · Historique biens consultés
**En tant qu'**acheteur, **je veux** retrouver les biens que j'ai consultés récemment **afin de** ne pas les perdre.

- [ ] Enregistrement léger côté backend à chaque visite de fiche bien (user connecté)
- [ ] `Dashboard/RecentlyViewed.vue` (liste des derniers biens visités)

**Estimation** : 0.5 j

### US-4.3 · Gestion du profil
**En tant qu'**utilisateur, **je veux** modifier mes informations personnelles **afin de** garder mon compte à jour.

- [ ] `Dashboard/Profile.vue` (modification nom, email, téléphone, mot de passe)
- [ ] Changement d'email = nouvel OTP de vérification

**Estimation** : 0.5 j

---

## Sprint 5 — Notifications & Back-office (4 jours)

> Emails, relance auto, CRUD biens, admin

### US-5.1 · Notifications & Emails
**En tant que** propriétaire de l'agence, **je veux** être notifié en temps réel à chaque interaction **afin de** réagir rapidement.

- [ ] Events Laravel : VisitRequested, InfoRequested, PropertyDeclined, ContactFormSubmitted
- [ ] Listeners → Mailable `AdminNotification` (email à l'admin pour chaque event)
- [ ] Mailable `WelcomeUser` (email de bienvenue à l'inscription)
- [ ] Mailable `AppointmentConfirmation` (confirmation RDV)

**Estimation** : 0.5 j

### US-5.2 · Relance automatique 48h
**En tant que** propriétaire de l'agence, **je veux** que les acheteurs qui n'ont pas donné suite après 48h soient relancés automatiquement **afin de** maximiser les retours.

- [ ] Commande `SendVideoReminderNotifications` (query video_accesses sans post_action_completed depuis 48h, pas déjà relancé)
- [ ] Mailable `VideoReminderMail`
- [ ] Planifier dans `routes/console.php` (quotidien)
- [ ] Commande `CleanExpiredOtpCodes` (nettoyage OTP expirés)

**Critère d'acceptation** : pas de double relance, pas de relance si déjà répondu, pas de relance si bien retiré.

**Estimation** : 1 j

### US-5.3 · Back-office — CRUD biens
**En tant qu'**administrateur, **je veux** gérer les biens depuis le back-office **afin de** publier et mettre à jour le catalogue.

- [ ] `AdminPropertyController` (CRUD complet)
- [ ] `Admin/Properties/Index.vue` (liste avec filtres statut/type, recherche)
- [ ] `Admin/Properties/Create.vue` et `Edit.vue` :
  - Onglets FR/EN pour les champs traduits
  - Upload multi-images avec drag&drop + réordonnancement (sortablejs) + image de couverture
  - Upload multi-documents avec labels bilingues
  - Champs Vimeo IDs (teaser + complète)
  - Gestion statut (draft → published → sold → archived)
  - Infos vendeur (nom, email pour reporting)
- [ ] Redimensionnement images à l'upload (thumbnails pour cartes, taille moyenne pour galerie)
- [ ] Suppression d'image = nettoyage stockage physique

**Critère d'acceptation** : création d'un bien avec traductions FR/EN, 5 photos réordonnées, 2 documents, 2 IDs Vimeo → le bien apparaît sur le site en FR et EN.

**Estimation** : 2 j

### US-5.4 · Back-office — Admin
**En tant qu'**administrateur, **je veux** un tableau de bord avec les stats et la gestion des leads **afin de** piloter l'activité.

- [ ] `AdminDashboardController` + `Admin/Dashboard.vue` (stats : total biens publiés, utilisateurs, leads, interactions récentes)
- [ ] `AdminUserController` + `Admin/Users/Index.vue` (liste + détail)
- [ ] `AdminLeadController` + `Admin/Leads/Index.vue` (liste avec filtres source/statut, mise à jour statut : new → contacted → qualified → converted → lost)
- [ ] `AdminReportController` + `Admin/Reports/Index.vue` (données agrégées par bien : contacts, visites demandées, motifs de refus)

**Estimation** : 0.5 j

---

## Sprint 6 — SEO & Performance (3.5 jours)

> SSR, meta tags, sitemap, optimisation, tests

### US-6.1 · Rendu serveur (SSR)
**En tant que** propriétaire du site, **je veux** que les pages soient indexées par Google **afin d'**attirer des acheteurs et vendeurs via le référencement naturel.

- [ ] Configurer Inertia SSR (`@inertiajs/server` + Node.js)
- [ ] Tester le rendu serveur sur toutes les pages
- [ ] Vérifier la compatibilité avec o2switch (Node.js disponible ?)

**Estimation** : 1 j

### US-6.2 · SEO technique
**En tant que** propriétaire du site, **je veux** que chaque page ait ses meta tags optimisés **afin d'**apparaître correctement dans Google et les partages sociaux.

- [ ] Composant `SeoHead.vue` réutilisable (Inertia Head : title, description, canonical)
- [ ] Open Graph (og:title, og:description, og:image) → partage Facebook, LinkedIn, WhatsApp
- [ ] Twitter Cards (twitter:card, twitter:image)
- [ ] JSON-LD schema.org/RealEstateListing sur chaque fiche bien
- [ ] Sitemap XML dynamique (spatie/laravel-sitemap) avec biens + pages statiques
- [ ] robots.txt
- [ ] Balises hreflang FR/EN sur chaque page
- [ ] URLs propres et sémantiques (`/acheter/villa-contemporaine-grand-baie-CAR-2026-001`)
- [ ] Pages d'erreur personnalisées (404, 403, 500)

**Estimation** : 1 j

### US-6.3 · Optimisation performance
**En tant que** visiteur, **je veux** un site rapide **afin de** ne pas quitter la page avant qu'elle charge.

- [ ] Lazy loading des images
- [ ] Code splitting Vite par route
- [ ] Thumbnails automatiques pour les cartes (image optimisée)
- [ ] Vérifier le score Lighthouse

**Estimation** : 0.5 j

### US-6.4 · Tests fonctionnels
**En tant que** développeur, **je veux** valider les parcours critiques **afin de** garantir que tout fonctionne avant la mise en ligne.

- [ ] Test inscription → OTP email → vérification → compte activé
- [ ] Test recherche biens → filtres → pagination
- [ ] Test fiche bien → teaser → connexion → vidéo complète → post-vidéo (3 options)
- [ ] Test notification admin reçue à chaque interaction
- [ ] Test relance 48h (idempotence, pas de doublon)
- [ ] Test CRUD biens admin (création bilingue, images, documents)
- [ ] Test responsive mobile sur les pages critiques

**Estimation** : 1 j

---

## Sprint 7 — Hébergement & Mise en ligne (2.5 jours)

> Configuration serveur, déploiement, recette

### US-7.1 · Configuration serveur
**En tant que** développeur, **je veux** le serveur de production configuré **afin de** déployer le site.

- [ ] Configuration o2switch (PHP 8.3, MySQL, cPanel)
- [ ] Node.js pour le SSR (vérifier dispo sur o2switch)
- [ ] Configuration domaine + DNS + certificat SSL
- [ ] Configuration SMTP (Mailgun ou Postmark) pour les emails transactionnels
- [ ] Configuration CRON cPanel (relance 48h quotidienne, nettoyage OTP)

**Estimation** : 2 j

### US-7.2 · Déploiement & Recette
**En tant que** propriétaire du site, **je veux** le site en production **afin de** commencer à publier des biens.

- [ ] Déploiement production (Git deploy ou SSH)
- [ ] Migration BDD production
- [ ] Création compte admin
- [ ] Vérification de toutes les pages en production
- [ ] Test envoi d'emails en production
- [ ] Test parcours complet en production (inscription → vidéo → post-vidéo)

**Estimation** : 0.5 j

---

## Récapitulatif

| Sprint | Contenu | Durée |
|:---:|---------|:---:|
| 1 | Fondations (setup, BDD, bilingue, layouts) | 4 j |
| 2 | Auth + Pages publiques | 5.5 j |
| 3 | Fiche bien + Vidéo + Post-vidéo | 3.5 j |
| 4 | Espace utilisateur | 2 j |
| 5 | Notifications + Back-office | 4 j |
| 6 | SEO + Performance + Tests | 3.5 j |
| 7 | Hébergement + Mise en ligne | 2.5 j |
| **TOTAL** | | **25 j** |

---

## Décisions techniques rappelées

- **OTP par email** (pas SMS). Option SMS Twilio en V2
- **Pas de case d'engagement** dans le flux vidéo. Flux simplifié : pas connecté → créer compte → vidéo → post-vidéo
- **2 vidéos Vimeo par bien** (teaser public + complète protégée)
- **Vimeo gratuit (unlisted)** en V1. Option Vimeo Pro (domain privacy) si besoin
- **Tracking vues/vidéos via GTM/GA4** — hors périmètre dev
- **Reporting vendeur** basé sur les données métier BDD uniquement (contacts, visites, motifs de refus)
- **Locale par session** (pas de préfixe URL /fr/ /en/)
- **Filtrage et pagination côté serveur** (Inertia router.get)
- **Soft deletes** sur properties uniquement
