# Vue Components

## Naming

- PascalCase for file names (`UserProfile.vue`) or kebab-case (`user-profile.vue`). Pick one, stay consistent.
- PascalCase for component names in `<script>` and `<template>`.
- Compose names general-to-specific: `SearchButtonClear.vue` not `ClearSearchButton.vue`.

## Props

- Define with `defineProps<{ propOne: number }>()` and TypeScript types.
- Do NOT assign to `const props =` unless props are used in the script block.
- Destructure props to declare defaults:

```vue
<script setup lang="ts">
const { count = 0, label } = defineProps<{
    count?: number;
    label: string;
}>();
</script>
```

## Emits

- ALWAYS type emits for type safety:

```vue
<script setup lang="ts">
const emit = defineEmits<{
    update: [value: string];
    close: [];
}>();
</script>
```

## v-model with `defineModel()`

Replaces the manual `modelValue` prop + `update:modelValue` emit pattern.

```vue
<script setup lang="ts">
// Simple binding
const title = defineModel<string>();

// With options and modifiers
const [title, modifiers] = defineModel<string>({
    default: 'default value',
    required: true,
    get: (value) => value.trim(),
    set: (value) => {
        if (modifiers.capitalize) {
            return value.charAt(0).toUpperCase() + value.slice(1);
        }
        return value;
    },
});
</script>
```

### Multiple models

Name them explicitly:

```vue
<script setup lang="ts">
const firstName = defineModel<string>('firstName');
const age = defineModel<number>('age');
</script>
```

```html
<UserForm v-model:first-name="user.firstName" v-model:age="user.age" />
```

For custom modifiers, fetch and read <https://vuejs.org/guide/components/v-model.md#handling-v-model-modifiers>.

## Slots

- ALWAYS use the shorthand: `<template #default>` not `<template v-slot:default>`.
- ALWAYS use explicit `<template>` tags for ALL used slots.

## Template conventions

- kebab-case for props and events in templates: `<MyComponent :user-name="name" @item-click="handle" />`.
- camelCase in JS: `defineProps<{ userName: string }>()`.
- Prop shorthand when value matches name: `<MyComponent :count />` not `<MyComponent :count="count" />`.
