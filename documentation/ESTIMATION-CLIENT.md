# ESTIMATION — Site web CARRERO IMMOBILIER

**Document n°** : EST-2026-001
**Date** : 17 avril 2026
**Validité** : 30 jours

---

**Prestataire** :
Bryan Labielle
Développeur web full-stack

**Client** :
Brice Portocarrero
CARRERO IMMOBILIER
Île Maurice

---

## Objet

Conception, développement et mise en ligne d'un site web immobilier premium pour CARRERO IMMOBILIER, incluant :
- Design et maquettes responsive
- Développement full-stack (frontend + backend + back-office administrateur)
- Système de qualification des acheteurs par vidéo immersive
- Référencement naturel (SEO)
- Hébergement et mise en production

---

## Périmètre fonctionnel

### Pages publiques
- **Accueil** : vidéo d'ambiance, présentation du concept, bénéfices vendeurs/acheteurs, biens à la une
- **Acheter** : moteur de recherche avec filtres (type, localisation, budget, surface, chambres, mots-clés, accessible étrangers), affichage en grille paginée
- **Vendre** : landing page vendeurs, présentation du processus en étapes, prise de rendez-vous en ligne (Calendly)
- **Qui sommes-nous** : histoire, positionnement, ouverture internationale
- **Contact** : formulaire, coordonnées, Google Maps

### Fiche bien (coeur du site)
- Galerie photos, description détaillée, caractéristiques, prix
- Teaser vidéo public (10-15 secondes) visible par tous
- Vidéo complète sécurisée, accessible uniquement aux utilisateurs inscrits
- Parcours post-vidéo avec 3 options : demande de visite (Calendly), demande d'informations/rappel, ou retour avec motifs détaillés
- Documents téléchargeables (plans, diagnostics)
- Favoris et boutons de partage réseaux sociaux

### Espace utilisateur
- Tableau de bord avec résumé
- Mes favoris, mes demandes en cours, mes rendez-vous
- Historique des biens consultés
- Gestion du profil

### Notifications & Automatisations
- Notification email à l'administrateur à chaque interaction utilisateur
- Emails transactionnels : bienvenue, confirmation de rendez-vous, rappel
- Relance automatique par email si pas de réponse 48h après visionnage vidéo

### Back-office administrateur
- Gestion complète des biens (formulaire bilingue FR/EN, upload photos et documents, intégration vidéo Vimeo, gestion des statuts de publication)
- Tableau de bord avec statistiques globales
- Gestion des utilisateurs et des leads (filtres, statuts, historique)
- Consultation des rapports par bien

### SEO & Performance
- Rendu serveur (SSR) pour l'indexation Google
- Meta tags dynamiques, Open Graph, Twitter Cards, données structurées JSON-LD
- Sitemap XML dynamique, robots.txt, URLs canoniques, hreflang FR/EN
- Optimisation des performances (lazy loading, code splitting, images optimisées)
- Pages d'erreur personnalisées (404, 403, 500)
- Tests fonctionnels complets

### Bilingue FR/EN
- Interface complète traduite (menus, boutons, formulaires, messages, emails)
- Contenu des biens en deux langues (table de traductions dédiée)
- Switch de langue visible dans la navigation

### Sécurité
- Vérification email par code OTP à l'inscription
- Protection anti-spam (reCAPTCHA v3)
- Bandeau de consentement cookies
- Vidéos protégées (URL jamais exposée dans le code source)

---

## Estimation détaillée

### 1. Design & Maquettes

| Prestation | Durée |
|-----------|:-----:|
| Charte graphique, maquettes de l'ensemble des pages + responsive mobile | 1.5 j |
| **Sous-total** | **1.5 j** |

### 2. Socle technique

| Prestation |  Durée  |
|-----------|:-------:|
| Setup projet (Laravel, Vue.js, Tailwind CSS, rendu serveur) |  0.5 j  |
| Base de données (11 tables, modèles, relations) |   1 j   |
| Système bilingue FR/EN (interface + contenu des biens) |   2 j   |
| Layouts et composants UI de base |  0.5 j  |
| **Sous-total** | **4 j** |

### 3. Authentification & Sécurité

| Prestation | Durée |
|-----------|:-----:|
| Inscription / Connexion avec vérification email OTP | 0.5 j |
| Anti-spam (reCAPTCHA) + bandeau cookies | 0.5 j |
| **Sous-total** | **1 j** |

### 4. Pages publiques

