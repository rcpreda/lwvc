import Peer from 'simple-peer'
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

export const startCall = ({commit, state}, user) => {
    const mediaHandler = new MediaHander;
    
    mediaHandler.getPermissions().then((stream) => {
        const peer1 = new Peer({
            initiator: true, 
            trickle: false,
            stream: stream
        })
        
        peer1.on("signal", data => {
            const channel = Echo.private(`video-call.${user.id}`)
            setTimeout(() => {
                channel.whisper('incomingVideoCall', {
                    fromUser: state.authUser,
                    signalData: data
                });
            }, 1000);
        })
        commit('SET_PEER', peer1)
        commit('START_CALL', { user: user, stream: stream })
    })
}

export const acceptCall = ({commit, state}, {fromUser, signalData}) => {
    const mediaHandler = new MediaHander;
    mediaHandler.getPermissions().then((stream) => {

        const peer2 = new Peer({
            trickle: false, 
            stream: stream 
        })

        peer2.signal(signalData)
        peer2.on("signal", data => {
            const channel = Echo.private(`video-call.${fromUser.id}`)
            setTimeout(() => {
                channel.whisper('videoCallAccepted', {
                    fromUser: state.authUser,
                    signalData: data
                });
            }, 1000);
        })

        peer2.on('stream', stream => {
            commit('CALL_ACCEPTED', { otherStream: stream })
        })

        commit('SET_PEER', peer2)
        commit('ACCEPT_CALL', { user: fromUser, stream: stream })
    })
}

export const callAccepted = ({commit, state}, {signalData}) => {
    const peer1 = state.peer
    peer1.signal(signalData)
    peer1.on('stream', stream => {
        commit('CALL_ACCEPTED', { otherStream: stream })
    })
}

export const endCall = ({commit}) => {
    commit('END_CALL')
}

export const toggleMic = ({commit}, status) => {
    commit('TOGGLE_MIC', status)
}