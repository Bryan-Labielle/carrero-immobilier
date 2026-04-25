# Pinia Stores

Pinia is the official state management for Vue. Use it for global state shared across components. Do NOT use it for data fetching (use a composable instead).

## Fetch documentation

- Fetch <https://pinia.vuejs.org/llms.txt> and follow links for up-to-date information not covered here.

## Naming

- ALWAYS prefix with `use` and suffix with `Store`: `useAuthStore`, `useCartStore`.
- File name: `auth.ts` in `resources/js/Stores/`.
- ALWAYS use named exports.

## Setup stores (preferred)

Use the setup syntax. It maps directly to the Composition API:

```ts
import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', () => {
    // state
    const items = ref<CartItem[]>([]);

    // getters
    const totalPrice = computed(() => items.value.reduce((sum, item) => sum + item.price * item.quantity, 0));

    const isEmpty = computed(() => items.value.length === 0);

    // actions
    function addItem(product: Product, quantity = 1) {
        const existing = items.value.find((item) => item.id === product.id);
        if (existing) {
            existing.quantity += quantity;
        } else {
            items.value.push({ ...product, quantity });
        }
    }

    function removeItem(productId: string) {
        items.value = items.value.filter((item) => item.id !== productId);
    }

    function clear() {
        items.value = [];
    }

    return { items, totalPrice, isEmpty, addItem, removeItem, clear };
});
```

## Rules

- `ref()` = state, `computed()` = getters, plain functions = actions.
- ALWAYS use named functions for actions, not arrow functions.
- Keep stores focused on one domain. Compose stores by calling one from another:

```ts
export const useCheckoutStore = defineStore('checkout', () => {
    const cart = useCartStore();
    const auth = useAuthStore();

    async function checkout() {
        if (cart.isEmpty) throw new Error('Cart is empty');
        // use cart.items, auth.user, etc.
    }

    return { checkout };
});
```

- Do NOT destructure a store directly. Use `storeToRefs()` for reactive state/getters:

```vue
<script setup lang="ts">
import { storeToRefs } from 'pinia';

const cartStore = useCartStore();
const { items, totalPrice } = storeToRefs(cartStore);
// actions can be destructured directly
const { addItem, removeItem } = cartStore;
</script>
```

- State should be serializable. Avoid storing class instances, functions, or DOM elements.
- Use `$reset()` only with option stores. Setup stores need a manual `reset()` action.

## Persisting state

Use `pinia-plugin-persistedstate` for localStorage/sessionStorage persistence:

```ts
export const useAuthStore = defineStore(
    'auth',
    () => {
        const token = ref<string | null>(null);
        // ...
        return { token };
    },
    {
        persist: true, // or { key: 'auth', storage: sessionStorage }
    },
);
```
