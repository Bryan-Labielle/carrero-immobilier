# Vue 3 + TypeScript + Inertia — Rules & Conventions

> Fichier de rules à réutiliser sur tout nouveau projet Laravel + Inertia + Vue 3 + TailwindCSS.
> Basé sur les conventions du projet cisteme-dashboard.

---

## 1. Architecture fichiers

```
resources/js/
├── components/
│   ├── ui/                    # Primitives Shadcn/Reka-ui (ne pas modifier)
│   ├── Input/                 # Wrappers d'inputs réutilisables (BaseField, BaseSelect)
│   ├── form/                  # Formulaires métier (UserForm, ProfileForm, etc.)
│   ├── table/                 # DataTable + sous-composants (Pagination, Search, Actions, Toolbar)
│   ├── table-cell/            # Cellules custom pour DataTable (IdentityCell, etc.)
│   ├── dashboard/             # Widgets dashboard (un composant = un widget)
│   ├── modal/                 # Modales réutilisables (confirmModal, etc.)
│   ├── configuration/         # Formulaires de config
│   └── [composants app]       # AppSidebar, NavMain, Heading, StatusBadge, etc.
├── composables/
│   ├── [domaine]/             # Composables par domaine (users/, profiles/, table/)
│   └── [utilitaires]          # useAuth, useCurrentUrl, useNotify, useNumberFormat, etc.
├── layouts/                   # Layouts Inertia (AdminLayout, AuthLayout, etc.)
├── pages/                     # Pages Inertia (= routes côté front)
│   ├── admin/                 # Pages admin groupées par ressource (users/, collaborators/)
│   ├── auth/                  # Pages auth (Login, ForgotPassword, etc.)
│   └── settings/              # Pages paramètres
├── types/                     # Types TypeScript (un fichier par domaine + index.ts)
├── lib/                       # Utilitaires purs (utils.ts avec cn(), toUrl(), etc.)
├── routes/                    # Routes Wayfinder auto-générées
└── actions/                   # Actions Wayfinder auto-générées
```

### Règles d'architecture

- **Pas de nouveau dossier racine** sans validation explicite.
- **Un composant = un fichier** `.vue`. Pas de composants multiples par fichier.
- **Regrouper par domaine** : `composables/users/`, `composables/profiles/`, pas `composables/useUserForm.ts` en vrac.
- **Les types sont dans `types/`**, jamais inline dans un composant sauf types locaux très simples.
- **`lib/utils.ts`** contient les utilitaires purs (cn, toUrl, formatters). Pas de logique métier.

---

## 2. Conventions de nommage

| Élément             | Convention                      | Exemple                                |
| ------------------- | ------------------------------- | -------------------------------------- |
| Composant Vue       | PascalCase                      | `UserForm.vue`, `DataTable.vue`        |
| Composable          | camelCase préfixé `use`         | `useUserForm.ts`, `useDataTable.ts`    |
| Fichier type        | camelCase domaine               | `user.ts`, `pagination.ts`             |
| Variables/fonctions | camelCase                       | `currentProgress`, `fetchData()`       |
| Types/Interfaces    | PascalCase                      | `User`, `PaginationMeta`, `NavItem`    |
| Props booléennes    | préfixe `is`/`has`/`can`/`show` | `isActive`, `hasErrors`, `showPerPage` |
| Enum keys           | TitleCase                       | `Monthly`, `FavoritePerson`            |
| Événements emit     | camelCase                       | `pageChange`, `confirm`, `update:open` |
| CSS classes custom  | kebab-case                      | (via Tailwind, rarement custom)        |

### Nommage composants par type

- **Formulaires** : `{Ressource}Form.vue` → `UserForm.vue`, `ProfileForm.vue`
- **Colonnes table** : `use{Ressource}Columns.ts` → `useUserColumns.ts`
- **Form composable** : `use{Ressource}Form.ts` → `useUserForm.ts`
- **Widgets** : `{Nom}Widget.vue` → `TurnoverWidget.vue`, `QuotesWidget.vue`
- **Cellules table** : `{Nom}Cell.vue` → `IdentityCell.vue`
- **Pages CRUD** : `Index.vue`, `Create.vue`, `Edit.vue` dans `pages/admin/{ressource}/`

