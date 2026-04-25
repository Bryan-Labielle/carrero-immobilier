# Schéma Base de Données — CARRERO IMMOBILIER

**Stack** : MySQL · Laravel 13 · 11 tables
**Dernière mise à jour** : 15 avril 2026

---

## Vue d'ensemble

```
users
  ├── favorites ────────── properties
  ├── otp_codes                ├── property_translations
  ├── video_accesses           ├── property_images
  │     └── post_video_responses   └── property_documents
  ├── leads
  └── tracking_events
```

---

## 1. `users`

Comptes utilisateurs (acheteurs) et administrateur.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| first_name | VARCHAR(100) | NOT NULL | |
| last_name | VARCHAR(100) | NOT NULL | |
| email | VARCHAR(255) | NOT NULL, UNIQUE | |
| email_verified_at | TIMESTAMP | NULLABLE | |
| password | VARCHAR(255) | NOT NULL | Hashé (bcrypt) |
| phone | VARCHAR(20) | NOT NULL | Format international (+230...) |
| phone_verified | BOOLEAN | DEFAULT false | Validé par OTP à l'inscription |
| preferred_locale | ENUM('fr','en') | DEFAULT 'fr' | Langue préférée |
| is_admin | BOOLEAN | DEFAULT false | Accès back-office |
| remember_token | VARCHAR(100) | NULLABLE | Laravel auth |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**Index** : `email` (unique)
**Relations** : hasMany → favorites, otp_codes, video_accesses, leads, tracking_events

---

## 2. `properties`

Biens immobiliers. Soft delete pour préserver les données de tracking.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| reference | VARCHAR(20) | NOT NULL, UNIQUE | Ex: "CAR-2026-001" |
| slug | VARCHAR(300) | NOT NULL, UNIQUE | Pour les URLs SEO |
| type | ENUM('maison','appartement','terrain') | NOT NULL | |
| status | ENUM('draft','published','sold','archived') | DEFAULT 'draft' | |
| price | DECIMAL(12,2) | NOT NULL | En euros |
| surface_m2 | DECIMAL(8,2) | NOT NULL | Surface habitable |
| bedrooms | TINYINT UNSIGNED | NULLABLE | NULL pour terrain |
| bathrooms | TINYINT UNSIGNED | NULLABLE | NULL pour terrain |
| location_city | VARCHAR(100) | NOT NULL | Ville |
| location_region | VARCHAR(100) | NOT NULL | Département / région |
| latitude | DECIMAL(10,7) | NULLABLE | GPS pour carte |
| longitude | DECIMAL(10,7) | NULLABLE | GPS pour carte |
| accessible_to_foreigners | BOOLEAN | DEFAULT false | Filtre spécifique |
| vimeo_video_id | VARCHAR(50) | NULLABLE | ID vidéo complète (privée) |
| vimeo_teaser_id | VARCHAR(50) | NULLABLE | ID teaser 10-15s (public) |
| is_featured | BOOLEAN | DEFAULT false | Affiché en page d'accueil |
| vendor_name | VARCHAR(200) | NULLABLE | Nom du vendeur |
| vendor_email | VARCHAR(255) | NULLABLE | Pour le reporting hebdo |
| published_at | TIMESTAMP | NULLABLE | Date de mise en ligne |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete |

**Index** : `reference` (unique), `slug` (unique), `status` + `published_at`, `is_featured`, `type`
**Relations** : hasMany → property_translations, property_images, property_documents, video_accesses, tracking_events, favorites

---

## 3. `property_translations`

Contenu bilingue FR/EN de chaque bien. Table séparée (pas de JSON) pour permettre la recherche et l'indexation.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| property_id | BIGINT UNSIGNED | FK → properties.id, ON DELETE CASCADE | |
| locale | ENUM('fr','en') | NOT NULL | |
| title | VARCHAR(300) | NOT NULL | Titre du bien |
| description | TEXT | NOT NULL | Description longue |
| short_description | VARCHAR(500) | NULLABLE | Pour les cartes |
| features | JSON | NULLABLE | Liste de caractéristiques ["Piscine", "Garage"...] |
| neighborhood_description | TEXT | NULLABLE | Description du quartier |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**Index** : UNIQUE(`property_id`, `locale`)
**Relations** : belongsTo → properties

---

## 4. `property_images`

Photos des biens. Ordonnées par sort_order.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| property_id | BIGINT UNSIGNED | FK → properties.id, ON DELETE CASCADE | |
| path | VARCHAR(500) | NOT NULL | Chemin dans storage |
| alt_text | VARCHAR(300) | NULLABLE | Texte alternatif (SEO/accessibilité) |
| sort_order | SMALLINT UNSIGNED | DEFAULT 0 | Ordre d'affichage |
| is_cover | BOOLEAN | DEFAULT false | Image principale (cartes, OG) |
| created_at | TIMESTAMP | | |

