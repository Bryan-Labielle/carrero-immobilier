# Vue Composables

Composables are functions that encapsulate and reuse stateful logic using the Composition API.

## Naming

- ALWAYS prefix with `use`: `useCounter`, `useAuth`, `useDarkMode`.
- File name matches function name: `useCounter.ts` exports `useCounter`.
- ALWAYS use named exports: `export function useCounter()`, never default export.

## Structure

```ts
import { ref, computed, onMounted, onUnmounted } from 'vue';

export function useCounter(initial = 0) {
    const count = ref(initial);
    const doubled = computed(() => count.value * 2);

    function increment() {
        count.value++;
    }

    function reset() {
        count.value = initial;
    }

    return { count, doubled, increment, reset };
}
```

## Rules

- Accept reactive inputs via getter functions or refs. Use `toValue()` to normalize:

```ts
import { toValue, watchEffect, type MaybeRefOrGetter } from 'vue';

export function useTitle(title: MaybeRefOrGetter<string>) {
    watchEffect(() => {
        document.title = toValue(title);
    });
}
```

- Return an object of refs/computeds, not a reactive object. This preserves reactivity on destructuring:

```ts
// ✅
return { count, doubled };

// ❌ loses reactivity on destructure
return reactive({ count, doubled });
```

- Use named functions for methods, not arrow functions:

```ts
// ✅
function increment() {
    count.value++;
}

// ❌
const increment = () => {
    count.value++;
};
```

- Keep composables focused on one concern. Compose multiple composables rather than building monoliths.
- Lifecycle hooks (`onMounted`, `onUnmounted`) are allowed inside composables. They bind to the component that calls the composable.
- Side effects (event listeners, timers) MUST be cleaned up in `onUnmounted` or via `watchEffect` auto-cleanup.

## Async composables

For async operations, return loading/error state:

```ts
import { ref, shallowRef } from 'vue';

export function useFetch<T>(url: MaybeRefOrGetter<string>) {
    const data = shallowRef<T | null>(null);
    const error = shallowRef<Error | null>(null);
    const isLoading = ref(false);

    async function execute() {
        isLoading.value = true;
        error.value = null;
        try {
            const response = await fetch(toValue(url));
            data.value = await response.json();
        } catch (e) {
            error.value = e as Error;
        } finally {
            isLoading.value = false;
        }
    }

    return { data, error, isLoading, execute };
}
```

Use `shallowRef` for non-primitive data to avoid deep reactivity overhead.

## Testing

- Test composables independently from components.
- Wrap in a test component or use `@vue/test-utils` `mount` if lifecycle hooks are needed.
- For composables without lifecycle hooks, call directly in tests.
