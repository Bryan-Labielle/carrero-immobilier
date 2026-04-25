# CARRERO IMMOBILIER - Roadmap V1

## Stack technique
- **Backend** : Laravel 13 + Inertia v3
- **Frontend** : Vue 3 (Composition API) + Tailwind CSS
- **Base de données** : MySQL
- **Agenda** : Calendly (embed gratuit)
- **Vidéo** : Vimeo (hébergement) + @vimeo/player (SDK)
- **SMS OTP** : Twilio
- **i18n** : FR / EN

---

## Features V1

### F1 - Pages publiques
- Page Accueil (hero vidéo, concept, bénéfices vendeurs/acheteurs, biens à la une, CTA)
- Page Acheter (moteur de recherche avec filtres, affichage cartes paginé)
- Page Vendre (landing page vendeurs, process en étapes, embed Calendly)
- Page Qui sommes-nous (histoire fondateur, positionnement, agence)
- Page Contact (formulaire, adresse, téléphone, email, Google Maps)

### F2 - Fiches biens
- Galerie photos avec lightbox
- Description + caractéristiques + prix
- Teaser vidéo public (10-15s)
- Vidéo complète verrouillée (accès conditionné)
- Documents téléchargeables (plans, diagnostics)
- Boutons de partage réseaux sociaux

### F3 - Système d'authentification
- Inscription avec nom, email, téléphone
- Connexion / déconnexion
- Vérification téléphone par SMS OTP (Twilio)
- Gestion du profil (modification nom, email, téléphone, mot de passe)

### F4 - Accès vidéo conditionné (page clé)
- Envoi OTP SMS pour débloquer la vidéo d'un bien
- Vérification du code OTP (6 chiffres, expire 10min, max 3 tentatives)
- Case d'engagement obligatoire avant accès vidéo
- URL vidéo Vimeo signée servie uniquement par le backend (jamais dans le HTML)

### F5 - Parcours post-vidéo (3 options)
- Option 1 : "Je souhaite visiter" → agenda Calendly (prefill nom/email)
- Option 2 : "J'ai besoin d'infos" → bouton rappel OU formulaire question
- Option 3 : "Je ne donne pas suite" → choix motif + champ libre optionnel

