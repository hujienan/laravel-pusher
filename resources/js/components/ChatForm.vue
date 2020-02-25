<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your
        message here..." v-model="newMessage" @keyup.enter="sendMessage" @keydown="isTyping" @keyup="notTyping">

        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
        <span v-show="typing" class="help-block" style="font-style: italic;">
            @{{ typingUser.name }} is typing...
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newMessage: '',
                typing: false,
                typingUser: {}
            }
        },

        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage
                });

                this.newMessage = ''
            },
            isTyping() {
                console.log("is typing");
                let channel = Echo.private('chat');
                let vm = this;
                setTimeout(function() {
                    channel.whisper('typing', {
                        user: vm.user,
                        typing: vm.typing
                    });
                }, 300);
            },
            notTyping() {
                let channel = Echo.private('chat');
                let vm = this;
                vm.typing = false;
                setTimeout(function() {
                    channel.whisper('typing', {
                        user: vm.user,
                        typing: vm.typing
                    });
                }, 300);
            }
        },
        created() {
            let vm = this;

            Echo.private('chat')
                .listenForWhisper('typing', (e) => {
                vm.typingUser = e.user;
                vm.typing = e.typing;

                // remove is typing indicator after 0.9s
                setTimeout(function() {
                    vm.typing = false
                }, 900);
                });
        }    
    }
</script>