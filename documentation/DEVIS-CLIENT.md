# DEVIS — Site web CARRERO IMMOBILIER

**Devis n°** : DEV-2026-003
**Date** : 17 avril 2026
**Validité** : 30 jours

---

**Prestataire** :
Bryan Labielle

**Client** :
Brice Portocarrero
CARRERO IMMOBILIER


---

## Objet

Conception, développement et mise en ligne d'un site web immobilier premium pour CARRERO IMMOBILIER, incluant :
- Design et maquettes
- Développement full-stack (frontend + backend + back-office)
- Système de qualification acheteurs par vidéo
- Hébergement et mise en production

*Développement accéléré par outils IA (génération de code assistée), avec supervision et validation humaine à chaque étape.*

---

## Détail des prestations

### 1. Design & Maquettes

| Réf | Prestation | Forfait HT |
|-----|-----------|----------:|
| D1 | Charte graphique, maquettes de l'ensemble des pages (accueil, acheter, fiche bien, vendre, qui sommes-nous, contact, mon espace, back-office admin, auth) + responsive mobile | 500 € |
| | **Sous-total Design** | **500 €** |

*Forfait design — 1 jour*

### 2. Développement — Socle technique

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| T1 | Setup projet Laravel 13 + Inertia v3 + Vue 3 + Tailwind CSS + SSR | 0.5 | 250 € |
| T2 | Base de données MySQL (11 tables, migrations, modèles, relations) | 0.5 | 250 € |
| T3 | Système i18n bilingue FR/EN (middleware, vue-i18n, fichiers de langue, clés FR/EN complètes) | 2 | 1 000 € |
| T4 | Layouts et composants UI de base (navbar, footer, switch langue, boutons) | 0.5 | 250 € |
| | **Sous-total Socle** | **3.5 j** | **1 750 €** |

### 3. Développement — Authentification & Sécurité

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| A1 | Vérification email par OTP (code 6 chiffres, expiration, tentatives) | 0.5 | 250 € |
| A2 | Intégration reCAPTCHA v3 + bandeau cookies | 0.5 | 250 € |
| | **Sous-total Auth** | **1 j** | **500 €** |

**Option** : Vérification par SMS (Twilio) en complément de l'OTP email — +1 j, +500 € HT. Coût récurrent ~0.05 €/SMS.

### 4. Développement — Pages publiques

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| P1 | Page Accueil (hero vidéo, concept, bénéfices vendeurs/acheteurs, biens à la une, CTA, animations scroll) | 1 | 500 € |
| P2 | Page Acheter (moteur de recherche, filtres multiples, pagination serveur, grille de résultats) | 1.5 | 750 € |
| P3 | Page Vendre (landing vendeurs, process en étapes, embed Calendly pour prise de RDV) | 1 | 500 € |
| P4 | Page Qui sommes-nous + Page Contact (formulaire, Google Maps, notification admin) | 0.5 | 250 € |
| | **Sous-total Pages publiques** | **4 j** | **2 000 €** |