### F6 - Espace utilisateur (Mon espace)
- Tableau de bord avec résumé
- Mes favoris (ajout/suppression depuis les fiches biens)
- Mes demandes en cours
- Mes rendez-vous (date, heure, adresse, possibilité d'annuler)
- Biens consultés récemment

### F7 - Notifications email
- Notification admin en temps réel à chaque interaction utilisateur
- Email de bienvenue à l'inscription
- Confirmation de rendez-vous
- Relance automatique si pas de réponse 48h après visionnage vidéo

### F8 - Tracking avancé
- Vues par bien (page_view)
- Vidéos vues + durée de visionnage
- Clics sur les CTA (intérêt / refus / info)
- Favoris, téléchargements, partages
- Heartbeat temps passé (toutes les 30s)

### F9 - Reporting vendeur automatique
- Email hebdomadaire (chaque lundi) par bien
- Contenu : nombre de vues, vidéos vues, contacts, visites demandées, motifs de refus

### F10 - Back-office admin
- Dashboard avec statistiques globales
- CRUD propriétés (bilingue FR/EN, images, documents, vidéos Vimeo)
- Liste utilisateurs avec historique d'activité
- Gestion des leads (statut : nouveau / contacté / qualifié / converti / perdu)
- Consultation des rapports par bien et par période

### F11 - Multilingue FR/EN
- Switch FR/EN visible dans la navbar
- Traduction complète de toutes les pages
- Contenu des biens traduit (table de traductions séparée)

### F12 - Design & responsive
- Design premium épuré : blanc dominant + vert militaire (#4A5A4F)
- Mobile first
- Temps de chargement rapide (lazy loading, code splitting, thumbnails optimisés)
- Pages d'erreur personnalisées (404, 403, 500)

---

## Taches dans l'ordre

### Phase 1 : Initialisation projet + Base de données

- [ ] 1.1 - Créer le projet Laravel 13 avec starter kit Inertia + Vue 3
- [ ] 1.2 - Installer Tailwind CSS et configurer le thème (couleur primaire #4A5A4F)
- [ ] 1.3 - Configurer le .env (MySQL, mail, Twilio, Vimeo)
- [ ] 1.4 - Créer la migration `users` (modifier la migration par défaut : ajouter first_name, last_name, phone, phone_verified, preferred_locale, is_admin)
- [ ] 1.5 - Créer la migration `properties` (reference, type, status, price, surface, bedrooms, bathrooms, location, coordonnées GPS, vimeo IDs, is_featured, vendor info, timestamps, soft deletes)
- [ ] 1.6 - Créer la migration `property_translations` (property_id, locale, title, description, short_description, features JSON, unique property_id+locale)
- [ ] 1.7 - Créer la migration `property_images` (property_id, path, alt_text, sort_order, is_cover)
- [ ] 1.8 - Créer la migration `property_documents` (property_id, file_path, original_name, label_fr, label_en, file_size)
- [ ] 1.9 - Créer la migration `favorites` (user_id, property_id, unique constraint)
- [ ] 1.10 - Créer la migration `otp_codes` (user_id, property_id, code hashé, phone, purpose, attempts, verified_at, expires_at)
- [ ] 1.11 - Créer la migration `video_accesses` (user_id, property_id, otp_verified_at, engagement_accepted_at, video timestamps, watch_duration, post_action_completed, reminder_sent_at)
- [ ] 1.12 - Créer la migration `post_video_responses` (video_access_id, user_id, property_id, action enum, calendly_event_uri, message, decline_reason)
- [ ] 1.13 - Créer la migration `leads` (user_id, property_id, source, status, name, email, phone, message, metadata JSON)
- [ ] 1.14 - Créer la migration `tracking_events` (user_id, property_id, session_id, event_type, page, duration_seconds, metadata JSON, ip_address, user_agent)
- [ ] 1.15 - Exécuter les migrations
- [ ] 1.16 - Créer les Enums PHP (PropertyType, PropertyStatus, PostVideoAction)
- [ ] 1.17 - Créer tous les modèles Eloquent avec relations, casts et scopes
- [ ] 1.18 - Créer les seeders de démo (admin, 3 biens avec traductions FR/EN, images)

### Phase 2 : Layouts + i18n

- [ ] 2.1 - Créer les fichiers de langue `lang/fr/` et `lang/en/` (messages, navigation, properties, auth, validation)
- [ ] 2.2 - Créer le middleware `SetLocale` (lecture session, fallback Accept-Language, défaut FR)
- [ ] 2.3 - Configurer `HandleInertiaRequests` pour partager locale + traductions + auth
- [ ] 2.4 - Installer et configurer `vue-i18n` côté frontend
- [ ] 2.5 - Créer `AppLayout.vue` (layout principal public)
- [ ] 2.6 - Créer `Navbar.vue` (menu : Acheter, Vendre, Qui sommes-nous, Contact, Mon espace)
- [ ] 2.7 - Créer `LanguageSwitcher.vue` (toggle FR/EN)
- [ ] 2.8 - Créer `Footer.vue` (liens, réseaux sociaux, mentions légales)
- [ ] 2.9 - Créer `LocaleController` (switch de langue via session)
- [ ] 2.10 - Créer `AuthLayout.vue` et `DashboardLayout.vue`
- [ ] 2.11 - Créer `AdminLayout.vue`

### Phase 3 : Authentification

- [ ] 3.1 - Créer `RegisterController` + page `Register.vue` (nom, email, téléphone, mot de passe)
- [ ] 3.2 - Créer `LoginController` + page `Login.vue`
- [ ] 3.3 - Créer `OtpService` (génération code 6 chiffres, hashage, envoi Twilio, vérification, rate limiting)
- [ ] 3.4 - Créer `OtpVerificationController` + page `VerifyOtp.vue`
- [ ] 3.5 - Créer le middleware `AdminOnly`

### Phase 4 : Pages publiques

- [ ] 4.1 - Créer `PageController@home` + `Home.vue`
- [ ] 4.2 - Créer `HeroVideo.vue` (vidéo fond muette en boucle + texte + 2 boutons)
- [ ] 4.3 - Créer `ConceptSection.vue` (6 points de différenciation)
- [ ] 4.4 - Créer `BenefitsColumns.vue` (2 colonnes miroir vendeurs/acheteurs)
- [ ] 4.5 - Créer `FeaturedProperties.vue` + `PropertyCard.vue` (photo, prix, localisation, bouton)
- [ ] 4.6 - Créer `PropertySearchService` (application des filtres via scopes Eloquent)
- [ ] 4.7 - Créer `PropertyController@index` + `Buy/Index.vue`
- [ ] 4.8 - Créer `PropertyFilters.vue` (type, localisation, budget min/max, surface, chambres, mots-clés, accessible étrangers)
- [ ] 4.9 - Créer `PropertyGrid.vue` + `Pagination.vue`
- [ ] 4.10 - Créer `PageController@sell` + `Sell.vue` (contenu statique + process en étapes)
- [ ] 4.11 - Créer `CalendlyEmbed.vue` (widget inline Calendly)
- [ ] 4.12 - Créer `PageController@about` + `About.vue`
- [ ] 4.13 - Créer `PageController@contact` + `Contact.vue` + `ContactForm.vue`
- [ ] 4.14 - Créer `ContactController@store` (sauvegarde lead + notification admin)

### Phase 5 : Fiche bien (page clé)

- [ ] 5.1 - Créer `PropertyController@show` + `Buy/Show.vue`
- [ ] 5.2 - Créer `PropertyGallery.vue` (carrousel/grille + lightbox)
- [ ] 5.3 - Créer `VideoTeaser.vue` (embed Vimeo 10-15s avec overlay verrouillé + CTA)
- [ ] 5.4 - Créer `VideoAccessController` (endpoints : demander OTP, vérifier OTP, accepter engagement, obtenir URL vidéo)
- [ ] 5.5 - Créer `VimeoService` (génération URL embed signée avec hash de confidentialité)
- [ ] 5.6 - Créer `VideoGate.vue` (flux 3 étapes : envoi OTP → code → engagement)
- [ ] 5.7 - Créer composable `useVideoAccess.js` (machine d'état du flux vidéo)
- [ ] 5.8 - Créer `PropertyVideoPlayer.vue` (Vimeo Player SDK, écoute play/progress/ended)
- [ ] 5.9 - Créer `PostVideoActionController@store`
- [ ] 5.10 - Créer `PostVideoActions.vue` (3 options après vidéo)
- [ ] 5.11 - Créer `CallbackRequestForm.vue` (message + mode de contact préféré)
- [ ] 5.12 - Créer `DeclineReasonForm.vue` (choix motif + champ libre)
- [ ] 5.13 - Créer `PropertyDocuments.vue` + `PropertyDocumentController@download`
- [ ] 5.14 - Créer `PropertyShareButtons.vue` (Facebook, WhatsApp, Twitter, LinkedIn, email)
- [ ] 5.15 - Créer `FavoriteButton.vue` + `FavoriteController@toggle` + composable `useFavorites.js`

### Phase 6 : Espace utilisateur

- [ ] 6.1 - Créer `DashboardController@index` + `Dashboard/Index.vue` (résumé)
- [ ] 6.2 - Créer `Dashboard/Favorites.vue` (liste des favoris)
- [ ] 6.3 - Créer `Dashboard/Requests.vue` (demandes d'info et de rappel)
- [ ] 6.4 - Créer `Dashboard/Appointments.vue` (RDV programmés)
- [ ] 6.5 - Créer `Dashboard/RecentlyViewed.vue` (historique biens consultés)
- [ ] 6.6 - Créer `Dashboard/Profile.vue` (modification profil, changement tel = nouvel OTP)

### Phase 7 : Tracking + Notifications + Automatisations

- [ ] 7.1 - Créer composable `useTracking.js` (page_view auto, heartbeat 30s, sendBeacon)
- [ ] 7.2 - Créer `TrackingController@store` et `@heartbeat` (API, batch, rate limiting)
- [ ] 7.3 - Créer les Events Laravel (PropertyViewed, VideoWatched, VisitRequested, InfoRequested, PropertyDeclined)
- [ ] 7.4 - Créer les Listeners + Mailable `AdminNotification` (email admin à chaque interaction)
- [ ] 7.5 - Créer `WelcomeUser` Mailable (email bienvenue inscription)
- [ ] 7.6 - Créer `ReportService` (agrégation données tracking par bien et période)
- [ ] 7.7 - Créer commande `SendWeeklyVendorReports` + Mailable `WeeklyVendorReport`
- [ ] 7.8 - Planifier la commande reporting (chaque lundi 9h) dans `routes/console.php`
- [ ] 7.9 - Créer commande `SendVideoReminderNotifications` + Mailable `VideoReminderMail`
- [ ] 7.10 - Planifier la commande relance (quotidien) dans `routes/console.php`
- [ ] 7.11 - Créer commande `CleanExpiredOtpCodes` (nettoyage OTP expirés)

### Phase 8 : Back-office admin

- [ ] 8.1 - Créer `AdminDashboardController` + `Admin/Dashboard.vue` (stats : total biens, utilisateurs, leads, activité récente)
- [ ] 8.2 - Créer `AdminPropertyController` (CRUD complet)
- [ ] 8.3 - Créer `Admin/Properties/Index.vue` (liste avec filtres)
- [ ] 8.4 - Créer `Admin/Properties/Create.vue` et `Edit.vue` (formulaire bilingue FR/EN, upload images avec réordonnancement, upload documents, champs Vimeo IDs)
- [ ] 8.5 - Créer `AdminUserController` + `Admin/Users/Index.vue` (liste + détail avec historique activité)
- [ ] 8.6 - Créer `AdminLeadController` + `Admin/Leads/Index.vue` (liste avec filtres statut, mise à jour statut)
- [ ] 8.7 - Créer `AdminReportController` + `Admin/Reports/Index.vue` (données tracking agrégées par bien et période)

### Phase 9 : Polish + SEO + Performance

- [ ] 9.1 - Tests responsive mobile first sur toutes les pages
- [ ] 9.2 - Optimisation images (thumbnails automatiques, lazy loading)
- [ ] 9.3 - Code splitting Vite (chargement par route)
- [ ] 9.4 - Meta tags SEO par page (Inertia Head) + Open Graph pour le partage
- [ ] 9.5 - Pages d'erreur personnalisées (404, 403, 500)
- [ ] 9.6 - Tests fonctionnels (auth, OTP, video gating, recherche, admin CRUD)
- [ ] 9.7 - Test intégration complète du parcours utilisateur (inscription → vidéo → post-vidéo)