---

## 3. Script setup & TypeScript

### Toujours `<script setup lang="ts">`

```vue
<script setup lang="ts">
// Imports → Props → Emits → Composables → State → Computed → Methods
</script>
```

### Ordre des imports (strict)

```ts
// 1. Vue / Inertia
import { computed, ref, watch } from 'vue';
import { router, usePage, Link, Form, Head, setLayoutProps } from '@inertiajs/vue3';

// 2. Librairies tierces
import { ChevronRight, Loader2 } from '@lucide/vue';
import VueApexCharts from 'vue3-apexcharts';

// 3. Composants locaux (@/components/)
import BaseField from '@/components/Input/BaseField.vue';
import DataTable from '@/components/table/DataTable.vue';

// 4. Composables (@/composables/)
import { useAuth } from '@/composables/useAuth';
import { useUserForm } from '@/composables/users/useUserForm';

// 5. Routes & Actions Wayfinder (@/routes/, @/actions/)
import UserController from '@/actions/App/Http/Controllers/Admin/UserController';
import { dashboard } from '@/routes/admin';

// 6. Types (toujours avec `import type`)
import type { User, PaginationMeta, BreadcrumbItem } from '@/types';
```

### Props : toujours typées avec generics

```ts
// ✅ Bon
defineProps<{
    user?: User;
    roles: Role[];
    isEditing?: boolean;
}>();

// ✅ Avec defaults
withDefaults(
    defineProps<{
        variant?: 'default' | 'small';
        showIcon?: boolean;
    }>(),
    {
        variant: 'default',
        showIcon: true,
    },
);

// ✅ Destructuration des props (Vue 3.5+)
const { user, roles } = defineProps<{
    user?: User;
    roles: Role[];
}>();

// ❌ Jamais : defineProps({ user: Object })
```

### Emits : toujours typés

```ts
// ✅ Bon
const emit = defineEmits<{
    confirm: [];
    cancel: [];
    pageChange: [page: number];
    'update:open': [value: boolean];
}>();

// ❌ Jamais : defineEmits(['confirm', 'cancel'])
```

### v-model : utiliser defineModel

```ts
// ✅ Bon
const model = defineModel<string>();
const search = defineModel<string>('search');

// ❌ Pas de props + emit manuels pour v-model
```

### Generics sur composants (DataTable pattern)

```vue
<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef } from '@tanstack/vue-table';

const { columns, data } = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
}>();
</script>
```

---

## 4. Composables

### Structure standard

```ts
// composables/useMonTruc.ts

// 1. Type de retour explicite
export type UseMonTrucReturn = {
    value: Ref<string>;
    doSomething: (param: number) => void;
};

// 2. Fonction exportée nommée (pas default)
export function useMonTruc(options?: Options): UseMonTrucReturn {
    const value = ref('');

    function doSomething(param: number): void {
        // ...
    }

    return { value, doSomething };
}
```

### Composables de formulaire

```ts
// composables/users/useUserForm.ts
export function useUserForm(user?: User) {
    const isEditing = !!user;
    const route = isEditing
        ? (UserController.update(user.id) as UrlMethodPair)
        : (UserController.store() as UrlMethodPair);

    const form = useForm(route, {
        first_name: user?.first_name ?? '',
        last_name: user?.last_name ?? '',
        email: user?.email ?? '',
    });

    const submitLabel = isEditing ? 'Mettre à jour' : 'Créer';

    const submit = () => {
        form.submit({
            preserveScroll: true,
            onError: () => notifyValidationError(),
        });
    };

    return { form, submitLabel, submit, isEditing };
}
```

### Composables de colonnes table