| Prestation |   Durée   |
|-----------|:---------:|
| Page Accueil (vidéo d'ambiance, concept, bénéfices, biens à la une, animations) |    1 j    |
| Page Acheter (moteur de recherche, filtres multiples, pagination, grille de résultats) |   1.5 j   |
| Page Vendre (landing vendeurs, processus en étapes, prise de RDV Calendly) |    1 j    |
| Pages Qui sommes-nous + Contact (formulaire, Google Maps, notification admin) |    1 j    |
| **Sous-total** | **4.5 j** |

### 5. Fiche bien & Système vidéo

| Prestation | Durée |
|-----------|:-----:|
| Fiche bien complète (galerie, description, caractéristiques, documents, favoris, partage) | 1 j |
| Teaser vidéo public + lecteur vidéo sécurisé (Vimeo) | 0.5 j |
| Parcours post-vidéo (3 options : visite Calendly / infos-rappel / refus avec motifs) | 2 j |
| **Sous-total** | **3.5 j** |

### 6. Espace utilisateur

| Prestation |  Durée  |
|-----------|:-------:|
| Dashboard, favoris, demandes en cours, rendez-vous |   1 j   |
| Historique des biens consultés |  0.5 j  |
| Gestion du profil |  0.5 j  |
| **Sous-total** | **2 j** |

### 7. Notifications & Automatisations

| Prestation                                                                        |   Durée   |
|-----------------------------------------------------------------------------------|:---------:|
| Notifications admin + emails transactionnels + relance automatique 48h + tracking |   1.5 j   |
| **Sous-total**                                                                    | **1.5 j** |

*Note : le suivi des statistiques de fréquentation (nombre de vues, durée de visionnage, clics) est géré via Google Analytics / Google Tag Manager, indépendamment du développement du site.*

### 8. Back-office administrateur

| Prestation | Durée |
|-----------|:-----:|
| Gestion des biens (formulaire bilingue, upload photos/documents, intégration Vimeo) | 2 j |
| Dashboard statistiques + gestion utilisateurs + gestion leads + rapports | 0.5 j |
| **Sous-total** | **2.5 j** |

### 9. SEO, Performance & Tests

| Prestation | Durée |
|-----------|:-----:|
| Rendu serveur (SSR) pour l'indexation Google | 1 j |
| Meta tags, Open Graph, Twitter Cards, données structurées, pages d'erreur | 0.5 j |
| Sitemap XML, robots.txt, URLs canoniques, hreflang FR/EN | 0.5 j |
| Optimisation des performances | 0.5 j |
| Tests fonctionnels (parcours complets) | 1 j |
| **Sous-total** | **3.5 j** |

### 10. Hébergement & Mise en ligne

| Prestation | Durée |
|-----------|:-----:|
| Configuration serveur + déploiement production | 1 j |
| Nom de domaine + DNS + certificat SSL | 0.5 j |
| Configuration emails transactionnels | 0.5 j |
| Configuration des tâches planifiées (relances, nettoyage) | 0.5 j |
| **Sous-total** | **2.5 j** |

---

## Récapitulatif

| Poste | Durée estimée  |
|-------|:--------------:|
| 1. Design & Maquettes |     1.5 j      |
| 2. Socle technique |      4 j       |
| 3. Authentification & Sécurité |      1 j       |
| 4. Pages publiques |     4.5 j      |
| 5. Fiche bien & Système vidéo |     3.5 j      |
| 6. Espace utilisateur |      2 j       |
| 7. Notifications & Automatisations |     1.5 j      |
| 8. Back-office administrateur |     2.5 j      |
| 9. SEO, Performance & Tests |     3.5 j      |
| 10. Hébergement & Mise en ligne |     2.5 j      |
| **TOTAL** | **26.5 jours** |

**Budget estimé : 13250 €**

*TVA non applicable, article 293 B du CGI*

**Option** : Vérification par SMS en complément de l'email — +1 jour, +500 €

---

## Coûts récurrents (à la charge du client)

| Service | Coût estimé | Fréquence |
|---------|:-----------:|:---------:|
| Hébergement (o2switch) | ~72 € | /an |
| Nom de domaine | ~10-15 € | /an |
| Vimeo (hébergement vidéo sécurisé) | ~180 € | /an |
| Service email transactionnel | 0 à 35 € | /mois (gratuit jusqu'à ~1 000 emails/mois) |
| Calendly (prise de RDV) | Gratuit | |
| Google Analytics / Tag Manager | Gratuit | |

**Total récurrent estimé : ~300 €/an**

---

## Modalités

- **Paiement** : 30% à la signature, 40% à mi-parcours, 30% à la mise en ligne
- **Délai estimé** : 5 à 7 semaines à compter de la signature
- **Livrables** : code source complet, accès hébergement, documentation technique
- **Garantie** : correction des bugs pendant 30 jours après mise en ligne
- **Hors périmètre** : rédaction de contenu, photos et vidéos des biens, création des comptes services tiers (Vimeo, Calendly, etc.), configuration Google Analytics/GTM, rédaction des mentions légales

---

## Prochaines étapes

1. Validation de cette estimation
2. Signature et versement de l'acompte
3. Validation des maquettes (2 propositions fournies)
4. Développement par phases
5. Recette et mise en ligne

---

**Bon pour accord**

Date : _______________

Signature : _______________
