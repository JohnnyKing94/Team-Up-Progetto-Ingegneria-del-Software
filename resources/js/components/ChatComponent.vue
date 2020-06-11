<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Chat</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                            <strong>{{ message.user.name }} {{ message.user.surname }}</strong>
                            <span class="float-right"><vue-moments-ago prefix="" suffix="ago" v-bind:date="message.date" lang="it"></vue-moments-ago></span>
                            <br />
                            {{ message.message }}
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <div class="input-group">
                            <input
                                    @keydown="sendTypingEvent"
                                    @keyup.enter="sendMessage"
                                    v-model="newMessage"
                                    type="text"
                                    name="message"
                                    placeholder="Enter your message..."
                                    class="form-control input-sm">
                            <div class="input-group-append">
                                <button @click.prevent="sendMessage" class="btn btn-dark btn-sm" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-muted" v-if="activeUser">{{ activeUser.name }} sta scrivendo...</span>
        </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Utenti online</div>
                <div class="card-body">
                    <button class="btn btn-secondary btn-block">{{user.name}} {{user.surname}} <i class="fas fa-circle" style="color: #00f500;"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueMomentsAgo from 'vue-moments-ago';
    export default {
        components: {
            VueMomentsAgo
        },
        props: ['user', 'project'],
        data() {
            return {
                project_id: this.project.id,
                messages: [],
                newMessage: '',
                users: [],
                activeUser: false,
                typingTimer: false,
            }
        },
        created() {
            this.fetchMessages();
            Echo.join('chat.' + this.project.id)
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    if (this.users.find(e => e.name == user.name)) return;
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('.NewMessage', (event) => {
                    this.messages.push(event.message);
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;
                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 1000);
                })
        },
        methods: {
            fetchMessages() {
                axios.get('/project/' + this.project.slug + '/chat/messages').then(response => {
                    this.messages = response.data;
                })
            },
            sendMessage() {
                this.messages.push({
                    user: this.user,
                    project: this.project,
                    message: this.newMessage
                });
                axios.post('/project/' + this.project.slug + '/chat/messages', {
                    project_slug: this.project.slug,
                    message: this.newMessage
                });
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('chat.' + this.project.id)
                    .whisper('typing', this.user);
            }
        }
    }
</script>