```ts
// composables/users/useUserColumns.ts
export function useUserColumns(): ColumnDef<User>[] {
    return [
        {
            id: 'identity',
            header: 'Utilisateur',
            cell: ({ row }) =>
                h(IdentityCell, {
                    name: row.original.full_name,
                    email: row.original.email,
                }),
        },
        actionsColumn<User>({
            edit: { url: (id) => UserController.edit(id) },
            delete: { url: (id) => UserController.destroy(id) },
        }),
    ];
}
```

### Composable table (useDataTable)

```ts
export function useDataTable(options: UseDataTableOptions) {
    const search = ref(initialSearch);

    const goToPage = (page: number): void => {
        router.get(options.indexUrl, { ...params, page }, { preserveState: true, preserveScroll: true });
    };

    const setPerPage = (perPage: number): void => {
        router.get(options.indexUrl, { ...params, per_page: perPage, page: 1 }, { preserveState: true });
    };

    // Debounced search
    watchDebounced(search, fetchData, { debounce: 300 });

    return { search, goToPage, setPerPage };
}
```

---

## 5. Types TypeScript

### Organisation des types

```
types/
├── index.ts           # Re-exports tout : export * from './user'; export * from './pagination';
├── auth.ts            # User, Auth
├── user.ts            # User, UserRole
├── pagination.ts      # PaginationMeta, Paginated<T>
├── navigation.ts      # NavItem, BreadcrumbItem
├── table.ts           # TableAction, ColumnMeta
├── dashboard.ts       # TurnoverData, QuotesData, etc.
├── ui.ts              # AppVariant
├── global.d.ts        # Déclarations globales
└── vue-shims.d.ts     # Shims Vue
```

### Patterns de types récurrents

```ts
// Pagination générique
export type PaginationMeta = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
};

export type Paginated<T> = {
    data: T[];
    meta: PaginationMeta;
};

// NavItem avec children récursifs
export type NavItem = {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    roles?: UserRole[];
    children?: NavItem[];
};

// Union pour actions table
export type TableAction = 'view' | 'edit' | 'delete';
```

### Règles TypeScript

- **`import type`** pour tout import de type pur.
- **Pas de `any`** sauf dans les cas justifiés (ex: slot props legacy). Préférer `unknown`.
- **Pas de `as` casting** sauf pour Wayfinder (`as UrlMethodPair`).
- **Types > Interfaces** pour les unions et types simples. Interfaces pour les contrats extensibles.
- **Retour explicite** sur les fonctions de composables. Optionnel sur les fonctions courtes inline.

---

## 6. Templates Vue

### Structure d'une page CRUD Index

```vue
<script setup lang="ts">
import { setLayoutProps } from '@inertiajs/vue3';
import DataTable from '@/components/table/DataTable.vue';
import IndexPageHeader from '@/components/IndexPageHeader.vue';
import { useUserColumns } from '@/composables/users/useUserColumns';
import { useDataTable } from '@/composables/table/useDataTable';
import type { BreadcrumbItem, Paginated, User } from '@/types';

const { users } = defineProps<{
    users: Paginated<User>;
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: dashboard() }, { title: 'Utilisateurs' }];
setLayoutProps({ title: 'Utilisateurs', breadcrumbs });

const columns = useUserColumns();
const { search, goToPage, setPerPage } = useDataTable({
    indexUrl: UserController.index(),
    meta: () => users.meta,
});
</script>

<template>
    <IndexPageHeader title="Utilisateurs" :create-route="UserController.create()" />
    <DataTable
        v-model:search="search"
        :columns="columns"
        :data="users.data"
        :meta="users.meta"
        :go-to-page="goToPage"
        :set-per-page="setPerPage"
    />
</template>
```

### Structure d'une page formulaire Create/Edit