### 5. Développement — Fiche bien & Système vidéo (coeur du site)

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| V1 | Fiche bien : galerie photos, description, caractéristiques, prix, documents téléchargeables, favoris, boutons de partage réseaux sociaux | 0.5 | 250 € |
| V2 | Teaser vidéo public + lecteur vidéo sécurisé (Vimeo domain privacy, URL servie par le backend uniquement aux utilisateurs connectés) | 0.5 | 250 € |
| V3 | Parcours post-vidéo : 3 options (prise de RDV visite via Calendly / demande d'infos-rappel / refus avec motifs détaillés) | 2 | 1 000 € |
| | **Sous-total Fiche bien** | **3 j** | **1 500 €** |

### 6. Développement — Espace utilisateur

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| U1 | Dashboard Mon espace : favoris, demandes en cours, rendez-vous | 0.5 | 250 € |
| U2 | Historique des biens consultés récemment | 0.5 | 250 € |
| U3 | Gestion du profil (modification données, changement email avec OTP) | 0.5 | 250 € |
| | **Sous-total Espace utilisateur** | **1.5 j** | **750 €** |

### 7. Développement — Notifications & Automatisations

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| N1 | Notifications email admin en temps réel + emails transactionnels (bienvenue, confirmation RDV, rappel) + relance automatique post-vidéo (48h sans réponse) | 1 | 500 € |
| | **Sous-total Notifications** | **1 j** | **500 €** |

*Note : le tracking des vues et vidéos (nombre de vues par bien, durée de visionnage, clics) est géré via Google Tag Manager / Google Analytics — hors périmètre de développement.*

### 8. Développement — Back-office administrateur

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| B1 | CRUD biens (formulaire bilingue FR/EN, upload images avec réordonnancement, upload documents, champs Vimeo IDs, gestion statut publication) | 2 | 1 000 € |
| B2 | Dashboard statistiques + gestion utilisateurs + gestion leads (filtres, statut) + consultation rapports par bien | 0.5 | 250 € |
| | **Sous-total Back-office** | **2.5 j** | **1 250 €** |

### 9. SEO, Performance & Tests

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| S1 | SSR Inertia (rendu serveur pour indexation Google) | 1 | 500 € |
| S2 | Meta tags dynamiques + Open Graph + Twitter Cards + JSON-LD schema.org + pages d'erreur (404, 403, 500) | 0.5 | 250 € |
| S3 | Sitemap XML dynamique + robots.txt + canonical URLs + hreflang FR/EN | 0.5 | 250 € |
| S4 | Optimisation performance (lazy loading, code splitting, thumbnails) | 0.5 | 250 € |
| S5 | Tests fonctionnels (parcours complets : inscription, vidéo, post-vidéo, recherche, admin) | 1 | 500 € |
| | **Sous-total SEO & Tests** | **3.5 j** | **1 750 €** |

### 10. Hébergement & Mise en ligne

| Réf | Prestation | Jours | Forfait HT |
|-----|-----------|:-----:|----------:|
| H1 | Configuration hébergement o2switch + déploiement production (PHP, MySQL, SSL, Git deploy) | 1 | 500 € |
| H2 | Configuration nom de domaine + DNS + certificat SSL | 0.5 | 250 € |
| H3 | Configuration emails transactionnels (SMTP) | 0.5 | 250 € |
| H4 | Configuration CRON (relance auto, nettoyage OTP) | 0.5 | 250 € |
| | **Sous-total Hébergement** | **2.5 j** | **1 250 €** |

---

## Récapitulatif

| Poste | Jours | Forfait HT |
|-------|:-----:|----------:|
| 1. Design & Maquettes | 1 j | 500 € |
| 2. Socle technique | 3.5 j | 1 750 € |
| 3. Authentification & Sécurité | 1 j | 500 € |
| 4. Pages publiques | 4 j | 2 000 € |
| 5. Fiche bien & Système vidéo | 3 j | 1 500 € |
| 6. Espace utilisateur | 1.5 j | 750 € |
| 7. Notifications & Automatisations | 1 j | 500 € |
| 8. Back-office admin | 2.5 j | 1 250 € |
| 9. SEO, Performance & Tests | 3.5 j | 1 750 € |
| 10. Hébergement & Mise en ligne | 2.5 j | 1 250 € |
| **TOTAL avant remise** | **23.5 j** | **11 750 €** |
| Remise commerciale (10%) | | -1 175 € |
| **TOTAL** | **23.5 j** | **10 575 €** |

*TVA non applicable, article 293 B du CGI*

**Option** : OTP SMS Twilio — +1 j, +500 € HT

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

- **Acompte** : 30% à la signature (3 173 €), 40% à mi-parcours (4 230 €), 30% à la mise en ligne (3 172 €)
- **Délai estimé** : 3 à 4 semaines à compter de la signature
- **Livrables** : Code source complet, accès hébergement, documentation technique
- **Garantie** : Correction des bugs pendant 30 jours après mise en ligne
- **Hors périmètre** : Rédaction de contenu, photos/vidéos des biens, création de comptes services tiers (Vimeo, Calendly, etc.), configuration GTM/GA4, mentions légales

---

**Bon pour accord**

Date : _______________

Signature du client : _______________