**Index** : `property_id` + `sort_order`
**Relations** : belongsTo → properties

---

## 5. `property_documents`

Documents téléchargeables (plans, diagnostics...). Stockés dans un dossier privé (pas accessible publiquement).

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| property_id | BIGINT UNSIGNED | FK → properties.id, ON DELETE CASCADE | |
| file_path | VARCHAR(500) | NOT NULL | Chemin dans storage/app/private |
| original_name | VARCHAR(300) | NOT NULL | Nom du fichier original |
| label_fr | VARCHAR(200) | NOT NULL | Libellé en français |
| label_en | VARCHAR(200) | NULLABLE | Libellé en anglais |
| file_size | INT UNSIGNED | NOT NULL | Taille en octets |
| created_at | TIMESTAMP | | |

**Relations** : belongsTo → properties

---

## 6. `favorites`

Biens favoris des utilisateurs. Pivot simple.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| user_id | BIGINT UNSIGNED | FK → users.id, ON DELETE CASCADE | |
| property_id | BIGINT UNSIGNED | FK → properties.id, ON DELETE CASCADE | |
| created_at | TIMESTAMP | | |

**Index** : UNIQUE(`user_id`, `property_id`)
**Relations** : belongsTo → users, properties

---

## 7. `otp_codes`

Codes OTP pour la vérification téléphone à l'inscription uniquement.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| user_id | BIGINT UNSIGNED | FK → users.id, ON DELETE CASCADE | |
| code | VARCHAR(255) | NOT NULL | Hashé avec Hash::make() |
| phone | VARCHAR(20) | NOT NULL | Numéro destinataire |
| attempts | TINYINT UNSIGNED | DEFAULT 0 | Max 3 tentatives |
| verified_at | TIMESTAMP | NULLABLE | NULL si pas encore vérifié |
| expires_at | TIMESTAMP | NOT NULL | Création + 10 min |
| created_at | TIMESTAMP | | |

**Index** : `user_id` + `expires_at`
**Relations** : belongsTo → users
**Note** : Commande artisan `CleanExpiredOtpCodes` pour purger les codes expirés.

---

## 8. `video_accesses`

Trace l'accès vidéo par utilisateur et par bien. Un enregistrement par couple user/property.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| user_id | BIGINT UNSIGNED | FK → users.id, ON DELETE CASCADE | |
| property_id | BIGINT UNSIGNED | FK → properties.id, ON DELETE CASCADE | |
| engagement_accepted_at | TIMESTAMP | NULLABLE | Case d'engagement cochée |
| video_started_at | TIMESTAMP | NULLABLE | Lecture vidéo lancée |
| video_ended_at | TIMESTAMP | NULLABLE | Vidéo terminée |
| watch_duration_seconds | INT UNSIGNED | NULLABLE | Durée réelle de visionnage |
| post_action_completed | BOOLEAN | DEFAULT false | A choisi une des 3 options |
| reminder_sent_at | TIMESTAMP | NULLABLE | Relance 48h envoyée |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**Index** : UNIQUE(`user_id`, `property_id`)
**Relations** : belongsTo → users, properties · hasOne → post_video_responses
**Logique** : L'URL vidéo Vimeo n'est servie que si `engagement_accepted_at` IS NOT NULL.

---

## 9. `post_video_responses`

Réponse de l'utilisateur après visionnage (1 des 3 options).

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| video_access_id | BIGINT UNSIGNED | FK → video_accesses.id, ON DELETE CASCADE | |
| user_id | BIGINT UNSIGNED | FK → users.id | Pour requêtes directes |
| property_id | BIGINT UNSIGNED | FK → properties.id | Pour requêtes directes |
| action | ENUM('schedule_visit','request_info','decline') | NOT NULL | Option choisie |
| calendly_event_uri | VARCHAR(500) | NULLABLE | URI retournée par Calendly (option 1) |
| message | TEXT | NULLABLE | Question posée (option 2) |
| preferred_contact | ENUM('phone','email','whatsapp') | NULLABLE | Mode de rappel (option 2) |
| decline_reasons | JSON | NULLABLE | ["prix","localisation"...] (option 3) |
| decline_comment | TEXT | NULLABLE | Champ libre (option 3) |
| created_at | TIMESTAMP | | |

**Relations** : belongsTo → video_accesses, users, properties
**Note** : Un seul enregistrement par video_access (l'utilisateur ne peut répondre qu'une fois).

