export default {
    changeLoading(state, payload) {

        // Hard Reset - Prevents loading to get stuck 
        setInterval(_ => {
            state.loading = false
        }, 5000);

        return state.loading = payload
    },
    addNotification(state, payload) {

        if(payload.autoClear) {
            setTimeout(() => {
                
                let index = state.notifications.findIndex(notification => {
                    return notification.id == payload
                })
        
                state.notifications.splice(index, 1)

            }, 5000)
        }

        return state.notifications.push(payload)
    },
    clearNotification(state, payload) {

        let index = state.notifications.findIndex(notification => {
            return notification.id == payload
        })

        return state.notifications.splice(index, 1)
    },
    changeUser(state, payload) {
        return state.user = payload
    }
}