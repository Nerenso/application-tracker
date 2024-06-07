// store.js
import { reactive, readonly } from "vue";

// Define the state
const state = reactive({
  showMore: false,
  // other global state
});

// Define actions
const actions = {
  setShowMore(value) {
    state.showMore = value;
  },
};

export function useListingDetailStore() {
  return {
    state: readonly(state), // Use readonly to prevent direct state mutation outside the store
    actions,
  };
}
