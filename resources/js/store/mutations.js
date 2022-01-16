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

export const ACCEPT_CALL = (state, {user, stream}) => {
    state.callingUser = user
    state.myStream = stream
}

export const CALL_ACCEPTED = (state, {otherStream}) => {
    state.otherStream = otherStream
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

export const SET_PEER = (state, peer) => {
    state.peer = peer
}

export const CALL_REJECTED = (state) => {
    state.peer = null
    state.myStream.getTracks().forEach(function(track) {
        track.stop();
    });
    state.myStream = null
}

export const SET_CALL_REQUEST_POPUP = (state, status) => {
    state.displayCallRequestPopup = status
}