import { createStore } from 'vuex'
import { router } from '@inertiajs/vue3'

export const store = createStore({
    state: {
       selected_client: "",
       selected_client_work: "",
       only_active_works: false,
    },

    mutations: {
        setSelectedClient (state, value) {
            state.selected_client = value
        },
        setSelectedClientWork (state, value) {
            state.selected_client_work = value
        },
        setOnlyActiveWorks (state, value) {
            state.only_active_works = value
        },
    },

    getters: {
        selectedClient: state => {
            return state.selected_client
        },

        selectedClientWork: state => {
            return state.selected_client_work
        },

        onlyActiveWorks: state => {
            return state.only_active_works
        }
    },

    actions: {
        initialSetings(context) {

        }
    }
  })
