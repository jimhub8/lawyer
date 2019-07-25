export default {
    loading(state, payload) {
        state.loading = payload
    },
    error(state, payload) {
        state.error = payload
    },
    updateClientList(state, payload) {
        state.clients = payload
    },
    updateClientSearchList(state, payload) {
        state.seachClient = payload
    },
    alertEvent(state, payload) {
        state.alertEvent = payload
    },
    updateUsersList(state, payload) {
        state.users = payload
    },
    updateRoleList(state, payload) {
        state.roles = payload
    },

    updateFirmList(state, payload) {
        state.firms = payload
    },
    updateCasesList(state, payload) {
        state.cases = payload
    },

    updatStatusList(state, payload) {
        state.status = payload
    },
    updatPracticeList(state, payload) {
        state.practice_area = payload
    },
    // Notifications
    updatenotifications(state, payload) {
        state.notifications = payload
    },
}
