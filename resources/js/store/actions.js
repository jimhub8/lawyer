import axios from "axios";
export default {
    alertEvent(context, payload) {
        eventBus.$emit('alertRequest', payload)
        // context.commit('alertEvent', payload)
    },

    errorEvent(context, payload) {
        eventBus.$emit('errorEvent', payload)
        // context.commit('alertEvent', payload)
    },

    // GET
    getUsers(context) {
        context.commit('loading', true)
        axios.get('users').then((response) => {
            context.commit('updateUsersList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getClients(context) {
        context.commit('loading', true)
        axios.get('clients').then((response) => {
            context.commit('updateClientList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    searchClient(context, payload) {
        // console.log(payload);
        context.commit('loading', true)
        axios.get(`searchClient/${payload}`).then((response) => {
            context.commit('updateClientSearchList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getRoles(context) {
        context.commit('loading', true)
        axios.get('roles').then((response) => {
            context.commit('updateRoleList', response.data)
            context.commit('loading', false)
        }).catch((error) => {
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getFirms(context) {
        context.commit('loading', true)
        axios.get('firms').then((response) => {
            context.commit('updateFirmList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getCases(context) {
        context.commit('loading', true)
        axios.get('cases').then((response) => {
            context.commit('updateCasesList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getStatus(context) {
        context.commit('loading', true)
        axios.get('status').then((response) => {
            context.commit('updatStatusList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getPracticeArea(context) {
        context.commit('loading', true)
        axios.get('practice').then((response) => {
            context.commit('updatPracticeList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

}
