// store.js
import { reactive, readonly } from "vue";

// Define the state
const state = reactive({
  userTags: [],
});

// Define actions
const actions = {
  setUserTags(value) {
    state.userTags = value;
  },
};

export function useUserStore() {
  return {
    state: readonly(state), // Use readonly to prevent direct state mutation outside the store
    actions,
  };
}
