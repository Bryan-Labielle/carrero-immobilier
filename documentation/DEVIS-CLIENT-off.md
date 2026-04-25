# DEVIS — Site web CARRERO IMMOBILIER

**Devis n°** : DEV-2026-002
**Date** : 17 avril 2026
**Validité** : 30 jours

---

**Prestataire** :
Bryan Labielle
[Adresse]
[SIRET]
[Email / Téléphone]

**Client** :
Brice Portocarrero
CARRERO IMMOBILIER
Île Maurice

---

## Objet

Conception, développement et mise en ligne d'un site web immobilier premium pour CARRERO IMMOBILIER, incluant :
- Design et maquettes
- Développement full-stack (frontend + backend + back-office)
- Système de qualification acheteurs par vidéo
- Hébergement et mise en production

---

## Détail des prestations

### 1. Design & Maquettes

| Réf | Prestation | Forfait HT |
|-----|-----------|----------:|
| D1 | Charte graphique, maquettes de l'ensemble des pages (accueil, acheter, fiche bien, vendre, qui sommes-nous, contact, mon espace, back-office admin, auth) + responsive mobile | 750 € |
| | **Sous-total Design** | **750 €** |

*Forfait design — 1.5 jours*

### 2. Développement — Socle technique

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| T1 | Setup projet Laravel 13 + Inertia v3 + Vue 3 + Tailwind CSS + SSR | 0.5 | 250 € |
| T2 | Base de données MySQL (11 tables, migrations, modèles, relations) | 0.5 | 250 € |
| T3 | Système i18n bilingue FR/EN (middleware, vue-i18n, fichiers de langue) | 1.5 | 750 € |
| T4 | Layouts et composants UI de base (navbar, footer, switch langue, boutons) | 0.5 | 250 € |
| | **Sous-total Socle** | **3 j** | **1 500 €** |

### 3. Développement — Authentification & Sécurité

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| A1 | Vérification email par OTP (code 6 chiffres, expiration, tentatives) | 1 | 500 € |
| A2 | Intégration reCAPTCHA v3 + bandeau cookies | 0.5 | 250 € |
| | **Sous-total Auth** | **1.5 j** | **750 €** |

**Option** : Vérification par SMS (Twilio) en complément de l'OTP email — +1.5 j, +750 € HT. Coût récurrent ~0.05 €/SMS.

### 4. Développement — Pages publiques

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| P1 | Page Accueil (hero vidéo, concept, bénéfices vendeurs/acheteurs, biens à la une, CTA, animations scroll) | 1.5 | 750 € |
| P2 | Page Acheter (moteur de recherche, filtres multiples, pagination serveur, grille de résultats) | 1 | 500 € |
| P3 | Page Vendre (landing vendeurs, process en étapes, embed Calendly pour prise de RDV) | 1 | 500 € |
| P4 | Page Qui sommes-nous + Page Contact (formulaire, Google Maps, notification admin) | 0.5 | 250 € |
| | **Sous-total Pages publiques** | **4 j** | **2 000 €** |