---

## 10. `leads`

Contacts entrants depuis les formulaires (contact, rappel, estimation). Les leads issus du parcours vidéo sont dans `post_video_responses`.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| user_id | BIGINT UNSIGNED | NULLABLE, FK → users.id | NULL si formulaire contact anonyme |
| property_id | BIGINT UNSIGNED | NULLABLE, FK → properties.id | NULL si demande générale |
| source | ENUM('contact_form','video_callback','sell_estimation') | NOT NULL | Origine du lead |
| status | ENUM('new','contacted','qualified','converted','lost') | DEFAULT 'new' | Pipeline commercial |
| name | VARCHAR(200) | NOT NULL | |
| email | VARCHAR(255) | NOT NULL | |
| phone | VARCHAR(20) | NULLABLE | |
| message | TEXT | NULLABLE | |
| metadata | JSON | NULLABLE | Données supplémentaires |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**Index** : `status`, `source`, `created_at`
**Relations** : belongsTo → users (nullable), properties (nullable)

---

## 11. `tracking_events`

Événements de tracking frontend. Table à forte volumétrie.

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| user_id | BIGINT UNSIGNED | NULLABLE, FK → users.id | NULL pour visiteurs anonymes |
| property_id | BIGINT UNSIGNED | NULLABLE, FK → properties.id | NULL pour pages sans bien |
| session_id | VARCHAR(64) | NOT NULL | UUID de session frontend |
| event_type | VARCHAR(50) | NOT NULL | page_view, video_play, video_complete, click_cta, favorite_toggle, document_download, share_click |
| page | VARCHAR(200) | NOT NULL | URL de la page |
| duration_seconds | INT UNSIGNED | NULLABLE | Temps passé (heartbeat) |
| metadata | JSON | NULLABLE | Données additionnelles |
| ip_address | VARCHAR(45) | NOT NULL | IPv4 ou IPv6 |
| user_agent | VARCHAR(500) | NOT NULL | Navigateur |
| created_at | TIMESTAMP | NOT NULL | |

**Index** : `property_id` + `created_at` (reporting), `session_id`, `event_type`, `created_at`
**Relations** : belongsTo → users (nullable), properties (nullable)
**Maintenance** : Purge recommandée des events > 12 mois.

---

## Enums Laravel

```php
// app/Enums/PropertyType.php
enum PropertyType: string {
    case Maison = 'maison';
    case Appartement = 'appartement';
    case Terrain = 'terrain';
}

// app/Enums/PropertyStatus.php
enum PropertyStatus: string {
    case Draft = 'draft';
    case Published = 'published';
    case Sold = 'sold';
    case Archived = 'archived';
}

// app/Enums/PostVideoAction.php
enum PostVideoAction: string {
    case ScheduleVisit = 'schedule_visit';
    case RequestInfo = 'request_info';
    case Decline = 'decline';
}

// app/Enums/LeadSource.php
enum LeadSource: string {
    case ContactForm = 'contact_form';
    case VideoCallback = 'video_callback';
    case SellEstimation = 'sell_estimation';
}

// app/Enums/LeadStatus.php
enum LeadStatus: string {
    case New = 'new';
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case Converted = 'converted';
    case Lost = 'lost';
}
```

---

## Diagramme des relations

```
users ─────────────┬──── 1:N ──── favorites ──── N:1 ──── properties
                   │                                         │
                   ├──── 1:N ──── otp_codes                  ├──── 1:N ──── property_translations
                   │                                         │
                   ├──── 1:N ──── video_accesses ── N:1 ─────┤
                   │                   │                     ├──── 1:N ──── property_images
                   │                   └── 1:1 ── post_video_responses
                   │                                         ├──── 1:N ──── property_documents
                   ├──── 1:N ──── leads ──── N:1 ────────────┤
                   │                                         │
                   └──── 1:N ──── tracking_events ── N:1 ────┘
```

---

## Notes techniques

- **Soft deletes** uniquement sur `properties` (préserve les tracking_events et video_accesses)
- **Slugs** générés automatiquement à partir du titre FR + ville + référence (ex: `villa-contemporaine-grand-baie-CAR-2026-001`)
- **OTP** : codes hashés en BDD, jamais en clair. Usage uniquement à l'inscription (pas dans le flux vidéo)
- **Vidéo** : `video_accesses.engagement_accepted_at` est la seule condition pour débloquer l'URL Vimeo signée
- **Tracking** : indexer `property_id + created_at` pour les requêtes de reporting hebdomadaire
- **JSON** : `features` (property_translations), `decline_reasons` (post_video_responses), `metadata` (leads, tracking_events)
