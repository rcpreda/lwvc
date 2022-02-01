export const SET_AUTH_USER = (state, user) => {
    state.authUser = user
    state.isAuthenticated = true
}

export const DESTROY_AUTH_USER = (state) => {
    state.authUser = null,
    state.isAuthenticated = false
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

export const SET_CALLING_USER = (state, user) => {
    state.callingUser = user
}

export const SET_MYSTREAM = (state, stream) => {
    state.myStream = stream
}

export const SET_OTHERSTREAM = (state, otherStream) => {
    state.otherStream = otherStream
}

export const DESTROY_OTHERSTREAM = (state) => {
    state.otherStream = null
}

export const DESTROY_MYSTREAM = (state) => {
    state.peer = null
    if(state.myStream){
        state.myStream.getTracks().forEach(function(track) {
            track.stop();
        });
    }
    state.myStream = null
}

export const TOGGLE_MIC = (state, status) => {
    state.myStream.getAudioTracks()[0].enabled = status
}

export const SET_PEER = (state, peer) => {
    state.peer = peer
}

export const SET_CALL_REQUEST_POPUP = (state, status) => {
    state.displayCallRequestPopup = status
}

export const SET_INCOMING_CALL_DATA = (state, data) => {
    state.incomingCallData = data
}

export const DESTROY_INCOMING_CALL_DATA = (state, data) => {
    state.incomingCallData = null
}