### 5. Développement — Fiche bien & Système vidéo (coeur du site)

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| V1 | Fiche bien : galerie photos, description, caractéristiques, prix, documents téléchargeables, favoris, boutons de partage réseaux sociaux | 1.5 | 750 € |
| V2 | Teaser vidéo public + lecteur vidéo sécurisé (Vimeo domain privacy, URL servie par le backend uniquement aux utilisateurs connectés) | 0.5 | 250 € |
| V3 | Parcours post-vidéo : 3 options (prise de RDV visite via Calendly / demande d'infos-rappel / refus avec motifs détaillés) | 1.5 | 750 € |
| | **Sous-total Fiche bien** | **3.5 j** | **1 750 €** |

### 6. Développement — Espace utilisateur

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| U1 | Dashboard Mon espace : favoris, demandes en cours, rendez-vous | 1 | 500 € |
| U2 | Historique des biens consultés récemment | 0.5 | 250 € |
| U3 | Gestion du profil (modification données, changement email avec OTP) | 0.5 | 250 € |
| | **Sous-total Espace utilisateur** | **2 j** | **1 000 €** |

### 7. Développement — Notifications & Automatisations

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| N1 | Notifications email admin en temps réel + emails transactionnels (bienvenue, confirmation RDV, rappel) + relance automatique post-vidéo (48h sans réponse) | 1 | 500 € |
| N2 | Reporting vendeur hebdomadaire automatique (email chaque lundi : contacts, visites demandées, intérêts confirmés, motifs de refus) | 1 | 500 € |
| | **Sous-total Notifications** | **2 j** | **1 000 €** |

*Note : le tracking des vues et vidéos (nombre de vues par bien, durée de visionnage, clics) est géré via Google Tag Manager / Google Analytics — hors périmètre de développement.*

### 8. Développement — Back-office administrateur

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| B1 | CRUD biens (formulaire bilingue FR/EN, upload images avec réordonnancement, upload documents, champs Vimeo IDs, gestion statut publication) | 2 | 1 000 € |
| B2 | Dashboard statistiques + gestion utilisateurs + gestion leads (filtres, statut) + consultation rapports par bien | 1.5 | 750 € |
| | **Sous-total Back-office** | **3.5 j** | **1 750 €** |

### 9. SEO, Performance & Tests

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| S1 | SSR Inertia (rendu serveur pour indexation Google) | 0.5 | 250 € |
| S2 | Meta tags dynamiques + Open Graph + Twitter Cards + JSON-LD schema.org + pages d'erreur (404, 403, 500) | 0.5 | 250 € |
| S3 | Sitemap XML dynamique + robots.txt + canonical URLs + hreflang FR/EN | 0.5 | 250 € |
| S4 | Optimisation performance (lazy loading, code splitting, thumbnails) | 0.5 | 250 € |
| S5 | Tests fonctionnels (parcours complets : inscription, vidéo, post-vidéo, recherche, admin) | 1.5 | 750 € |
| | **Sous-total SEO & Tests** | **3.5 j** | **1 750 €** |

### 10. Hébergement & Mise en ligne

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| H1 | Configuration hébergement o2switch + déploiement production (PHP, MySQL, SSL, Git deploy) | 0.5 | 250 € |
| H2 | Configuration nom de domaine + DNS + certificat SSL | 0.5 | 250 € |
| H3 | Configuration emails transactionnels (SMTP) | 0.5 | 250 € |
| H4 | Configuration CRON (reporting hebdo, relance auto, nettoyage OTP) | 0.5 | 250 € |
| | **Sous-total Hébergement** | **2 j** | **1 000 €** |

---

## Récapitulatif

| Poste | Jours | Forfait HT |
|-------|:-----:|----------:|
| 1. Design & Maquettes | 1.5 j | 750 € |
| 2. Socle technique | 3 j | 1 500 € |
| 3. Authentification & Sécurité | 1.5 j | 750 € |
| 4. Pages publiques | 4 j | 2 000 € |
| 5. Fiche bien & Système vidéo | 3.5 j | 1 750 € |
| 6. Espace utilisateur | 2 j | 1 000 € |
| 7. Notifications & Automatisations | 2 j | 1 000 € |
| 8. Back-office admin | 3.5 j | 1 750 € |
| 9. SEO, Performance & Tests | 3.5 j | 1 750 € |
| 10. Hébergement & Mise en ligne | 2 j | 1 000 € |
| **TOTAL avant remise** | **26.5 j** | **13 250 € HT** |
| Remise commerciale (30%) | | -3 975 € |
| **TOTAL après remise** | **26.5 j** | **9 275 € HT** |
| TVA (20%) | | 1 855 € |
| **TOTAL TTC** | | **11 130 € TTC** |

**Option** : OTP SMS Twilio — +1.5 j, +675 € HT

---

## Coûts récurrents (à la charge du client)

| Service | Coût estimé | Fréquence |
|---------|:-----------:|:---------:|
| Hébergement o2switch | ~72 € HT | /an |
| Nom de domaine | ~10-15 € HT | /an |
| Vimeo (plan Pro — nécessaire pour la protection des vidéos par domaine) | ~180 € HT | /an |
| Service email transactionnel (Mailgun/Postmark) | 0 à 35 € | /mois (gratuit jusqu'à ~1000 emails/mois) |
| Calendly | Gratuit | (plan free) |
| reCAPTCHA v3 | Gratuit | — |
| Google Tag Manager / Analytics | Gratuit | — |

*Total récurrent estimé : ~300 €/an (hors Twilio si option SMS souscrite)*

---

## Conditions

- **Acompte** : 30% à la signature (2 783 € HT), 40% à mi-parcours (3 710 € HT), 30% à la mise en ligne (2 782 € HT)
- **Délai estimé** : 5 à 7 semaines à compter de la signature
- **Livrables** : Code source complet, accès hébergement, documentation technique
- **Garantie** : Correction des bugs pendant 30 jours après mise en ligne
- **Hors périmètre** : Rédaction de contenu, photos/vidéos des biens, création de comptes services tiers (Vimeo, Calendly, etc.), configuration GTM/GA4, mentions légales

---

**Bon pour accord**

Date : _______________

Signature du client : _______________
