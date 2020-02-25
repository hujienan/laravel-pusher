<template>
    <div>
        <div>
            <p>Online users:</p>
            <h3 v-for="(user, index) in users" :key="index">{{user.name}} </h3>
        </div>
        <div class="panel-body">
            <chat-messages :messages="messages"></chat-messages>
        </div>
        <div class="panel-footer">
            <chat-form
                @messagesent="addMessage"
                :user="user"
            ></chat-form>
        </div>
    </div>
</template>
<script>
import ChatMessage from './ChatMessages';
import ChatForm from './ChatForm';
export default {
    props: ['user'],
    data: function () {
        return {
            messages: [],
            users: [],
        }
    },
    created() {
        this.fetchMessages();
        Echo.private('chat').listen('MessageSent', (e) => {
            this.messages.push({
                message: e.message.message,
                user: e.user
            });
        });
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
              console.log(response.data);
            });
        }
    },
    mounted: function () {
        Echo.join('online')
            .here(users => (this.users = users))
            .joining(user => this.users.push(user))
            .leaving(user => (this.users = this.users.filter(u => (u.id !== user.id))))
    },
    components: {
        ChatForm,
        ChatMessage
    },
}
</script>