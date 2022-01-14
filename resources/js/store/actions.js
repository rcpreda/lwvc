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