export default {
    loading(state) {
        return state.loading;
    },
    error(state) {
        return state.error;
    },
    alertEvent(state) {
        eventBus.$emit('alertEvent', state)
        // return state.alertEvent;
    },
    users(state) {
        return state.users
    },
    clients(state) {
        return state.clients;
    },
    roles(state) {
        return state.roles
    },
    seachClient(state) {
        return state.seachClient;
    },
    firms(state) {
        return state.firms;
    },
    cases(state) {
        return state.cases;
    },
    status(state) {
        return state.status;
    },
    practice_area(state) {
        return state.practice_area;
    },

    // Notifications
    notifications(state) {
        return state.notifications;
    },
}
