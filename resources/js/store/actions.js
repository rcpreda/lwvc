import MediaHander from '../MediaHandler'

export const setAuthUser = ({commit}, user) => {
    commit('SET_AUTH_USER', user)
}

export const setOnlineUsers = ({commit}, users) => {
    commit('SET_ONLINE_USERS', users)
}

export const insertOnlineUser = ({commit}, user) => {
    commit('INSERT_ONLINE_USER', user)
}

export const removeOnlineUser = ({commit}, user) => {
    commit('REMOVE_ONLINE_USER', user)
}

export const startCall = ({commit}, user) => {
    const mediaHandler = new MediaHander;
    mediaHandler.getPermissions().then((stream) => {
        commit('START_CALL', { user: user, stream: stream })
    })
}

export const endCall = ({commit}) => {
    commit('END_CALL')
}


export const toggleMic = ({commit}, status) => {
    commit('TOGGLE_MIC', status)
}