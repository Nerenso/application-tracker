// store.js
import { reactive, readonly } from "vue";

// Define the state
const state = reactive({
  activeFilters: [],
  searchTerm: "",
  filteredResults: false,
  showAddListingForm: false,
  showAddActivityForm: false,
  selectedListingID: null,
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

  setShowAddListingForm(value) {
    state.showAddListingForm = value;
  },

  setSelectedListingID(value) {
    state.selectedListingID = value;
  },

  setShowAddActivityForm(value) {
    state.showAddActivityForm = value;
  },
};

export function useUIStore() {
  return {
    state: readonly(state), // Use readonly to prevent direct state mutation outside the store
    actions,
  };
}
