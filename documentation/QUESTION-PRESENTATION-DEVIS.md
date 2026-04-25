# Préparation négociation devis — CARRERO IMMOBILIER

**Devis n°2** : 13 250 € HT · 26.5 jours · TJM 500 €/j
**Date du point** : à venir
**Client** : Brice Portocarrero — CARRERO INVESTISSEMENT (SIREN 884 298 266)

---

## Détail ligne par ligne

### 1. Design & Maquettes — 1.5j — 750 €

**Ce que ça inclut** : charte graphique complète (palette couleurs, typographies, composants UI), maquettes HTML de toutes les pages (accueil, acheter, fiche bien, vendre, qui sommes-nous, contact, mon espace, back-office, auth) + déclinaison responsive mobile.

**Argument** : 2 propositions de maquettes ont déjà été livrées. Les pages clés sont faites, le reste est de la déclinaison. C'est un forfait réduit.

---

### 2. Socle technique & Bilingue FR/EN — 4j — 2 000 €

**Ce que ça inclut** :
- Installation et configuration du framework (Laravel, Vue.js, rendu serveur SSR)
- Création de la base de données (11 tables avec toutes les relations)
- Système bilingue complet FR/EN (interface + contenu des biens traduit séparément)
- Composants de base (navigation, footer, switch langue)

**Si le client négocie** : le bilingue à lui seul représente 2j sur les 4. Chaque texte du site (menus, boutons, messages, formulaires, emails) doit exister en deux langues. C'est indispensable pour la clientèle internationale de l'Île Maurice. Sans bilingue on passerait à 2j.

---

### 3. Authentification & Sécurité — 1j — 500 €

**Ce que ça inclut** : inscription/connexion, vérification de l'email par code OTP (6 chiffres, expiration, tentatives limitées), anti-spam reCAPTCHA v3, bandeau cookies.

**Si le client demande "pourquoi pas le SMS ?"** : l'email est gratuit, fiable partout dans le monde (clientèle internationale), et le système d'envoi d'emails est déjà en place pour les notifications. Le SMS (Twilio) coûte ~0.05 €/SMS + complexité d'intégration. Ajout possible en option plus tard (+500 €).

---

### 4. Pages publiques — 4.5j — 2 250 €

**Ce que ça inclut** : 5 pages complètes.
- **Accueil (1j)** : vidéo d'ambiance en fond, présentation du concept en 6 points, bénéfices vendeurs/acheteurs, biens à la une, animations scroll
- **Acheter (1.5j)** : moteur de recherche avec 7 filtres (type, localisation, budget, surface, chambres, mots-clés, accessible étrangers), pagination côté serveur, tri, grille de résultats
- **Vendre (1j)** : landing page avec process en 6 étapes, intégration Calendly pour la prise de RDV
- **Qui sommes-nous + Contact (1j)** : storytelling, positionnement, formulaire de contact, Google Maps, notification admin

**Si le client trouve ça cher** : la page Acheter avec ses filtres multiples et la pagination serveur est la plus complexe techniquement. La page Vendre avec l'intégration Calendly demande aussi du travail d'intégration (prefill des données utilisateur, détection des réservations).

---

### 5. Fiche bien & Système vidéo — 3.5j — 1 750 €

**Ce que ça inclut** : c'est le coeur du site, le différenciant de Carrero.
- **Fiche bien (1j)** : galerie photos, description bilingue, caractéristiques, documents téléchargeables, favoris, partage réseaux sociaux
- **Vidéo sécurisée (0.5j)** : teaser public 10-15s visible par tous + vidéo complète protégée côté serveur, accessible uniquement aux inscrits. L'URL n'apparaît jamais dans le code source de la page.
- **Parcours post-vidéo (2j)** : 3 flux différents après visionnage — demande de visite (Calendly avec prefill), demande d'infos/rappel (choix du canal : téléphone/email/WhatsApp), refus avec motifs détaillés (Prix, Localisation, Surface, Agencement, Environnement, État général). Chaque réponse est enregistrée en base de données et déclenche une notification admin.

**Si le client demande "2j pour le post-vidéo c'est beaucoup ?"** : ce sont 3 formulaires complètement différents, avec l'intégration Calendly (détection automatique des RDV pris), la gestion des motifs de refus structurés, et les notifications. C'est ce qui génère les données business les plus précieuses — comprendre pourquoi un bien ne plaît pas.

---

### 6. Espace utilisateur — 2j — 1 000 €

**Ce que ça inclut** : tableau de bord (résumé), favoris, demandes en cours, rendez-vous programmés, historique des biens consultés, gestion du profil.

**Argument** : 6 sous-pages mais des listes simples. L'essentiel de la logique est déjà codée dans les autres modules (favoris dans la fiche bien, RDV dans le post-vidéo). C'est l'espace où l'acheteur retrouve ses démarches — important pour la fidélisation.

---

### 7. Notifications & Automatisations — 1.5j — 750 €

**Ce que ça inclut** :
- Notification email admin en temps réel à chaque interaction utilisateur
- Emails transactionnels (bienvenue, confirmation RDV, rappel)
- Relance automatique 48h après visionnage vidéo sans réponse

