// store.js
import { reactive, readonly } from "vue";

// Define the state
const state = reactive({
  activeFilters: [],
  searchTerm: "",
  filteredResults: false,
});

// Define actions
const actions = {
  setActiveFilters(value) {
    state.activeFilters = value;
  },

  setFilteredResults(value) {
    state.filteredResults = value;
  },

  setSearchTerm(value) {
    state.searchTerm = value;
  },
};

export function useUIStore() {
  return {
    state: readonly(state), // Use readonly to prevent direct state mutation outside the store
    actions,
  };
}
