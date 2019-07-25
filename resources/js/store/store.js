import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default {
    state: {
        loading: false,
        error: null,
        users: [],
        seachClient: [],
        clients: [],
        roles: [],
        firms: [],
        status: [],
        practice_area: [],
        cases: [],
        // Notifications
        notifications: [],
    },
    getters,
    mutations,
    actions
}
