côté # Notes techniques — Features critiques

**Usage** : Document interne — points d'attention pour le développement

---

## 1. Flux vidéo conditionné (V3 + V4) — 2 jours estimés, risque moyen

**Décision** : L'OTP est uniquement à l'inscription. Le flux vidéo est simplifié à 3 états :
1. Pas connecté → CTA "Créer un compte"
2. Connecté → Case d'engagement obligatoire
3. Engagement accepté → Vidéo complète débloquée

**Pourquoi ça reste complexe** :
- L'URL Vimeo ne doit JAMAIS apparaître dans le HTML source, même pour un utilisateur connecté qui n'a pas accepté l'engagement
- Le `VideoAccessController` gère 2 endpoints (accepter engagement, obtenir URL vidéo signée)
- L'état engagement doit être persisté par bien (table `video_accesses`) pour ne pas redemander à chaque visite
- Le teaser (public) et la vidéo complète (privée) sont deux vidéos Vimeo séparées

**Points de vigilance** :
- Vimeo privacy hash : l'URL `https://player.vimeo.com/video/{id}?h={hash}` doit être récupérée côté serveur via l'API Vimeo, jamais hardcodée
- Si l'utilisateur a déjà accepté l'engagement pour un bien, on lui montre directement la vidéo au retour

**Dépendances** :
- Compte Vimeo Pro minimum (pour le domain-level privacy)
- `vimeo/vimeo-api` en composer
- `@vimeo/player` en npm

---

## 2. Tracking avancé (N1) — 2 jours estimés, risque moyen

