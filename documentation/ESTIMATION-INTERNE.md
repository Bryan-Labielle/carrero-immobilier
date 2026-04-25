# ESTIMATION INTERNE — Carrero Immobilier

**Usage** : Document de travail personnel — ne pas transmettre au client
**Date** : 14 avril 2026

---

## Paramètres

| | Valeur |
|---|---|
| TJM appliqué | 500 € / jour |
| Marge de sécurité | +15% sur le dev (imprévus, debug, itérations client) |
| Hébergement | o2switch (mutualisé) |

---

## Estimation détaillée par feature

### Design & Maquettes — 1.5 jours (forfait)

| Tâche | Statut | Commentaire |
|-------|:---:|---|
| Charte graphique | Fait | 2 propositions livrées (P1 + P2 lisibilité) |
| Maquette Accueil | Fait | Hero vidéo, concept, bénéfices, biens à la une |
| Maquette Acheter | Fait | Filtres, grille, pagination |
| Maquette Fiche bien | Fait | 5 états vidéo, post-vidéo, documents |
| Maquette Vendre | À faire | Landing page simple |
| Maquette Qui sommes-nous + Contact | À faire | Pages statiques |
| Maquette Mon espace | À faire | 6 sous-pages |
| Maquette Back-office admin | À faire | Dashboard + CRUD + leads + rapports |
| Maquette Auth | À faire | 3 pages simples |
| Responsive mobile | À faire | Adaptation de toutes les maquettes |

**Forfait réduit à 1.5 jours** (675 €). Les pages clés sont déjà maquettées, le reste est de la déclinaison.

---

### Socle technique — 2.5 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Setup Laravel 13 + Inertia v3 + Vue 3 + Tailwind + SSR | 0.5 j | Faible | Bien documenté |
| Base de données (11 migrations + modèles + relations) | 0.5 j | Faible | Schéma déjà conçu dans le plan |
| i18n FR/EN (middleware + vue-i18n + fichiers langue) | 1 j | Faible | Config + clés principales |
| Layouts + composants UI de base | 0.5 j | Faible | Conversion des maquettes HTML |

---

### Authentification & Sécurité — 1 jour (+1.5 j optionnel)

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| OTP par email | 0.5 j | Faible | Laravel Mail, gratuit, fiable |
| reCAPTCHA v3 + Axeptio RGPD | 0.5 j | Faible | Package Laravel + script JS |
| *(optionnel)* OTP SMS Twilio | 1.5 j | Moyen | Payant (~0.05 €/SMS), intégration API tierce, vérification sender ARCEP. À confirmer si nécessaire |

**Note** : L'OTP email est inclus par défaut. L'OTP SMS (Twilio) est en option — nécessite un compte vérifié, un numéro expéditeur enregistré, et un coût récurrent par SMS. À décider avec le client.

---

### Pages publiques — 3 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Accueil + Qui sommes-nous + Contact | 1 j | Faible | Pages statiques/semi-statiques, hero vidéo, formulaire contact |
| Acheter (filtres, recherche serveur, pagination) | 1 j | Moyen | PropertySearchService + scopes multiples |
| Vendre (landing + Calendly) | 1 j | Faible | Contenu statique + embed |

---

### Fiche bien & Système vidéo — 2.5 jours (COEUR DU PROJET)

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Fiche bien (galerie, description, caractéristiques, documents, favoris, partage social) | 1 j | Faible | |
| Teaser + lecteur vidéo sécurisé (Vimeo domain privacy) | 0.5 j | Faible | Teaser public + URL embed avec hash servie par le backend |
| Parcours post-vidéo (3 options + formulaires) | 1 j | Faible | 1 composant Vue + 1 endpoint + Calendly embed |

**Simplifié** : plus d'OTP ni de case d'engagement dans le flux vidéo. Le parcours est maintenant : pas connecté → créer un compte → vidéo → post-vidéo.

---

### Espace utilisateur — 1.5 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Dashboard + favoris + demandes en cours + rendez-vous | 0.5 j | Faible | Pages listes simples, queries basiques |
| Biens récemment vus | 0.5 j | Faible | Historique léger côté backend (enregistrement à chaque visite de fiche bien) |
| Profil | 0.5 j | Faible | Formulaire simple (changement tel = nouvel OTP) |

---

### Notifications & Automatisations — 1.5 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Notifications admin + emails transactionnels + relance 48h | 1 j | Faible | Mailables + Events/Listeners + commande artisan |
| Reporting vendeur hebdo | 0.5 j | Faible | COUNT sur post_video_responses + template email. Pas d'agrégation tracking (vues/vidéos via GTM) |

**Note** : Le tracking frontend (vues, clics, durée vidéo, heartbeat) sera géré via GTM/GA4 — hors périmètre dev. Le reporting se concentre sur les données métier en BDD.

