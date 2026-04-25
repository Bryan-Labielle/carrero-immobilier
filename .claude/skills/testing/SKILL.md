---
name: testing
description: >
  Testing Vue 3 components and composables with Vitest and Vue Test Utils.
  TRIGGER when: writing or editing tests, setting up test infrastructure, or debugging test failures in Vue projects.
metadata:
  version: '1.0.0'
---

# Testing Vue Applications

Stack: Vitest + `@vue/test-utils`. Tests live alongside the file they test: `Button.vue` + `Button.spec.ts`.

## Fetch documentation

- Fetch <https://vitest.dev/llms.txt> for up-to-date Vitest API.
- Fetch <https://test-utils.vuejs.org/llms.txt> for Vue Test Utils API.

## Running tests

```sh
pnpm vitest run                    # all tests
pnpm vitest run src/ui/Button      # specific file (partial match works)
pnpm vitest run --coverage         # with coverage report
```

## Component tests

```ts
import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Counter from './Counter.vue'

describe('Counter', () => {
  it('increments count on click', async () => {
    const wrapper = mount(Counter, {
      props: { initial: 5 },
    })

    expect(wrapper.text()).toContain('5')
    await wrapper.find('button').trigger('click')
    expect(wrapper.text()).toContain('6')
  })

  it('emits update event', async () => {
    const wrapper = mount(Counter)
    await wrapper.find('button').trigger('click')
    expect(wrapper.emitted('update')).toHaveLength(1)
    expect(wrapper.emitted('update')![0]).toEqual([1])
  })
})
```

## Rules

- Test behavior, not implementation. Query by text, role, or test-id, not by component internals.
- Use `mount` (not `shallowMount`) for integration tests. Use `shallowMount` only when child components are irrelevant.
- ALWAYS `await` after triggering events or changing reactive state: `await wrapper.find('button').trigger('click')`.
- Use `wrapper.vm` sparingly. Prefer asserting on rendered output.

## Providing dependencies

Stub stores, Inertia components, and plugins via `global`:

```ts
mount(MyComponent, {
  global: {
    plugins: [createTestingPinia({ createSpy: vi.fn })],
    stubs: { Link: true, Head: true }, // Inertia components
  },
})
```

For Pinia, use `@pinia/testing`:

```ts
import { createTestingPinia } from '@pinia/testing'

const wrapper = mount(MyComponent, {
  global: {
    plugins: [
      createTestingPinia({
        initialState: {
          cart: { items: [{ id: '1', name: 'Item', price: 10, quantity: 2 }] },
        },
      }),
    ],
  },
})
```

## Inertia page components

Mock `usePage` and `useForm` when testing Inertia pages:

```ts
import { vi } from 'vitest'

vi.mock('@inertiajs/vue3', async () => {
  const actual = await vi.importActual('@inertiajs/vue3')
  return {
    ...actual,
    usePage: () => ({
      props: {
        auth: { user: { id: 1, name: 'John' } },
        flash: {},
      },
    }),
  }
})
```

For page components that receive props from the controller, pass them directly:

```ts
mount(UsersIndex, {
  props: {
    users: [{ id: 1, name: 'John' }],
    filters: { search: '' },
  },
})
```

Laravel feature tests with Inertia assertions (PHP side):

```php
$this->get('/users')
    ->assertInertia(fn (Assert $page) => $page
        ->component('Users/Index')
        ->has('users', 5)
        ->where('filters.search', '')
    );
```

## Composable tests

Composables without lifecycle hooks can be tested directly:

```ts
import { describe, it, expect } from 'vitest'
import { useCounter } from './useCounter'

describe('useCounter', () => {
  it('increments', () => {
    const { count, increment } = useCounter()
    expect(count.value).toBe(0)
    increment()
    expect(count.value).toBe(1)
  })
})
```

Composables with lifecycle hooks need a host component:

```ts
import { mount } from '@vue/test-utils'
import { defineComponent } from 'vue'

function withSetup<T>(composable: () => T) {
  let result!: T
  mount(defineComponent({
    setup() {
      result = composable()
      return () => null
    },
  }))
  return result
}

it('useMousePosition tracks position', () => {
  const { x, y } = withSetup(() => useMousePosition())
  expect(x.value).toBe(0)
})
```

## Async tests

```ts
it('loads data', async () => {
  const wrapper = mount(UserList)
  // Wait for async setup / suspense
  await flushPromises()
  expect(wrapper.findAll('li')).toHaveLength(3)
})
```

Import `flushPromises` from `@vue/test-utils`.