```vue
<script setup lang="ts">
import { setLayoutProps } from '@inertiajs/vue3';
import UserForm from '@/components/form/UserForm.vue';
import type { User, Role } from '@/types';

const { user, roles } = defineProps<{
    user?: User;
    roles: Role[];
}>();

setLayoutProps({
    title: user ? "Modifier l'utilisateur" : 'Créer un utilisateur',
    breadcrumbs: [
        /* ... */
    ],
});
</script>

<template>
    <UserForm :user="user" :roles="roles" />
</template>
```

### Structure d'un formulaire

```vue
<template>
    <Form v-bind="form()" v-slot="{ errors, processing }" class="flex flex-col gap-6">
        <!-- Section avec header -->
        <section class="rounded-2xl border bg-white p-6 shadow-xs">
            <FormSectionHeader :icon="UserIcon" title="Informations" description="..." />
            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                <BaseField name="first_name" label="Prénom" :error="errors.first_name" required>
                    <Input v-model="form.first_name" @change="form.validate('first_name')" />
                </BaseField>
                <!-- autres champs -->
            </div>
        </section>

        <!-- Bouton submit fixe -->
        <Button type="submit" :disabled="processing || form.hasErrors" class="fixed top-5 right-10 z-50">
            <Loader2 v-if="processing" class="h-4 w-4 animate-spin" />
            {{ submitLabel }}
        </Button>
    </Form>
</template>
```

### Patterns template récurrents

```vue
<!-- Rendu conditionnel -->
<div v-if="status" class="text-sm text-green-600">{{ status }}</div>

<!-- Boucle avec key -->
<template v-for="item in items" :key="item.id">
    <!-- Composant dynamique (icône) -->
    <component :is="item.icon" class="h-4 w-4" />

    <!-- Transition feedback -->
    <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
    >
        <p v-show="recentlySuccessful" class="text-sm text-neutral-600">Enregistré.</p>
    </Transition>

    <!-- Loading state sur bouton -->
    <Button :disabled="form.processing">
        <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
        {{ label }}
    </Button>
</template>
```

---

## 7. Formulaires & Validation

### Validation inline au changement

```vue
<Input v-model="form.email" @change="form.validate('email')" />
<InputError :message="errors.email" />
```

### Désactiver le submit si erreurs

```vue
<Button type="submit" :disabled="form.processing || form.hasErrors">
```

### Reset partiel après succès

```vue
<Form v-bind="form()" :reset-on-success="['password', 'password_confirmation']">
```

### Notification d'erreur globale

```ts
import { useNotify } from '@/composables/useNotify';
const { notifyValidationError } = useNotify();

form.submit({
    onError: () => notifyValidationError(),
});
```

---

## 8. Navigation & Routing

### Wayfinder : toujours des fonctions typées

```ts
// ✅ Bon — import depuis @/actions/ ou @/routes/
import UserController from '@/actions/App/Http/Controllers/Admin/UserController';
UserController.index(); // → '/admin/users'
UserController.create(); // → '/admin/users/create'
UserController.edit(user.id); // → '/admin/users/5/edit'
UserController.destroy(user.id); // → { url: '/admin/users/5', method: 'DELETE' }

// ❌ Jamais de routes hardcodées
href = '/admin/users';
```

### Breadcrumbs via setLayoutProps

```ts
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard() },
    { title: 'Utilisateurs', href: UserController.index() },
    { title: 'Créer' },
];
setLayoutProps({ title: 'Créer un utilisateur', breadcrumbs });
```

### Navigation active (sidebar)

```ts
const { isCurrentUrl } = useCurrentUrl();
// Compare le pathname Inertia avec le href
<SidebarMenuButton :is-active="isCurrentUrl(item.href)">
```

---

## 9. Widgets Dashboard

### Pattern standard