**Pourquoi c'est complexe** :
- Le composable `useTracking` doit s'accrocher à chaque navigation Inertia (pas juste le chargement initial)
- Heartbeat toutes les 30s = beaucoup de requêtes → besoin d'un système de batch côté frontend
- `navigator.sendBeacon` pour la fiabilité au départ de page (beforeunload n'est pas fiable)
- La table `tracking_events` va grossir très vite → besoin d'index bien pensés (property_id + created_at)
- Faut distinguer les visiteurs anonymes (session_id) des utilisateurs connectés (user_id)

**Points de vigilance** :
- Rate limiting API : 100 events/min/session pour éviter l'abus
- Pas de tracking avant consentement Axeptio (RGPD)
- Le heartbeat ne doit pas tourner sur les pages admin
- Attention à ne pas tracker les bots/crawlers (filtrer par user-agent)
- Prévoir une commande artisan de purge des events > 6 mois pour ne pas exploser la BDD

---

## 3. CRUD biens bilingue (B2) — 3 jours estimés, risque moyen

**Pourquoi c'est complexe** :
- Formulaire avec onglets FR/EN : chaque langue a ses propres champs (title, description, short_description, features)
- Upload multi-images avec drag & drop + réordonnancement (sort_order) + image de couverture (is_cover)
- Upload multi-documents avec labels bilingues
- Champs Vimeo IDs (teaser + vidéo complète) avec preview possible
- Validation croisée : au moins un titre FR obligatoire, images obligatoires pour publier
- Le statut (draft → published → sold → archived) contrôle la visibilité sur le front

**Points de vigilance** :
- Spatie Media Library peut simplifier les uploads, mais ajoute de la complexité de config
- Le drag & drop d'images avec réordonnancement nécessite un composant Vue dédié (vuedraggable ou sortablejs)
- Les images doivent être redimensionnées à l'upload (thumbnails pour les cartes, taille moyenne pour la galerie)
- Intervention Image pour le redimensionnement côté serveur
- La suppression d'une image doit nettoyer le stockage physique

---

## 4. Reporting vendeur hebdomadaire (N5) — 1.5 jours estimés, risque moyen

**Pourquoi c'est complexe** :
- Agrégation de données sur 7 jours glissants depuis `tracking_events`, `post_video_responses`, `leads`, `video_accesses`
- Requêtes SQL multi-join et GROUP BY sur des tables potentiellement volumineuses
- Template email riche avec données dynamiques (tableaux, chiffres, motifs de refus)
- Un rapport par bien publié avec un `vendor_email` → potentiellement N emails par exécution
- La commande doit être idempotente (pas de double envoi si le CRON se relance)

**Points de vigilance** :
- Indexer `tracking_events.property_id` + `tracking_events.created_at` pour les performances
- Utiliser `chunk` pour le traitement des biens (pas de `Property::all()`)
- Logger chaque envoi pour debug
- Prévoir un flag `last_report_sent_at` sur `properties` pour éviter les doublons
- Tester avec un bien qui a 0 interactions (le rapport doit quand même s'envoyer avec "aucune activité")

---

## 5. SSR Inertia sur o2switch (S1) — 0.5 jour estimé, risque moyen

**Pourquoi c'est un risque** :
- o2switch est un hébergement mutualisé (cPanel) → Node.js peut ne pas être disponible ou limité
- Inertia v3 SSR nécessite un process Node.js qui tourne en permanence (`@inertiajs/server`)
- Sur mutualisé, pas de `pm2` ou `supervisor` pour gérer le process

**Options** :
1. **Vérifier que o2switch supporte Node.js** via CloudLinux/LiteSpeed. Certains plans le permettent.
2. **Fallback sans SSR** : Inertia fonctionne sans SSR, mais les pages ne seront pas pré-rendues pour Google. On compense avec les meta tags statiques dans le blade principal.
3. **VPS si nécessaire** : si le SEO est vraiment critique, migrer vers un VPS (Hetzner ~4€/mois) pour avoir le contrôle total.

**À tester en tout premier** avant de coder quoi que ce soit.

---

## 6. OTP Twilio à l'inscription (A2) — 1 jour estimé, risque moyen

**Scope** : OTP uniquement à la création de compte (vérification téléphone). Pas d'OTP pour l'accès vidéo.

**Pourquoi c'est un risque** :
- Twilio nécessite une vérification d'identité pour envoyer des SMS à l'Île Maurice
- Les numéros expéditeurs doivent être enregistrés (réglementation locale)
- Délais de livraison SMS variables (parfois 10-30s, problème UX)

**Points de vigilance** :
- Utiliser Twilio Verify API (plus simple que les SMS bruts) : gère automatiquement la génération, l'envoi et la vérification
- Implémenter un cooldown entre les renvois (60s minimum)
- Gérer les cas d'erreur : numéro invalide, quota dépassé, service down
- Prévoir un fallback email si le SMS ne part pas
- Tester avec des numéros mauriciens (+230) ET internationaux (clientèle internationale)
- Coût réduit : un seul SMS par utilisateur (à l'inscription), pas à chaque bien

---

## 7. Parcours post-vidéo (V5) — 2 jours estimés, risque moyen

**Pourquoi c'est complexe** :
- 3 flux complètement différents à partir du même point (fin de vidéo)
- Option 1 (visite) : intégration Calendly avec prefill des données utilisateur + écoute du `postMessage` Calendly pour détecter la réservation
- Option 2 (infos) : 2 sous-choix (rappel simple OU formulaire question) → crée un lead avec source différente
- Option 3 (refus) : formulaire à 2 étapes (choix motif multi-select → champ libre optionnel)
- Chaque option doit : sauvegarder en BDD, notifier l'admin par email, marquer `post_action_completed = true`
- Si aucune option choisie après 48h → relance automatique

**Points de vigilance** :
- L'embed Calendly en mode inline widget nécessite un listener `window.addEventListener('message')` pour détecter `calendly.event_scheduled`
- Le prefill Calendly se fait via query params dans l'URL (`name=`, `email=`)
- Les motifs de refus sont des données business précieuses → bien les stocker structurés (pas juste un texte libre)
- L'utilisateur ne doit pouvoir répondre qu'une seule fois (vérifier `post_action_completed` avant d'afficher les options)

---

## Résumé des dépendances critiques à valider en amont

| Dépendance | Action | Bloquant pour |
|------------|--------|---------------|
| Node.js sur o2switch | Tester avant de commencer le dev | SSR, SEO |
| Compte Twilio vérifié | Créer + vérifier identité + numéro FR | Auth OTP, vidéo OTP |
| Compte Vimeo Pro | Souscrire + configurer domain privacy | Vidéo teaser + complète |
| SMTP transactionnel | Configurer Mailgun/Postmark | Notifications, reporting |
| Calendly | Créer compte + configurer types d'events | RDV visites + estimations |

**Recommandation** : valider ces 5 points avant de démarrer la semaine 1 de dev.