**Si le client demande "c'est quoi la relance 48h ?"** : si un acheteur regarde la vidéo mais ne choisit aucune des 3 options, il reçoit automatiquement un email 48h plus tard pour l'inviter à donner son retour. Ça maximise le taux de réponse sans intervention manuelle de Brice.

---

### 8. Back-office administrateur — 2.5j — 1 250 €

**Ce que ça inclut** :
- CRUD biens (formulaire bilingue FR/EN avec onglets, upload photos avec drag&drop et réordonnancement, upload documents, intégration Vimeo)
- Dashboard statistiques
- Gestion utilisateurs
- Gestion leads (pipeline : nouveau → contacté → qualifié → converti → perdu)
- Consultation rapports par bien

**Si le client négocie** : le CRUD biens bilingue avec upload d'images est le composant le plus complexe du back-office. C'est là que Brice passera le plus de temps au quotidien — il doit être solide et ergonomique.

---

### 9. SEO & Performance — 2.5j — 1 250 €

**Ce que ça inclut** :
- Rendu serveur (SSR) pour que Google indexe les pages
- Meta tags dynamiques par page
- Open Graph (partage Facebook/WhatsApp/LinkedIn avec image et titre corrects)
- Données structurées JSON-LD (rich snippets Google pour l'immobilier)
- Sitemap XML dynamique
- Balises hreflang FR/EN
- Optimisation vitesse (lazy loading, code splitting)

**Si le client demande "c'est quoi le SEO concrètement ?"** : c'est ce qui fait que ses biens apparaissent dans Google quand quelqu'un cherche "villa à vendre Île Maurice". Sans ça, le site est invisible. Le SSR est indispensable — sans rendu serveur, Google voit une page blanche.

**Si le client demande "c'est quoi le JSON-LD ?"** : c'est un format que Google lit pour comprendre que la page contient un bien immobilier (prix, surface, localisation). Ça permet d'afficher un résultat enrichi dans Google avec le prix et la photo directement dans les résultats de recherche.

---

### 10. Tests fonctionnels — 1j — 500 €

**Ce que ça inclut** : tests des parcours complets (inscription → email → vidéo → post-vidéo → notification admin), tests recherche/filtres, tests CRUD admin.

**Argument** : c'est la garantie qualité. Sans tests, des bugs passent en production et ça coûte plus cher à corriger après. C'est aussi ce qui permet de livrer sereinement.

---

### 11. Hébergement & Mise en ligne — 2.5j — 1 250 €

**Ce que ça inclut** : configuration serveur o2switch (PHP, MySQL, SSL, Node.js pour le SSR), domaine + DNS, emails transactionnels (SMTP), tâches planifiées (relance auto, nettoyage), déploiement production, vérification complète en environnement réel.

---

## Stratégie de négociation

### Si le client veut réduire le prix

| Ce qu'on peut retirer/réduire | Économie | Impact |
|---|---|---|
| Tests fonctionnels | -500 € | Risque de bugs en production |
| Espace utilisateur réduit (garder favoris + profil, retirer historique/demandes/RDV) | -500 € | UX dégradée pour les acheteurs |
| Bilingue repoussé en V2 (FR uniquement au lancement) | -1 000 € | Perd la clientèle internationale |
| Notifications simplifiées (pas de relance 48h) | -250 € | Moins de retours acheteurs |
| Pages publiques : fusionner Qui sommes-nous + Contact en une page | -250 € | Impact mineur |

### Ce qu'on NE PEUT PAS retirer

| Poste | Raison |
|---|---|
| Système vidéo | C'est le coeur du concept de qualification acheteurs |
| Back-office | Brice doit pouvoir gérer ses biens en autonomie |
| SEO/SSR | Sans ça le site est invisible sur Google |
| Authentification | Nécessaire pour protéger l'accès aux vidéos |
| Parcours post-vidéo | C'est ce qui génère les données business (motifs de refus, demandes de visite) |

### Paliers de prix possibles

| Scénario | Retrait | Total |
|---|---|---|
| **Devis complet** | Rien | **13 250 €** |
| **Léger** | Tests réduits + Qui sommes-nous/Contact fusionnés | **12 500 €** |
| **Modéré** | + Espace utilisateur réduit + pas de relance 48h | **11 750 €** |
| **Minimum viable** | + Bilingue repoussé en V2 | **10 750 €** |

### Arguments principaux

1. **Le TJM de 500 €/j** est compétitif pour du développement full-stack sur mesure. Le marché est entre 400 et 800 €/j pour ce type de prestation.

2. **Ce n'est pas un site vitrine** : c'est un outil business avec système de qualification acheteurs (vidéo + post-vidéo + données structurées), back-office bilingue complet, et SEO optimisé.

3. **Le retour sur investissement** : chaque mandat signé grâce au site rembourse une partie du développement. Les données post-vidéo (motifs de refus) permettent d'ajuster le prix des biens et d'accélérer les ventes.

4. **Coûts récurrents faibles** : ~300 €/an tout compris (hébergement + domaine + Vimeo). Pas de licence logicielle, pas d'abonnement mensuel élevé.

5. **Garantie** : correction des bugs pendant 30 jours après mise en ligne, code source livré intégralement.
