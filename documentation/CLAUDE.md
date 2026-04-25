# CARRERO IMMOBILIER — Contexte projet

## Résumé
Site immobilier premium pour l'agence CARRERO IMMOBILIER (fondateur : Brice Portocarrero). Approche différenciante basée sur la qualification des acheteurs via vidéo immersive, engagement contractuel, et reporting data-driven.

## Stack technique
- **Backend** : Laravel 13 + Inertia v3 (SSR activé pour le SEO)
- **Frontend** : Vue 3 (Composition API) + Tailwind CSS
- **SSR** : Inertia SSR via @inertiajs/server (Node.js) — indispensable pour le référencement
- **Base de données** : MySQL
- **Agenda** : Calendly (embed gratuit)
- **Vidéo** : Vimeo (hébergement + privacy) + @vimeo/player (SDK frontend)
- **SMS OTP** : Twilio
- **Emails** : Laravel Mail (Mailgun ou Postmark)
- **i18n** : FR/EN (vue-i18n + fichiers lang Laravel)
- **Cookies / RGPD** : Axeptio (bandeau consentement cookies)
- **Anti-spam** : Google reCAPTCHA v3 (formulaires contact, inscription, OTP)
- **Sitemap** : spatie/laravel-sitemap (génération dynamique)

## SEO & Partage social
Le SEO est un enjeu majeur pour ce site (acquisition vendeurs et acheteurs). Points clés :
- SSR obligatoire via Inertia SSR pour que les pages soient indexables par Google
- Meta tags dynamiques par page (title, description) via Inertia Head
- Données structurées JSON-LD pour les biens (schema.org/RealEstateListing) → rich snippets Google
- Open Graph (og:title, og:description, og:image) → partage Facebook, LinkedIn, WhatsApp
- Twitter Cards (twitter:card, twitter:image) → partage Twitter/X
- Sitemap XML dynamique (spatie/laravel-sitemap) avec toutes les fiches biens + pages statiques
- URLs propres et sémantiques (/acheter/villa-contemporaine-grand-baie-CAR-2026-001)
- Balises hreflang pour le bilingue FR/EN
- robots.txt configuré
- Canonical URLs sur chaque page

## Scope actuel
Phase 1 uniquement (pas de CRM avancé, pas d'espace vendeur).

## Design
- **Direction** : Editorial luxe / magazine d'architecture
- **Couleur principale** : #4A5A4F (vert militaire)
- **Palette** : blanc crème (#F8F6F1), noir, gris neutres
- **Typos** : DM Serif Display (titres) + Outfit (corps) + JetBrains Mono (labels techniques)
- **Style** : boutons rectangulaires (pas d'arrondi), animations subtiles au scroll, texture grain, beaucoup de blanc
- **Inspiration** : cabinet-igs.fr (premium professionnel immobilier)

## Fichiers de référence
- `CAHIER DES CHARGES CARRERO IMMOBILIER V1 AVRIL 2026.pdf` — Cahier des charges complet (21 pages)
- `ROADMAP-V1.md` — Features V1 + tâches ordonnées (9 phases, 70+ tâches)
- `.claude/plans/synthetic-purring-gadget.md` — Plan technique détaillé (architecture, schéma BDD, routes, services)
- `maquettes/` — Maquettes HTML statiques (charte-graphique, accueil, fiche-bien, acheter)

## Décisions prises
- Filtrage et pagination côté serveur (Inertia router.get)
- Locale par session (pas de préfixe URL /fr/ /en/)
- Table property_translations séparée (pas de JSON)
- URL vidéo Vimeo jamais dans le HTML initial (servie par endpoint backend authentifié)
- OTP SMS uniquement à l'inscription (pas dans le flux vidéo). Le flux vidéo est simplifié : pas connecté → engagement → vidéo (3 états)
- Events/Listeners Laravel pour les notifications (découplage)
- Tracking via API dédiée avec batch + sendBeacon
- Soft deletes sur properties
