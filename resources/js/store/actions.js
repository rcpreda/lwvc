import Peer from 'simple-peer'
import MediaHander from '../MediaHandler'
import Axios from 'axios'

export const setAuthUser = ({commit}, user) => {
    commit('SET_AUTH_USER', user)
}

export const destroyAuthUser = ({commit}) => {
    commit('DESTROY_AUTH_USER')
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

export const toggleMic = ({commit}, status) => {
    commit('TOGGLE_MIC', status)
}

export const showCallRequestPopup = ({commit}) => {
    commit('SET_CALL_REQUEST_POPUP', true)
}

export const hideCallRequestPopup = ({commit}) => {
    commit('SET_CALL_REQUEST_POPUP', false)
}

export const setIncomingCallData = ({commit}, data) => {
    commit('SET_INCOMING_CALL_DATA', data)
}

export const startCall = ({commit, state}, user) => {
    const mediaHandler = new MediaHander;
    
    mediaHandler.getPermissions().then((stream) => {
        console.log(process.env.MIX_STUN_USERNAME)
        const peer1 = new Peer({
            initiator: true, 
            trickle: false,
            stream: stream,
            config: {
                iceServers: [
                    {
                        urls: process.env.MIX_TURN_URLS,
                        username: process.env.MIX_TURN_USERNAME,
                        credential: process.env.MIX_TURN_PASSWORD
                    },
                    {
                        urls: process.env.MIX_STUN_URLS,
                        username: process.env.MIX_STUN_USERNAME,
                        credential: process.env.MIX_STUN_PASSWORD
                    }
                ]
            },
        })
        
        peer1.on("signal", data => {
            const channel = Echo.private(`video-call.${user.id}`)
            Axios.post("/signals", {
                data: JSON.stringify(data),
            }).then(res => {
                setTimeout(() => {
                    channel.whisper('incomingVideoCall', {
                        signalID: res.data.signal.id,
                    });
                }, 500);
            })
        })
        commit('SET_PEER', peer1)
        commit('SET_CALLING_USER', user)
        commit('SET_MYSTREAM', stream)
    })
}

export const acceptCall = ({commit, state}) => {
    const mediaHandler = new MediaHander;
    mediaHandler.getPermissions().then((stream) => {

        const peer2 = new Peer({
            trickle: false,
            stream: stream,
        })

        peer2.signal(JSON.parse(state.incomingCallData.data))

        peer2.on("signal", data => {
            const channel = Echo.private(`video-call.${state.incomingCallData.user.id}`)
            Axios.post("/signals", {
                data: JSON.stringify(data),
            }).then(res => {
                commit('SET_CALLING_USER', state.incomingCallData.user)
                setTimeout(() => {
                    channel.whisper('videoCallAccepted', {
                        signalID: res.data.signal.id,
                    });
                }, 500);
            })
        })

        peer2.on('stream', stream => {
            commit('SET_OTHERSTREAM', stream)
        })

        commit('SET_PEER', peer2)
        commit('SET_MYSTREAM', stream)
        commit('SET_CALLING_USER', state.incomingCallData.user)
    })
}

export const callAccepted = ({commit, state}) => {
    const peer1 = state.peer
    peer1.signal(JSON.parse(state.incomingCallData.data))
    peer1.on('stream', stream => {
        commit('SET_OTHERSTREAM', stream)
    })
}

// Done

export const rejectCall = ({commit, state}) => {
    const channel = Echo.private(`video-call.${state.incomingCallData.user.id}`)
    setTimeout(() => {
        channel.whisper('videoCallRejected', {
            fromUser: state.authUser,
        });
    }, 3000);
    commit('DESTROY_INCOMING_CALL_DATA')
}

export const callRejected = ({commit}) => {
    commit('DESTROY_MYSTREAM')
}

export const callEnded = ({commit}) => {
    commit('SET_CALL_REQUEST_POPUP', false)
    commit('DESTROY_MYSTREAM')
}

export const endCall = ({commit, state}) => {
    const channel = Echo.private(`video-call.${state.callingUser.id}`)
    setTimeout(() => {
        channel.whisper('videoCallEnded', {
            fromUser: state.authUser,
        });
    }, 3000);
    commit('DESTROY_MYSTREAM')
}