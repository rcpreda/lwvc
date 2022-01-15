import { stream } from 'browser-sync'
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
        const peer = new Peer({
            initiator: true, 
            trickle: false,
            stream: stream
        })
        
        peer.on("signal", data => {
            const channel = Echo.private(`video-call.${user.id}`)
            setTimeout(() => {
                channel.whisper('incomingVideoCall', {
                    fromUser: state.authUser,
                    signalData: data
                });
            }, 500);
        })
        commit('SET_PEER', peer)
        commit('START_CALL', { user: user, stream: stream })
    })
}

export const acceptCall = ({commit, state}, {fromUser, signalData}) => {
    const mediaHandler = new MediaHander;
    mediaHandler.getPermissions().then((stream) => {

        const peer = new Peer()

        peer.on("signal", data => {
            const channel = Echo.private(`video-call.${fromUser.id}`)
            setTimeout(() => {
                channel.whisper('videoCallAccepted', {
                    fromUser: state.authUser,
                    signalData: data
                });
            }, 500);
        })

        peer.signal(signalData)

        commit('SET_PEER', peer)
        commit('ACCEPT_CALL', { user: fromUser, stream: stream })
    })
}

export const callAccepted = ({ state}, {signalData}) => {
    const peer = state.peer
    peer.signal(signalData)
    peer.on('stream', stream => {
        console.log(stream)
    })
}

export const endCall = ({commit}) => {
    commit('END_CALL')
}


export const toggleMic = ({commit}, status) => {
    commit('TOGGLE_MIC', status)
}