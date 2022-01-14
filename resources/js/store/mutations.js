export const SET_AUTH_USER = (state, user) => {
    state.authUser = user
}

export const SET_ONLINE_USERS = (state, users) => {
    const index = users.findIndex( user => user.id === state.authUser.id );
    users.splice(index, 1 );
    state.onlineUsers = users
}

export const INSERT_ONLINE_USER = (state, user) => {
    state.onlineUsers.push(user)
}

export const REMOVE_ONLINE_USER = (state, user) => {
    const index = state.onlineUsers.findIndex( item => item.id === user.id );
    state.onlineUsers.splice(index, 1)
}

export const START_CALL = (state, {user, stream}) => {
    state.callingUser = user
    state.myStream = stream
}

export const END_CALL = (state) => {
    state.myStream.getTracks().forEach(function(track) {
        track.stop();
    });
    state.myStream = null
}

export const TOGGLE_MIC = (state, status) => {
    state.myStream.getAudioTracks()[0].enabled = status
}