```vue
<script setup lang="ts">
import VueApexCharts from 'vue3-apexcharts';
import { computed } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useMonthLabels } from '@/composables/useMonthLabels';
import { useNumberFormat } from '@/composables/useNumberFormat';
import type { TurnoverData } from '@/types';

const { data } = defineProps<{ data: TurnoverData }>();

const { allMonthLabels, monthlyToSeries } = useMonthLabels();
const { compactNumber } = useNumberFormat();

const series = computed(() => [
    { name: 'Réalisé', data: monthlyToSeries(data.monthly) },
    { name: 'Objectif', data: monthlyToSeries(data.target) },
]);

const options = computed(() => ({
    chart: { type: 'bar', toolbar: { show: false } },
    xaxis: { categories: allMonthLabels() },
    yaxis: { labels: { formatter: (v: number) => compactNumber(v) } },
}));
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10">
                <TrendingUp class="h-4 w-4 text-primary" />
            </div>
            <CardTitle>Chiffre d'affaires</CardTitle>
        </CardHeader>
        <CardContent>
            <VueApexCharts type="bar" :options="options" :series="series" height="300" />
        </CardContent>
    </Card>
</template>
```

---

## 10. DataTable

### Utilisation complète

```vue
<!-- Dans la page -->
<DataTable
    v-model:search="search"
    :columns="columns"
    :data="users.data"
    :meta="users.meta"
    :go-to-page="goToPage"
    :set-per-page="setPerPage"
    search-placeholder="Rechercher un utilisateur..."
/>
```

### Colonnes avec `h()` (render functions)

```ts
import { h } from 'vue';
import IdentityCell from '@/components/table-cell/IdentityCell.vue';
import { actionsColumn } from '@/composables/table/actionsColumn';

export function useUserColumns(): ColumnDef<User>[] {
    return [
        {
            id: 'identity',
            header: 'Utilisateur',
            cell: ({ row }) =>
                h(IdentityCell, {
                    name: row.original.full_name,
                    email: row.original.email,
                    avatar: row.original.avatar_url,
                }),
        },
        {
            accessorKey: 'role',
            header: 'Rôle',
            cell: ({ row }) => h(StatusBadge, { status: row.original.role }),
        },
        actionsColumn<User>({
            edit: { url: (id) => UserController.edit(id) },
            delete: { url: (id) => UserController.destroy(id) },
        }),
    ];
}
```

---

## 11. Modales & Confirmation

### Pattern ConfirmModal

```vue
<ConfirmModal
    :title="`Supprimer ${item.name} ?`"
    description="Cette action est irréversible."
    confirm-text="Supprimer"
    confirm-variant="destructive"
    :loading="deleting"
    @confirm="handleDelete"
>
    <template #trigger>
        <Button variant="ghost" size="icon-sm">
            <Trash2 class="h-4 w-4" />
        </Button>
    </template>
</ConfirmModal>
```

---

## 12. Tailwind & Styling

### Classes récurrentes

```
/* Sections formulaire */
rounded-2xl border bg-white p-6 shadow-xs

/* Grille responsive */
grid grid-cols-1 gap-6 md:grid-cols-2

/* Badge icône widget */
flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10

/* Texte erreur */
text-sm text-destructive

/* Bouton submit fixe */
fixed top-5 right-10 z-50
```

### Utility `cn()`

```ts
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}
```

Utiliser `cn()` pour combiner des classes conditionnelles dans les composants :

```vue
<div :class="cn('base-class', isActive && 'bg-primary text-white')">
```

---

## 13. Checklist qualité

Avant chaque PR, vérifier :

- [ ] `<script setup lang="ts">` sur tous les composants
- [ ] Props typées avec `defineProps<T>()`
- [ ] Emits typés avec `defineEmits<T>()`
- [ ] `import type` pour les imports de types
- [ ] Ordre des imports respecté (Vue → Tiers → Composants → Composables → Routes → Types)
- [ ] Pas de `any` ni de routes hardcodées
- [ ] Composable avec type de retour explicite
- [ ] Validation inline sur les champs de formulaire
- [ ] Loading state sur les boutons de soumission
- [ ] Nommage cohérent (PascalCase composants, camelCase fonctions, use\* composables)
- [ ] Types dans `types/` et re-exportés dans `index.ts`
- [ ] Pas de logique métier dans `lib/utils.ts`
