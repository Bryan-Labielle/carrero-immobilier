# Inertia Pages

Pages live in `resources/js/Pages/`. Routing is handled by Laravel (`routes/web.php`), not by Vue Router.

## Fetch documentation

- Fetch <https://inertiajs.com/> for up-to-date API reference.

## Page props

Props come from the Laravel controller via `Inertia::render()`:

```vue
<script setup lang="ts">
defineProps<{
    users: App.Models.User[];
    filters: { search: string };
}>();
</script>
```

Controller side:

```php
return Inertia::render('Users/Index', [
  'users' => $users,
  'filters' => $request->only('search'),
]);
```

## Router

NEVER use `<a href>` for internal navigation. Use Inertia's router or `<Link>`:

```vue
<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="route('users.show', user.id)">View</Link>
    <Link :href="route('users.index')" preserve-scroll>Users</Link>
</template>
```

Programmatic navigation:

```ts
import { router } from '@inertiajs/vue3';

router.visit(route('users.index'));

router.visit(route('users.index'), {
    method: 'get',
    data: { search: 'john' },
    preserveState: true,
    preserveScroll: true,
    only: ['users'], // partial reload
});

// Shorthand methods
router.get(url, data, options);
router.post(url, data, options);
router.put(url, data, options);
router.delete(url, options);

// Replace history (no back button)
router.visit(url, { replace: true });
```

## Forms

Use `useForm` for forms with validation, processing state, and dirty tracking:

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    avatar: null as File | null,
});

function submit() {
    form.post(route('users.store'), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <input v-model="form.name" />
        <p v-if="form.errors.name">{{ form.errors.name }}</p>

        <input v-model="form.email" />
        <p v-if="form.errors.email">{{ form.errors.email }}</p>

        <button :disabled="form.processing">Save</button>
    </form>
</template>
```

Key `useForm` properties:

- `form.errors` : server validation errors (from Laravel's `$request->validate()`)
- `form.processing` : `true` while request is in flight
- `form.isDirty` : `true` if any field changed since last reset
- `form.reset()` / `form.reset('name')` : reset all or specific fields
- `form.clearErrors()` : clear validation errors
- `form.transform(data => ...)` : transform data before sending

### File uploads

```ts
form.post(route('users.store'), {
    forceFormData: true, // force multipart even without files
});
```

## Shared data

Access data shared from Laravel middleware (`HandleInertiaRequests`):

```vue
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage<{
    auth: { user: App.Models.User };
    flash: { success?: string; error?: string };
}>();

const user = page.props.auth.user;
</script>
```

## Persistent layouts

Prevent layout re-rendering on navigation:

```vue
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });
</script>

<template>
    <!-- Page content only, layout wraps automatically -->
</template>
```

Nested layouts:

```ts
defineOptions({ layout: [AppLayout, SettingsLayout] });
```

## Partial reloads

Reload only specific props without a full page visit:

```ts
router.reload({ only: ['users'] });
```

## SEO / Head

```vue
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>Users</title>
        <meta name="description" content="User management" />
    </Head>
</template>
```