---

### Back-office admin — 2.5 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| CRUD biens (formulaire bilingue + images + docs) | 1.5 j | Moyen | Upload, réordonnancement, onglets FR/EN, Vimeo IDs |
| Dashboard stats + utilisateurs + leads + rapports | 1 j | Faible | Pages listes/consultation simples, queries agrégées |

---

### SEO & Performance — 3 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| SSR Inertia | 0.5 j | Moyen | Config Node sur o2switch à vérifier |
| Meta tags + OG + Twitter Cards + JSON-LD + pages erreur | 0.5 j | Faible | Composant Head réutilisable + 3 pages statiques |
| Sitemap + robots.txt + canonical + hreflang | 0.5 j | Faible | spatie/laravel-sitemap |
| Optimisation performance | 0.5 j | Faible | Vite config, lazy loading, thumbnails |
| Tests fonctionnels | 1 j | Faible | Parcours complets à tester |

**Note** : Le responsive se fait au fil du développement (mobile-first). SSR Inertia sur o2switch à vérifier en amont (Node.js dispo ?).

---

### Hébergement & Mise en ligne — 2 jours

| Tâche | Temps | Risque | Note |
|-------|:---:|:---:|---|
| Config o2switch + déploiement production | 0.5 j | Faible | cPanel, PHP, MySQL, SSL, Git deploy |
| Domaine + DNS + SSL | 0.5 j | Faible | |
| Config SMTP (emails transactionnels) | 0.5 j | Faible | |
| Config CRON (reporting, relance, nettoyage) | 0.5 j | Faible | cPanel scheduler |

---

## Synthèse

| Poste | Jours estimés | Avec marge (+15%) | Montant HT (TJM × jours) |
|-------|:---:|:---:|:---:|
| Design & Maquettes | 1.5 | 1.5 (forfait) | 750 € |
| Socle technique | 2.5 | 3 | 1 500 € |
| Auth & Sécurité | 1 (+1.5 opt.) | 1 (+1.5 opt.) | 500 € (+750 € opt.) |
| Pages publiques | 3 | 3.5 | 1 750 € |
| Fiche bien & Vidéo | 2.5 | 3 | 1 500 € |
| Espace utilisateur | 1.5 | 2 | 1 000 € |
| Notifs & Automatisations | 1.5 | 2 | 1 000 € |
| Back-office admin | 2.5 | 3 | 1 500 € |
| SEO & Performance | 3 | 3.5 | 1 750 € |
| Hébergement & MEL | 2 | 2.5 | 1 250 € |
| **TOTAL** | **21.5 j** (+1.5 opt.) | **24.5 j** (+1.5 opt.) | **12 250 € HT** (+750 € opt.) |

---

## Zones de risque

| Risque | Impact | Mitigation |
|--------|--------|------------|
| SSR Inertia sur o2switch mutualisé | Node.js peut ne pas être dispo ou limité | Tester en amont. Fallback : pre-rendering ou VPS si nécessaire |
| Twilio délais/config SMS | OTP est un flux critique | Tester tôt en phase 3. Avoir un fallback email |
| API Vimeo privacy hash | Changements d'API possibles | Utiliser le SDK officiel, documenter le setup |
| CRUD biens bilingue complexe | Formulaire lourd avec uploads multiples | Bien découper les composants, utiliser Spatie Media Library |
| Volume de traductions FR/EN | Beaucoup de clés à maintenir | Structurer les fichiers par domaine dès le départ |

---

## Planning prévisionnel

| Semaine | Poste |
|:---:|---|
| S1-S2 | Design : maquettes restantes + validation |
| S2-S3 | Socle technique + Auth |
| S3-S4 | Pages publiques |
| S4-S6 | Fiche bien + Système vidéo (bloc critique) |
| S6-S7 | Espace utilisateur + Tracking |
| S7-S8 | Back-office admin |
| S8-S9 | SEO + Performance + Tests |
| S9-S10 | Hébergement + MEL + Recette |

---

## Coûts récurrents à répercuter au client

| Service | Coût | Note |
|---------|------|------|
| o2switch | ~72 €/an | Hébergement mutualisé, cPanel, SSL inclus |
| Domaine | ~10-15 €/an | .fr ou .com |
| Vimeo Pro | ~180 €/an | Minimum pour privacy domain-level |
| Twilio | ~0.05 €/SMS | Variable selon usage, estimer 50-100 SMS/mois = ~3-5 €/mois |
| Mailgun/Postmark | 0-35 €/mois | Gratuit jusqu'à ~1000 emails/mois |
| Axeptio | Gratuit | Plan free |
| Calendly | Gratuit | Plan free |
| reCAPTCHA | Gratuit | — |
| **Total récurrent estimé** | **~300-500 €/an** | Hors Twilio variable |
